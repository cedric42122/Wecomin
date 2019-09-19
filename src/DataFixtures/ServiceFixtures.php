<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ServiceDelivery;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $service = new ServiceDelivery();
            $service->setTitle("Nom du service")
                    ->setDescription("<p>Description du service<p>")
                    ->setPicture("http://placehold.it/350x150")
                    ->setPrice(1000);
                    
            $manager->persist($service);
        }
        $manager->flush();
    }
}
