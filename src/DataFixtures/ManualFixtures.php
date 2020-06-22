<?php


namespace App\DataFixtures;

use App\Entity\Manual;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ManualFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-FR');

        $manual = new Manual();
        $manual->setInstruction($faker->text(700));
        $manual->setCalculation($faker->text(700));

        $manager->persist($manual);

        $manager->flush();
    }
}
