<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ServiceDelivery;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }

    /**
     * @Route("/legalNotice", name="legalNotice")
     */
    public function legalNotice()
    {
        return $this->render('legal notice/legalNotice.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
    
    /**
     * @Route("/about", name="about")
     */
    public function infos()
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function news()
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }

    /**
     * @Route("/services", name="services")
     */
    public function services()
    {
        $repo = $this->getDoctrine()->getRepository(ServiceDelivery::class);
        $services = $repo->findAll();

        return $this->render('our services/index.html.twig', [
            'controller_name' => 'NavigationController',
            'services' => $services
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactNotification $notification)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('contact');
        };

        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'NavigationController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/exception", name="exception")
     */
    public function errorAccess()
    {
        return $this->render('exception/error403.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
}
