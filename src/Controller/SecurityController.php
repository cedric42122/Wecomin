<?php

namespace App\Controller;

use App\Entity\ServiceDelivery;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    { }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(AuthorizationCheckerInterface $authChecker)
    {
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'SecurityController',
            ]);
        }
        return $this->redirectToRoute('exception');
    }

    /**   
     * @Route("/admin/userChange", name="userChange")
     */
    public function userChange()
    {
        // Récupération de tous les utilisateurs en BDD
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();;

        return $this->render('admin/userChange.html.twig', [
            'controller_name' => 'SecurityController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/actionUserChange", name="actionUserChange")
     */
    public function actionUserChange(Request $request, ObjectManager $manager)
    {
        $id = $request->request->get('id');

        // Récupération des données du formulaire
        $form = $request->request->get('form');

        $username = $form['username'];
        $email = $form['email'];
        $role = $form['roles'];

        // Récupération de l'objet User en base
        $userBdd = $this->getDoctrine()->getRepository(User::class)->findOneById($id);

        // Affection du champ souhaité à l'utilisateur concerné
        $userBdd->setUsername($username)->setEmail($email)->setRoles($role);

        $manager->persist($userBdd);
        $manager->flush();

        return $this->redirectToRoute('userChange');
    }

    /**
     * @Route("/admin/actionServiceChange", name="actionServiceChange")
     */
    public function actionServiceChange(Request $request, ObjectManager $manager)
    {
        $id = $request->request->get('id');

        // Récupération des données du formulaire
        $form = $request->request->get('form');

        $title = $form['title'];
        $description = $form['description'];
        $picture = $form['picture'];
        $price = $form['price'];

        //  dd($form);

        $promotion = $form['promotion'];



        // Récupération de l'objet Service en base
        $serviceBdd = $this->getDoctrine()->getRepository(ServiceDelivery::class)->findOneById($id);

        // Affection du champ souhaité au service concerné
        $serviceBdd->setTitle($title)->setDescription($description)->setPicture($picture)->setPrice($price)->setPromotion($promotion);

        $manager->persist($serviceBdd);
        $manager->flush();

        return $this->redirectToRoute('serviceChange');
    }

    /**
     * @Route("/admin/ajaxUserSelect", name="ajaxUserSelect")
     */
    public function ajaxUserSelectedAction(Request $request)
    {
        $id = $request->request->get('idUser');

        // Récupération de tous les utilisateurs en BDD
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($id);

        // Formulaire modification utilisateur
        $form = $this->createFormBuilder($user)
            ->add('username')
            ->add('email')
            ->add('roles')
            ->getForm();

        return $this->render('admin/formUserChange.html.twig', [
            'userChangeForm' => $form->createView(),
            'idUser' => $user
        ]);
    }

    /**
     * @Route("/admin/serviceChange", name="serviceChange")
     */
    public function serviceChange(ObjectManager $manager)
    {
        // Récupération de tous les services en BDD
        $services = $this->getDoctrine()->getRepository(ServiceDelivery::class)->findAll();;

        return $this->render('admin/serviceChange.html.twig', [
            'controller_name' => 'SecurityController',
            'services' => $services,
        ]);
    }

    /**
     * @Route("/admin/ajaxServiceSelect", name="ajaxServiceSelect")
     */
    public function ajaxServiceSelectedAction(Request $request)
    {
        $id = $request->request->get('idService');

        // Récupération de tous les services en BDD
        $service = $this->getDoctrine()->getRepository(ServiceDelivery::class)->find($id);

        // Formulaire modification service
        $form = $this->createFormBuilder($service)

            ->add('title')
            ->add('description')
            ->add('picture')
            ->add('price')
            ->add('promotion', CheckboxType::class, [
                'required' => false,
            ])
            
            ->getForm();
        
        return $this->render('admin/formServiceChange.html.twig', [
            'serviceChangeForm' => $form->createView(),
            'idService' => $service,
        ]);
    }
}
