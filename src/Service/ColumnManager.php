<?php

namespace App\Service;

use App\Repository\ActivityRepository;

class ColumnManager
{
    /**
     * @var ParsingManager
     */
    private $parsing;

    /**
     * @var PopulatingManager
     */
    private $populate;

    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    public function __construct(ParsingManager $parsing, PopulatingManager $populate, ActivityRepository $activity)
    {
        $this->parsing = $parsing;
        $this->populate = $populate;
        $this->activityRepository = $activity;
    }

    /**
     * @param array $housings
     * @return array
     */
    public function sameColumn(array $housings): array
    {
        $columns = $this->populate->getFixedColumn();
        $columns = $this->getSluggedColumns($columns);

        foreach ($housings as $housing) {
            $housings = $this->parsing->slugArrayKey($housing);
        }

        $errorColumn = [];
        $incorrectColumns = array_diff(array_keys($housings), $columns);
        foreach ($incorrectColumns as $incorrectColumn) {
            $errorColumn[$this->removeDash($incorrectColumn)] =
                'Ce nom de colonne ne fait pas partie du modèle. Merci de vous reporter au mode d\'emploi.';
        }
        return $errorColumn;
    }

    /**
     * @param mixed $input
     * @return mixed
     */
    private function removeDash($input)
    {
        return str_replace('-', ' ', $input);
    }

    /**
     * @param array $columns
     * @return array
     */
    private function getSluggedColumns(array $columns): array
    {
        $activities = $this->activityRepository->findBy([]);
        foreach ($activities as $activity) {
            array_push($columns, $activity->getName());
        }

        $columns = array_flip($columns);
        $columns = $this->parsing->slugArrayKey($columns);
        return array_flip($columns);
    }
}
