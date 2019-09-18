<?php

namespace App\Controller;

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
     * @Route("/infos", name="infos")
     */
    public function infos()
    {
        return $this->render('a propos/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
}
