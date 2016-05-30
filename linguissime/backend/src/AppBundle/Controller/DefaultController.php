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
use AppBundle\Entity\BadgeManager;
use AppBundle\Model\Contact;
use AppBundle\Model\Form\ContactType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * @Route("/user/badge", name="badge")
     */
    public function BadgeAction()
    {   
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $listBadgeAchivement = $em->getRepository('AppBundle:BadgeManager')->findByUser($user);

        return $this->render('default/badge.html.twig', array('achievement' => $listBadgeAchivement));
    }

    /**
     * @Route("/user/settings/password", name="change_password")
     */
    public function ChangePasswordAction(Request $request)
    {
        $user =  $this->get('security.token_storage')->getToken()->getUser();
        $password = new ChangePassword();
       
        $form = $this->createForm(ChangePasswordType::class, $password);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $newPassword = $this->get('security.password_encoder')->encodePassword($user, $password->getNewPassword());
            $user->setPassword($newPassword);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
            'notice',
            'Vos changements on été enregistré');

        }

        return $this->render('default/settings/password.html.twig', array('form' => $form->createView()));
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

            $this->addFlash(
            'notice',
            'Vos changements on été enregistré');

        }

        return $this->render('default/settings/account.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/user/settings/image", name="change_image")
     */
    public function ChangeImageAction(Request $request)
    {
        $user =  $this->get('security.token_storage')->getToken()->getUser();
       
        $form = $this->createForm(ChangeImageType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('default/settings/image.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/update_points", name="update_points")
     */
    public function UpdatePointsAction()
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
     * @Route("/contact/api", name="contact", condition="request.isXmlHttpRequest()")
     */
    public function contactAction(Request $request)
    {   
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if (!$form->isValid()) {

            $errors = array();
            
            foreach ($form->getErrors() as $error) {
                $errors[$form->getName()][] = $error->getMessage();

            }

            return new JsonResponse($errors, 400);
        }

            $message = \Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($contact->getSubject() . " de" . $contact->getEmail())
            ->setFrom("xx")
            ->setTo("xx")
            ->setBody($contact->getContent());

            $this->get('mailer')->send($message);  

        return new JsonResponse("votre message a bien été envoyé");
    }

    /**
     * @Route("/register/api", name="register", condition="request.isXmlHttpRequest()")
     */
    public function registerAction(Request $request)
    { 
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if (!$form->isValid()) 
        {
            $errors = array();
        
            foreach ($form->getErrors() as $error) {
                $errors[$form->getName()][] = $error->getMessage();
            }

            return new JsonResponse($errors, 400);
        }

        $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse("Votre compte a été crée avec succès");
    }
}
