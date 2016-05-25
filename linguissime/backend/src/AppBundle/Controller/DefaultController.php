<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

class DefaultController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    { 
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('default/register.html.twig',array('form' => $form->createView()));
    }

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
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
      throw new NotFoundHttpException();
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
     * @Route("/user/stats", name="stats")
     */
    public function StatsAction()
    {
        return $this->render('default/stats.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function SearchAction()
    {
        return $this->render('default/search.html.twig');
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
     * @Route("/exercise", name="exercise")
     */
    public function exerciseAction()
    {   
        return $this->render('default/exercise.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {   
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject($contact->getSubject() . " de" . $contact->getEmail())
                ->setFrom("agrandiere@intechinfo.fr")
                ->setTo("agrandiere@intechinfo.fr")
                ->setBody($contact->getContent());

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('contact');
        }

        return $this->render('::default/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
