<?php

namespace App\Controller;

use App\Entity\Ordered;
use App\Entity\ServiceDelivery;
use App\Form\ServicesType;
use App\Service\Cart\CartService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @Route("/payment", name="payment")
     */
    public function paymentForm(AuthorizationCheckerInterface $authChecker, Session $session, CartService $cartService, ObjectManager $manager)
    {
        if ($authChecker->isGranted('ROLE_USER')) {

        //Création de la commande    
        $ordered = new Ordered();

        $userId = $this->getUser()->getId();
        $TotalAmount = $cartService->getTotal();
        $serviceId = $cartService->getIdCart();

        $ordered
            ->setPaymentType('Bank card')
            ->setAmount((int) $TotalAmount)
            ->setServiceDelivery((string)$serviceId)
            ->setCustomer($userId);

        $manager->persist($ordered);
        $manager->flush();

        //Paiement avec API Stripe
        \Stripe\Stripe::setApiKey('sk_test_wNh8jJFHkT5MLbFiFXft1MO000bgSTxzpS');
        
        $amount = $TotalAmount * 100;
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'payment_method_types' => ['card'],            
            'metadata' => ['order_id' => $ordered->getId()],
        ]);

        return $this->render('shopping/payment.html.twig', [
            'order' => $ordered,
            'clientPayment' => $intent->client_secret
        ]);
    }
        return $this->redirectToRoute("security_registration");
    }
}
