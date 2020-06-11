<?php


namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActivityFixtures extends Fixture
{
    const MINUTES = [
        00,
        15,
        30,
        45,
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $activity = new Activity();
            $activity->setName($faker->words(3, true));
            $activity->setHours($faker->numberBetween(1, 12));
            $activity->setMinutes($faker->randomElement(self::MINUTES));
        }
    }
}
