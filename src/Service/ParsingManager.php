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
                                '',
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
        foreach ($housings as $housing) {
            $housingActivities = $housing->getHousingActivities();

            $newHousingActivities = [];
            foreach ($activities as $activityKey => $activityValue) {
                $activityValue->setNumber($housingActivities[$activityKey]);
                array_push($newHousingActivities, clone $activityValue);
            }
            $newHousingActivities = $this->slugArrayKey($this->activityToKey($newHousingActivities));

            $housing->setHousingActivities($newHousingActivities);
            array_push($housings, $housing);
        }
        return $housings;
    }
}
