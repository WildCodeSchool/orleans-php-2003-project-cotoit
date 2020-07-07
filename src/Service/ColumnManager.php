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
        $incorrectColumns = array_diff(array_keys($input), $columns);
        foreach ($incorrectColumns as $incorrectColumn) {
            $errorColumn[$this->unslugify($incorrectColumn)] =
                'Ce nom de colonne ne fait pas partie du modèle. Merci de vous reporter au mode d\'emploi.';
        }
        return $errorColumn;
    }

    /**
     * @param mixed $input
     * @return mixed
     */
    private function unslugify($input)
    {
        return str_replace('-', ' ', $input);
    }
}
