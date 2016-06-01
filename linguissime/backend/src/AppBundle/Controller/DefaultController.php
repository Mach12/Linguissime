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
     * @Route("/user/dashboard", name="dashboard")
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
     */
    public function BadgesAction()
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $listBadgeAchivement = $em->getRepository('AppBundle:BadgeManager')->findByUser($user);

        if ($listBadgeAchivement == null) {
            return new JsonResponse("Aucun badge");
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
     */
    public function ChangePasswordAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $password = new ChangePassword();
       
        $form = $this->createForm(ChangePasswordType::class, $password);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $newPassword = $this->get('security.password_encoder')->encodePassword($user, $password->getNewPassword());
            $user->setPassword($newPassword);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse(array('success' => "Mot de passe changer avec succès"));
        }

        return new JsonResponse("Invalid Data", 400);

    }

    /**
     * @Route("/user/settings/account", name="change_account")
     */
    public function ChangeAccountAction(Request $request)
    {
        $user =  $this->get('security.token_storage')->getToken()->getUser();
       
        $form = $this->createForm(ChangeAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new JsonResponse("work");
        }

        return new JsonResponse("error", 400);
    }

    /**
     * @Route("/user/settings/image", name="change_image")
     */
    public function ChangeImageAction(Request $request)
    {
        //  $image = $request->files->get('file'); $user->setImage($image);

        $user =  $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(ChangeImageType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $image = $user->getImage();
            $image_path = md5(uniqid()).'.'.$file->guessExtension();

            $client = $this->get('aws.s3');

            $result = $client->putObject([
                'Bucket' => 'img-pi',
                'Key'    =>  'e',
                'body' =>  'e.txt'
            ]);  

            $user->setPath($image_path);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("work");
        }

        return new JsonResponse("error", 400);
    }

    /**
     * @Route("/settings/stats", name="update_stats")
     */
    public function updateStatsAction()
    {       

        $user =  $this->get('security.token_storage')->getToken()->getUser();


        $exercise = new ExerciceDone();

        $exercise->setName("totoxx");
        $exercise->setPoints(3);

        $user->addExercicedone($exercise);


        $exercise->setUser($user);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
         return new JsonResponse("work");
    }

    /**
     * @Route("/user/stats", name="show_stats")
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
     * @Route("/settings/points", name="update_points")
     */
    public function updatePointsAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->setPoints($user->getPoints() + 30);

        $em = $this->getDoctrine()->getManager();

        $listBadges = $em->getRepository('AppBundle:Badge')->findAll();
        $listBadgeAchivement = $em->getRepository('AppBundle:BadgeManager')->findByUser($user);

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

        die();
    }

    /**
     * @Route("contact", name="contact")
     */
    public function contactAction(Request $request)
    {       
        $contact = new Contact();
        $contact->setEmail('test@yahoo.com');
        $contact->setContent('testyahoo');
        $contact->setSubject('testyahoo');

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($contact->getSubject() . " de" . $contact->getEmail())
            ->setFrom("agrandiere@intechinfo.fr")
            ->setTo("agrandiere@intechinfo.fr")
            ->setBody($contact->getContent());

            $this->get('mailer')->send($message);  

        return new JsonResponse("votre message a bien été envoyé");
    }

    public function registerAction(Request $request)
    {  
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
        return new JsonResponse("Invalid data", 400);
    }

    /**
     * @Route("invitation", name="invitation")
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
            ->setBody("Bonjour, Vous avez reçu une invitation de la part de" . $fullname . "pour essayer Linguissime. Vous pouvez vous rendre sur www.linguissime.com");

            $this->get('mailer')->send($message);  

        return new JsonResponse("votre message a bien été envoyé");
    }
}
