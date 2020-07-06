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
     * @param array $input
     * @return array
     */
    public function sameColumn(array $input): array
    {
        $columns = $this->populate->getFixedColumn();

        $activities = $this->activityRepository->findBy([]);
        foreach ($activities as $activity) {
            array_push($columns, $activity->getName());
        }

        $columns = array_flip($columns);
        $columns = $this->parsing->slugArrayKey($columns);
        $columns = array_flip($columns);

        foreach ($input as $data) {
            $input = $this->parsing->slugArrayKey($data);
        }

        $errorColumn = [];
        foreach ($columns as $column) {
            if (!array_key_exists($column, $input)) {
                $column = $this->unslugify($column);
                array_push($errorColumn, 'Le nom de la colonne pour "'.$column.'" ne correspond pas au modèle.');
            }
        }
        return $errorColumn;
    }

    /**
     * @param string $input
     * @return string
     */
    private function unslugify(string $input): string
    {
        return str_replace('-', ' ', $input);
    }
}
