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
            'hour' => 2,
            'minute' => 30,
        ],
        'Immeuble de moins de 2 ans' => [
            'hour' => 10,
            'minute' => 0,
        ],
        'Réunion du conseil syndical' => [
            'hour' => 4,
            'minute' => 0,
        ],
        'Tenue assemblée générale' => [
            'hour' => 3,
            'minute' => 0,
        ],
        'Résolution travaux' => [
            'hour' => 1,
            'minute' => 0,
        ],
        'Ordre de service' => [
            'hour' => 0,
            'minute' => 30,
        ],
        'Vente' => [
            'hour' => 0,
            'minute' => 30,
        ],
        'Relance' => [
            'hour' => 0,
            'minute' => 1,
        ],
        'Sinistre MRH' => [
            'hour' => 2,
            'minute' => 0,
        ],
        'Sinistre DO' => [
            'hour' => 2,
            'minute' => 0,
        ],
        'Expertise avec présence gestionnaire' => [
            'hour' => 1,
            'minute' => 30,
        ],
        'Suivi et transmission avocat/huissier dossier contentieux' => [
            'hour' => 1,
            'minute' => 0,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTIVITIES as $activityName => $time) {
            $activity = new Activity();
            $activity->setName($activityName);
            $activity->setHour($time['hour']);
            $activity->setMinute($time['minute']);

            $manager->persist($activity);
        }
        $manager->flush();
    }
}
