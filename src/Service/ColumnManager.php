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
     * return an error when a column is different from the template or empty
     * @param array $housings
     * @return array
     */
    public function sameColumn(array $housings): array
    {
        $columns = $this->populate->getFixedColumn();
        $columns = $this->getSluggedColumns($columns);

        $errorColumn = [];

        $incorrectColumns = array_diff(array_keys($housings), $columns);
        foreach ($incorrectColumns as $incorrectColumn) {
            if (!empty($incorrectColumn)) {
                $errorColumn[$this->removeDash($incorrectColumn)] =
                    'Ce nom de colonne ne fait pas partie du modèle. Merci de vous reporter au mode d\'emploi.';
            } else {
                $errorColumn[$this->removeDash($incorrectColumn)] =
                    'Le nom d\'une colonne est vide. Merci de vous reporter au mode d\'emploi.';
            }
        }

        $errorColumn = array_merge($errorColumn, $this->missingColumn($columns, $housings));
        return $errorColumn;
    }

    /**
     * return an error when a column is missing
     * @param array $columns
     * @param array $housings
     * @return array
     */
    private function missingColumn(array $columns, array $housings): array
    {
        $errorColumn = [];
        foreach ($columns as $column) {
            if (!array_key_exists($column, $housings)) {
                $errorColumn[$this->removeDash($column)] =
                    "Cette colonne est manquante. Merci de vous reporter au mode d'emploi.";
            }
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
            array_push($columns, $activity->getSlug());
        }

        return $columns;
    }

    public function getTemplateCsv(): string
    {
        $template = [];

        $fixedColumns = $this->populate->getFixedColumn();
        foreach ($fixedColumns as $fixedColumn) {
            array_push($template, $fixedColumn);
        }

        $activities = $this->activityRepository->findBy([]);
        foreach ($activities as $activity) {
            array_push($template, $activity->getSlug());
        }

        return implode(',', $template);
    }
}
