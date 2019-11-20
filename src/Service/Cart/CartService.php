<?php

namespace App\Service\Cart;

use App\Repository\ServiceDeliveryRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {

protected $session;
protected $serviceDeliveryRepository;

public function __construct(SessionInterface $session, ServiceDeliveryRepository $serviceDeliveryRepository)
{
    $this->session = $session;
    $this->serviceDeliveryRepository = $serviceDeliveryRepository;
}

    public function add(int $id) 
    {
        $cart = $this->session->get('cart', []);

        // Si le produit est déjà selectionné on en rajoute 1
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);

    }

    public function remove(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);
    } 

    public function getFullCart() : array
    {
        $cart = $this->session->get('cart', []);

        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'service' => $this->serviceDeliveryRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithData;
    } 

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->getFullCart() as $item) {
            $total += $item['service']->getPrice() * $item['quantity'];
        }

        return $total;

    } 

    public function getIdCart() : int
    {
        foreach($this->getFullCart() as $item) 
        {
            $idCart = $item['service']->getId();
        }
        return $idCart;
    }

}