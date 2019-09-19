<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingController extends AbstractController
{
    /**
     * @Route("/serviceCreation", name="serviceCreation")
     */
    public function serviceCreation()
    {
        return $this->render('shopping/serviceCreation.html.twig', [
            'controller_name' => 'ShoppingController',
        ]);
    }
}
