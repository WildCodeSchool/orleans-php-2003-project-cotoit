<?php


namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActivityFixtures extends Fixture
{
    const ACTIVITIES = [
        'Visite' => [
            'hours' => 2,
            'minutes' => 30,
        ],
        'Immeuble de moins de 2 ans' => [
            'hours' => 10,
            'minutes' => 0,
        ],
        'Réunion du conseil syndical' => [
            'hours' => 4,
            'minutes' => 0,
        ],
        'Tenue assemblée générale' => [
            'hours' => 3,
            'minutes' => 0,
        ],
        'Résolution travaux' => [
            'hours' => 1,
            'minutes' => 0,
        ],
        'Ordre de service' => [
            'hours' => 0,
            'minutes' => 30,
        ],
        'Vente' => [
            'hours' => 0,
            'minutes' => 30,
        ],
        'Relance' => [
            'hours' => 0,
            'minutes' => 1,
        ],
        'Sinistre MRH' => [
            'hours' => 2,
            'minutes' => 0,
        ],
        'Sinistre DO' => [
            'hours' => 2,
            'minutes' => 0,
        ],
        'Expertise avec présence gestionnaire' => [
            'hours' => 1,
            'minutes' => 30,
        ],
        'Suivi et transmission avocat/huissier dossier contentieux' => [
            'hours' => 1,
            'minutes' => 0,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $activity = new Activity();
            $activity->setName(ucfirst($faker->words(3, true)));
            $activity->setHours($faker->numberBetween(1, 12));
            $activity->setMinutes($faker->randomElement(self::MINUTES));

            $manager->persist($activity);
        }
        $manager->flush();
    }
}
