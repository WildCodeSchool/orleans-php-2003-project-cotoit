<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{

    const FIXED_COLUMNS = [
        'nom de la copro',
        'cp',
        'nombre de lots',
        'hono',
        'immeuble de moins de 2 ans',
    ];

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

    private function regexArrayKey(array $property)
    {
        $oldKeys = array_keys($property);
        $newKeys = [];
        foreach ($oldKeys as $oldKey) {
            array_push($newKeys, trim(strtolower(preg_replace(
                '#[^A-Za-z0-9 \']+#',
                ' ',
                $this->removeSpecialCharacters($oldKey)
            ))));
        }

        return array_combine($newKeys, $property);
    }

    private function stringToInteger(array $property)
    {
        $activities = array_slice($property, 7, null, true);
        return $activities = array_map('intval', $activities);
    }

    public function populateHousing(array $housings)
    {
        $userHousings = [];
        foreach ($housings as $property) {
            $property = $this->regexArrayKey($property);

            $activities = $this->stringToInteger($property);
            $activities['nombre de visites'] = intval($property['nombre de visites']);

            $property['hono'] = str_replace(',', '.', $property['hono']);

            //this is a whitespace used for numbers (different of the usual whitespace)
            //careful when modifying this line
            //unicode(\u202F)
            $property['hono'] = ltrim(str_replace(' ', '', $property['hono']));

            $housing = new Housing();
            $housing->setName($property[self::FIXED_COLUMNS[0]]);
            $housing->setPostCode($property[self::FIXED_COLUMNS[1]]);
            $housing->setNumberLot(intval($property[self::FIXED_COLUMNS[2]]));
            $housing->setFee(floatval($property[self::FIXED_COLUMNS[3]]));
            $housing->setIsLessThanTwoYears(!empty($property[self::FIXED_COLUMNS[4]]));
            $housing->setHousingActivities($activities);

            array_push($userHousings, $housing);
        }
        array_pop($userHousings);
        dd($userHousings);
        return $userHousings;
    }
}
