<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{
//    private function activityToArray(array $housingData)
//    {
//        $housingActivities = [];
//        for ($i = 5; $i < count($housingData); $i++) {
//            array_push($housingActivities, $housingData[$i]);
//        }
//        return $housingActivities;
//    }
//
//    private function removeSpecialCharacters(string $input)
//    {
//        $characters = [
//            '/[áàâãªä]/u' => 'a',
//            '/[ÁÀÂÃÄ]/u' => 'A',
//            '/[ÍÌÎÏ]/u' => 'I',
//            '/[íìîï]/u' => 'i',
//            '/[éèêë]/u' => 'e',
//            '/[ÉÈÊË]/u' => 'E',
//            '/[óòôõºö]/u' => 'o',
//            '/[ÓÒÔÕÖ]/u' => 'O',
//            '/[úùûü]/u' => 'u',
//            '/[ÚÙÛÜ]/u' => 'U',
//            '/ç/' => 'c',
//            '/Ç/' => 'C',
//            '/ñ/' => 'n',
//            '/Ñ/' => 'N',
//            '/[«»]/u' => '',
//        ];
//
//        return preg_replace(array_keys($characters), array_values($characters), $input);
//    }

//    private function regexArrayKey(array $property)
//    {
//        $keys = [];
//        foreach ($property as $key => $value) {
//            $keys .= trim(strtolower(preg_replace(
//                '#[^A-Za-z0-9 \']+#',
//                ' ',
//                $this->removeSpecialCharacters($key)
//            )));
//        }
//        $keys = array_flip($keys);

//        $array = [];
//        foreach ($property as $value) {
//            $array = array_fill_keys($keys, $value);
//        }
//
//        return $property;
//    }
//
//    public function populateHousing(array $housings)
//    {
//        for ($i = 0; $i <= count($housings); $i++) {
//            foreach ($housings as $property) {
//                $property = $this->regexArrayKey($property);
//                $housing = new Housing();
//                $housing->setName($property['nom de la copro']);
//                $housing->setPostCode($housingNumeric[2]);
//                $housing->setNumberLot(intval($housingNumeric[3]));
//                $housing->setFee(floatval(trim($housingNumeric[4], ' €')));
//                $housing->setIsLessThanTwoYears(!empty($housingNumeric[6]));
//                $housing->setHousingActivities($this->activityToArray($housingNumeric));
//            }
//        }
//    }
}
