<?php


namespace App\Service;

class ParsingManager
{
    private function removeSpecialCharacters(string $input)
    {
        $characters = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/[«»]/u' => '',
        ];

        return preg_replace(array_keys($characters), array_values($characters), $input);
    }

    public function slugArrayKey(array $input)
    {
        $oldKeys = array_keys($input);
        $newKeys = [];
        foreach ($oldKeys as $oldKey) {
            array_push(
                $newKeys,
                trim(
                    strtolower(
                        preg_replace(
                            [
                                '#[^A-Za-z0-9 \']+#',
                                '#[\s-]+#'
                            ],
                            [
                                ' ',
                                '-'
                            ],
                            $this->removeSpecialCharacters($oldKey)
                        )
                    ),
                    '-'
                )
            );
        }

        return array_combine($newKeys, $input);
    }

    public function slug(string $input): string
    {

                trim(
                    strtolower(
                        preg_replace(
                            [
                                '#[^A-Za-z0-9 \']+#',
                                '#[\s-]+#'
                            ],
                            [
                                ' ',
                                '-'
                            ],
                            $this->removeSpecialCharacters($input)
                        )
                    ),
                    '-'
                );

        return $input;
    }

    public function convertToZeroOrOne(string $input): int
    {
        if (!empty($input)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function moneyToFloat(string $input): float
    {
        $output = str_replace(',', '.', $input);

        //this is a whitespace used for numbers (different of the usual whitespace)
        //careful when modifying this line
        //unicode(\u202F)
        return floatval(ltrim(str_replace(' ', '', $output)));
    }

    public function activityToKey(array $activities)
    {
        $newKeys = [];
        foreach ($activities as $activity) {
            array_push($newKeys, $activity->getActivity());
        }
        return array_combine($newKeys, $activities);
    }

    public function mergeActivitiesIntoHousing(array $housings, array $activities)
    {
        $newHousing = [];
        foreach ($housings as $housing) {
            $housingActivities = $housing->getHousingActivities();

            $newHousingActivities = [];
            foreach ($activities as $activityKey => $activityValue) {
                if (is_int($housingActivities[$activityKey])) {
                    $activityValue->setNumber($housingActivities[$activityKey]);
                } else {
                    $activityValue->setNumber($housingActivities[$activityKey]->getNumber());
                }
                array_push($newHousingActivities, clone $activityValue);
            }
            $newHousingActivities = $this->slugArrayKey($this->activityToKey($newHousingActivities));

            $housing->setHousingActivities($newHousingActivities);
            array_push($newHousing, $housing);
        }
        return $newHousing;
    }

    /**
     * @param array $profitCondos
     * @return array
     */
    public function sortProfitCondo(array $profitCondos): array
    {
        $unsortedCondos = [];
        foreach ($profitCondos as $profitCondoKey => $profitCondo) {
            $unsortedCondos[$profitCondoKey] = $profitCondo['profit'];
        }
        arsort($unsortedCondos, SORT_NUMERIC);

        $sortedCondos = [];
        foreach ($unsortedCondos as $unsortedCondoKey => $unsortedCondo) {
            $sortedCondos[$unsortedCondoKey]['profit'] = $unsortedCondo;
        }

        return $sortedCondos;
    }
}
