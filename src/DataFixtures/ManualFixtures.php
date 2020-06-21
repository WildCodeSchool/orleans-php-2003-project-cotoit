<?php


namespace App\DataFixtures;

use App\Entity\Manual;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ManualFixtures extends Fixture
{

    const TITLES = [
        'Mode d\'emploi',
        'Mode de calcul',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr-FR');

        foreach (self::TITLES as $title) {
            $manual = new Manual();
            $manual->setInstruction($title);
            $manual->setCalculation($faker->text(700));

            $manager->persist($manual);
        }

        $manager->flush();
    }
}
