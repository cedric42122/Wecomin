<?php

namespace App\Controller;

use App\Entity\ServiceDelivery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function contact()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }

    /**
     * @Route("/errorAccess", name="errorAccess")
     */
    public function errorAccess()
    {
        return $this->render('errorAccess/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
}
