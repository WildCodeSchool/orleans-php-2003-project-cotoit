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
     * @var ParsingManager
     */
    private $parsing;

    public function __construct(ParsingManager $parsing)
    {
        $this->parsing = $parsing;
    }

    private function stringToInteger(array $activities)
    {
        return $activities = array_map('intval', $activities);
    }

    public function populateHousing(array $housings)
    {
        $userHousings = [];
        foreach ($housings as $property) {
            array_shift($property);
            $property = $this->parsing->slugArrayKey($property);

            //inverted order of those two keys so all fixed columns come first
            //makes using count(self::FIXED_COLUMNS) possible for the array_slice offset to populate activities
            $property = $this->parsing->moveKeyBefore($property, 'nombre-de-visites', self::FIXED_COLUMNS[4]);

            $activities = $this->stringToInteger(array_slice($property, count(self::FIXED_COLUMNS), null, true));

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
