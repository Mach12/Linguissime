<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use AppBundle\Form\ChangeImageType;
use AppBundle\Utils\Model\ChangePassword;
use AppBundle\Utils\Form\ChangePasswordType;
use AppBundle\Utils\Form\ChangeAccountType;
use AppBundle\Entity\Badge;
use AppBundle\Entity\ExerciceDone;
use AppBundle\Entity\BadgeManager;
use AppBundle\Model\Contact;
use AppBundle\Model\Form\ContactType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Exercise;
use AppBundle\Entity\ExerciseType;

class DefaultController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {   
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array('last_username' => $lastUsername,'error' => $error));
    }

    /**
     * @Route("/exercise/{name}", name="show_exercise")
     * @Method({"GET"})
     */
    public function GetExerciseAction(Request $request, $name)
    {   
        $em = $this->getDoctrine()->getManager();
        $exercise = $em->getRepository('AppBundle:Exercise')->findByName($name);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
      //  $normalizer->setIgnoredAttributes(array('user','id'));

        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->serialize($exercise, 'json');

        return new Response($data);
    }

    /**
     * @Route("/user/settings/exercise", name="create_exercise")
     * @Method({"POST"})
     */
    public function ExerciseAction(Request $request)
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $exercise = new Exercise();

        $params = array();
        $content = $request->getContent();

        if (empty($content)) {
            return new JsonResponse("Your data are empty", 400);
        }

        $params = json_decode($content);

        $exercise->setName($params->name);

        $validator = $this->get('validator');
        $errors = $validator->validate($exercise);

         if (count($errors) > 0) {
            return new JsonResponse("the name is already taken", 400);
         }

        $exercise->setDifficulty($params->difficulty);
        $exercise->setDescription($params->description);
        $exercise->setDuration($params->duration);
        $exercise->setUser($user);

        $exercise->setData($params);

        $em = $this->getDoctrine()->getManager();
        $em->persist($exercise);
        $em->flush();

        return new JsonResponse("Your exercise has been created successfully");
    }

    /**
     * @Route("/user/dashboard", name="dashboard")
     * @Method({"GET"})
     */
    public function DashboardAction()
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('image', 'roles', 'password', 'plainPassword','salt','id','exercicedone'));

        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->serialize($user, 'json');

        return new Response($data);
    }

    /**
     * @Route("/user/badges", name="badges")
     * @Method({"GET"})
     */
    public function BadgesAction()
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $listBadgeAchivement = $em->getRepository('AppBundle:BadgeManager')->findByUser($user);

        if ($listBadgeAchivement == null) {
            return new JsonResponse("Aucun badge", 400);
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('user', '__initializer__', '__isInitialized__', '__cloner__','timestamp','offset','timezone','longitude','latitude','id'));

        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->serialize($listBadgeAchivement, 'json');

        return new Response($data);
    }

    /**
     * @Route("/user/settings/password", name="change_password")
     * @Method({"PUT"})
     */
    public function ChangePasswordAction(Request $request)
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $tab = $request->request->get('change_password');

        if (!$tab["newPassword"]) { 
             return new JsonResponse("invalid data", 400);
         } 
              
        $newPassword = $this->get('security.password_encoder')->encodePassword($user, $tab["newPassword"]);
        $user->setPassword($newPassword);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(array('success' => "Password change with success"));
    }

    /**
     * @Route("/user/settings/account", name="change_account")
     * @Method({"PUT"})
     */
    public function ChangeAccountAction(Request $request)
    {   
        $user =  $this->get('security.token_storage')->getToken()->getUser();


        var_dump($request->request->get('change_account[description]'));
        die();
       
        $form = $this->createForm(ChangeAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse("Your account has been updated successfully");
        }

        return new JsonResponse("invalid data", 400);
    }

    /**
     * @Route("/user/settings/image", name="change_image")
     * @Method({"PUT"})
     */
    public function ChangeImageAction(Request $request)
    {
        $image = $request->request->get('photo');

        $user =  $this->get('security.token_storage')->getToken()->getUser();
        $user->setImage($image);

        $image_path = md5(uniqid()).'.'.$image->guessExtension();
        $user->setPath($image_path);

        $client = $this->get('aws.s3');

        $result = $client->putObject([
            'Bucket' => 'img-pi',
            'Key'    =>  $image_path,
            'body' =>  $image
        ]);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse("Your account has been updated successfully");
    }

    /**
     * @Route("/settings/stats", name="update_stats")
     * @Method({"PUT"})
     */
    public function updateStatsAction(Request $request)
    {       
        $user =  $this->get('security.token_storage')->getToken()->getUser();

        $exercise = new ExerciceDone();

        $exercise->setName($request->request->get('name'));
        $exercise->setPoints($request->request->get('points'));

        $user->addExercicedone($exercise);

        $exercise->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return new JsonResponse("Success");
    }

    /**
     * @Route("/user/stats", name="show_stats")
     * @Method({"GET"})
     */
    public function showStatsAction()
    {       
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:ExerciceDone');

        $exercices = $repository->findByUser($user);

        if ($exercices == null) {
            return new JsonResponse("Aucun exercice fait");
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('user', '__initializer__', '__isInitialized__', '__cloner__','timestamp','offset','timezone','longitude','latitude','id'));

        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->serialize($exercices, 'json');

        return new Response($data);
    }


    /**
     * @Route("/settings/data", name="update_data")
     * @Method({"PUT"})
     */
    public function updateDataAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->setPoints($user->getPoints() + $request->request->get('points'));

        $em = $this->getDoctrine()->getManager();

        $listBadges = $em->getRepository('AppBundle:Badge')->findAll();
        $listBadgeAchivement = $em->getRepository('AppBundle:BadgeManager')->findByUser($user);

        $user->setLevel($user->getLevel() + 1);

        foreach ($listBadges as $badge)
        {  
            $found = false;

            foreach ($listBadgeAchivement as $badgeAchievement) 
            { 
                if($badgeAchievement->getBadge() == $badge)
                {
                    $found = true;
                    break;
                }
            }

            if (!$found)
            {
                if ($user->getPoints() >= $badge->getPoints())
                {   
                    $badgemanager = new BadgeManager();
                    $badgemanager->setUser($user);
                    $badgemanager->setBadge($badge);
                    $badgemanager->setDate(new \DateTime());

                    $em->persist($badgemanager);
                }
            }
        }

        $em->flush();

        return new JsonResponse("Your data have been updated with success !");
    }

    /**
     * @Route("contact", name="contact")
     * @Method({"POST"})
     */
    public function contactAction(Request $request)
    {   
        $contact = new Contact();
        $contact->setContent($request->request->get('content'));
        $contact->setEmail($request->request->get('email'));
        $contact->setSubject($request->request->get('subject'));

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($contact->getSubject() . " de" . $contact->getEmail())
            ->setFrom("agrandiere@intechinfo.fr")
            ->setTo("agrandiere@intechinfo.fr")
            ->setBody($contact->getContent());

            $this->get('mailer')->send($message);  

        return new JsonResponse("Your message has been sent");
    }

    public function registerAction(Request $request)
    {
       // return new JsonResponse($request);
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("Your account has been created with success");
        }
        return new JsonResponse("The data you have sent is not valid", 400);


    }

    /**
     * @Route("/invitation", name="invitation")
     * @Method({"GET"})
     */
    public function invitationAction()
    {   
        $user =  $this->get('security.token_storage')->getToken()->getUser();

        $fullname = $user->getUserName() . " " . $user->getName();

        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject("Rejoindre Linguissime")
            ->setFrom("agrandiere@intechinfo.fr")
            ->setTo("agrandiere@intechinfo.fr")
            ->setBody("Bonjour, Vous avez reçu une invitation de la part de " . $fullname . " pour essayer Linguissime. Vous pouvez vous rendre sur www.linguissime.com");

            $this->get('mailer')->send($message);

        return new JsonResponse("Your message has been sent");
    }
}
