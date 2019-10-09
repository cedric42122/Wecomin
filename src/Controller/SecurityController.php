<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
     * @Route("/admin/userModification", name="userModification")
     */
    public function userModification(Request $request, ObjectManager $manager)
    {

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();


        return $this->render('admin/userChange.html.twig', [
            'controller_name' => 'SecurityController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/actionModification", name="actionModification")
     */
    public function actionModification(Request $request, ObjectManager $manager)
    {

        $id = $request->request->get('id');

        // Récupération des données du formulaire
        $form = $request->request->get('form');

        $username = $form['username'];
        $email = $form['email'];

        $role = $form['roles'];

        // Récupération de l'objet user en base
        $userBdd = $this->getDoctrine()->getRepository(User::class)->findOneById($id);


        // Affection du role souhaité à l'utilisateur concerné
        $userBdd->setUsername($username);
        $userBdd->setEmail($email);
        $userBdd->setRoles($role);

        $manager->persist($userBdd);
        $manager->flush();


        return $this->redirectToRoute('userModification');
    }

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
     * @Route("/admin/ajaxSelect", name="ajaxSelect")
     */
    public function ajaxUserSelectedAction(Request $request)
    {

        $id = $request->request->get('idUtilisateur');

        // Récupération de tous les utilisateurs en BDD
        $utilisateur = $this->getDoctrine()->getRepository(User::class)->findOneById($id);

        // Formulaire modification utilisateur
        $form = $this->createFormBuilder($utilisateur)
            ->add('username')
            ->add('email')
            ->add('roles')
            ->getForm();

        return $this->render('admin/formModif.html.twig', [
            'userChangeForm' => $form->createView(),
            'idUtilisateur' => $utilisateur
        ]);
    }
}
