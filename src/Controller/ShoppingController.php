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
     * @Route("/serviceCreation", name="serviceCreation")
     * @Route("/serviceCreation"/{id}/edit, name="serviceEdit")
     */
    public function serviceCreation(Request $request, ObjectManager $manager)
    {
        $service = new ServiceDelivery();

        $form = $this->createForm(ServicesType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imgFile */
            $imgFile = $form["picture"]->getData();

            if($imgFile) {
                $imgFileName = 
                    pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME)
                    . '-' . uniqid()
                    . '.' . $imgFile->guessClientExtension();

                $imgFile->move(dirname(__FILE__) . "/../../public/uploads", $imgFileName);
                $service->setPicture($imgFileName);
            }

            $manager->persist($service);
            $manager->flush();

            return $this->redirectToRoute('serviceCreation');
        }


        return $this->render('shopping/serviceCreation.html.twig', [
            'controller_name' => 'ShoppingController',
            'createServiceForm' => $form->createView()
        ]);
    }
}
