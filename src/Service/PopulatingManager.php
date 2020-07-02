<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{

    const FIXED_COLUMNS = [
        'nom-de-la-copro',
        'cp',
        'nombre-de lots',
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

    private function stringToInteger(array $property)
    {
        $activities = array_slice($property, 7, null, true);
        return $activities = array_map('intval', $activities);
    }

    public function populateHousing(array $housings)
    {
        $userHousings = [];
        foreach ($housings as $property) {
            $property = $this->slugify->slugArrayKey($property);
            dd($property);


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
        return $userHousings;
    }
}
