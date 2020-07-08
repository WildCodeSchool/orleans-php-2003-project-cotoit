<?php

namespace App\DataFixtures;

use App\Entity\HourlyRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HourlyRateFixtures extends Fixture
{
    const HOURLY_RATE = 47;

    public function load(ObjectManager $manager)
    {
        $hourlyRate = new HourlyRate();
        $hourlyRate->setRate(self::HOURLY_RATE);
        $manager->persist($hourlyRate);
        $manager->flush();
    }
}
