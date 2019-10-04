<?php

namespace App\Controller;

use App\Entity\ServiceDelivery;
use App\Form\ServicesType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ShoppingController extends AbstractController
{
    /**
     * @Route("/serviceForm", name="serviceForm")
     */
    public function serviceForm(Request $request, ObjectManager $manager)
    {
        $service = new ServiceDelivery();

        $form = $this->createForm(ServicesType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imgFile */
            $imgFile = $form["picture"]->getData();

            if ($imgFile) {
                $imgFileName =
                    pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME)
                    . '-' . uniqid()
                    . '.' . $imgFile->guessClientExtension();

                $imgFile->move(dirname(__FILE__) . "/../../public/uploads/", $imgFileName);

                $service->setPicture("/uploads/".$imgFileName);
            }

            $manager->persist($service);
            $manager->flush();

            return $this->redirectToRoute('serviceForm');
        }


        return $this->render('shopping/serviceForm.html.twig', [
            'controller_name' => 'ShoppingController',
            'createServiceForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/serviceChange", name="serviceChange")
     */

    public function serviceChange()
    {
        $repo = $this->getDoctrine()->getRepository(ServiceDelivery::class);
        $serviceChange = array_map(function ($serviceDelivery) {
            return $serviceDelivery->getTitle();
        }, $repo->findAll());
        
        dd($serviceChange);

        return $this->render('our services/serviceChange.html.twig', [
            'controller_name' => 'shoppingController',
            'services' => $serviceChange,

        ]);
    }
}
