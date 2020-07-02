<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{

    const FIXED_COLUMNS = [
        'nom-de-la-copro',
        'cp',
        'nombre-de-lots',
        'hono',
        'immeuble-de-moins-de-2-ans',
    ];

    /**
     * @var Slugify
     */
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    private function stringToInteger(array $activities)
    {
        return $activities = array_map('intval', $activities);
    }

    private function moveKeyBefore($array, $find, $move)
    {
        if (!isset($array[$find], $array[$move])) {
            return $array;
        }

        $length = 0;
        $keys = array_keys($array);
        foreach ($keys as $key) {
            if ($key == $find) {
                break;
            } else {
                $length += 1;
            }
        }

        $elem = [$move => $array[$move]];
        $start = array_splice($array, 0, $length);
        unset($start[$move]);

        return $start + $elem + $array;
    }

    public function populateHousing(array $housings)
    {
        $userHousings = [];
        foreach ($housings as $property) {
            $property = $this->slugify->slugArrayKey($property);
            $property = $this->moveKeyBefore($property, 'nombre-de-visites', self::FIXED_COLUMNS[4]);

            $activities = array_slice($property, count(self::FIXED_COLUMNS) + 1, null, true);
            $activities = $this->stringToInteger($activities);

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
        return $userHousings;
    }
}
