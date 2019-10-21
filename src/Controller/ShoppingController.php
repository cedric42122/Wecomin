<?php

namespace App\Controller;

use App\Entity\ServiceDelivery;
use App\Form\ServicesType;
use App\Service\Cart\CartService;
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

                $service->setPicture("/uploads/" . $imgFileName);
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
     * @Route("/cart", name="cart_index")
     */
    public function cartIndex(CartService $cartService)
    {

        return $this->render('shopping/cart.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function cartAdd($id, CartService $cartService)
    {
        $cartService->add($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function cartRemove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/payment", name="payement")
     */
    public function paymentService(Request $request)
    {
        \Stripe\Stripe::setApiKey('pk_test_8Lgfp4jEhIIkMPlu2oiM8ToN00zRv85lFd');
    
        $intent = \Stripe\PaymentIntent::create([
            'amount' => 2000,
            'currency' => 'eur',
            'source' => $request->request->get('stripeToken'),
            'description' => 'Paiement de test',
        ]);
        return $this->render('shopping/payment.html.twig');
    }
}
