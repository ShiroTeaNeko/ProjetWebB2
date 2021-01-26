<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $resto = new Restaurant();
            $resto
                ->setTitle($faker->words(2,true))
                ->setDescription($faker->sentences(3,true))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setTag($faker->words(1,true));
            $manager->persist($resto);
        }

        $manager->flush();
    }
}
