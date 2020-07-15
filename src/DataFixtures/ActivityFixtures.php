<?php


namespace App\DataFixtures;

use App\Entity\Activity;
use App\Service\ParsingManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    const ACTIVITIES = [
        'Visites' => [
            'hour' => 2,
            'minute' => 30,
        ],
        'Immeuble de moins de 2 ans' => [
            'hour' => 10,
            'minute' => 0,
        ],
        'Réunion du CS' => [
            'hour' => 4,
            'minute' => 0,
        ],
        'Tenue AG' => [
            'hour' => 3,
            'minute' => 0,
        ],
        'Résolution travaux' => [
            'hour' => 1,
            'minute' => 0,
        ],
        'OS' => [
            'hour' => 0,
            'minute' => 30,
        ],
        'Ventes' => [
            'hour' => 0,
            'minute' => 30,
        ],
        'Relances' => [
            'hour' => 0,
            'minute' => 1,
        ],
        'Sinistres MRH' => [
            'hour' => 2,
            'minute' => 0,
        ],
        'Sinistres DO' => [
            'hour' => 2,
            'minute' => 0,
        ],
        'Expertises avec présence d\'un gestionnaire' => [
            'hour' => 1,
            'minute' => 30,
        ],
        'Suivi dossiers contentieux avant avocat puis transmission dossier à l\'avocat ou huissier' => [
            'hour' => 1,
            'minute' => 0,
        ],
    ];

    /**
     * @var ParsingManager
     */
    private $parsing;

    public function __construct(ParsingManager $parsing)
    {
        $this->parsing = $parsing;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::ACTIVITIES as $activityName => $time) {
            $activity = new Activity();
            $activity->setName($activityName);
            $activity->setHour($time['hour']);
            $activity->setMinute($time['minute']);
            $activity->setSlug($this->parsing->slug($activityName));

            $manager->persist($activity);
        }
        $manager->flush();
    }
}
