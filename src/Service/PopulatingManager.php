<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{
    public function activityToArray(array $housingData)
    {
        $housingActivities = [];
        for ($i = 5; $i < count($housingData); $i++) {
            array_push($housingActivities, $housingData[$i]);
        }
        return $housingActivities;
    }

    public function populateHousing(array $housingData)
    {
        for ($i = 0; $i <= count($housingData); $i++) {
            $housingNumeric = array_values($housingData[$i]);
            $housing = new Housing();
            $housing->setName($housingNumeric[1]);
            $housing->setPostCode($housingNumeric[2]);
            $housing->setNumberLot(intval($housingNumeric[3]));
            $housing->setFee(floatval(trim($housingNumeric[4], ' €')));
            $housing->setIsLessThanTwoYears(!empty($housingNumeric[6]));
            $housing->setHousingActivities($this->activityToArray($housingNumeric));
            dd($housing);
        }
    }
}
