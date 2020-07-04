<?php

namespace App\Service;

class ColumnManager
{
    const ERROR_MESSAGE = 'Le nom de la colonne ne correspond pas au modèle.';

    /**
     * @var ParsingManager
     */
    private $parsing;

    /**
     * @var PopulatingManager
     */
    private $populate;

    public function __construct(ParsingManager $parsing, PopulatingManager $populate)
    {
        $this->parsing = $parsing;
        $this->populate = $populate;
    }

    public function sameColumn(array $input)
    {
        $errorColumn = [];
        $columns = $this->populate->getFixedColumn();

        foreach ($input as $data) {
            $input = $this->parsing->slugArrayKey($data);
        }
        foreach ($columns as $column) {
            if (!array_key_exists($column, $input)) {
                array_push($errorColumn, $column);
            }
        }
        return $errorColumn;
    }
}
