<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{

    const FIXED_COLUMNS = [
        'nom-de-la-copropriete',
        'cp',
        'nombre-de-lots',
        'honoraires',
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


            $property['immeuble-de-moins-de-2-ans'] =
                $this->parsing->convertToBoolean($property['immeuble-de-moins-de-2-ans']);
            $activities = $this->stringToInteger(array_slice($property, count(self::FIXED_COLUMNS), null, true));

            $property[self::FIXED_COLUMNS[3]] = str_replace(',', '.', $property[self::FIXED_COLUMNS[3]]);

            //this is a whitespace used for numbers (different of the usual whitespace)
            //careful when modifying this line
            //unicode(\u202F)
            $property[self::FIXED_COLUMNS[3]] = ltrim(str_replace(' ', '', $property[self::FIXED_COLUMNS[3]]));

            $housing = new Housing();
            $housing->setName($property[self::FIXED_COLUMNS[0]]);
            $housing->setPostCode($property[self::FIXED_COLUMNS[1]]);
            $housing->setNumberLot(intval($property[self::FIXED_COLUMNS[2]]));
            $housing->setFee(floatval($property[self::FIXED_COLUMNS[3]]));
            $housing->setHousingActivities($activities);

            array_push($userHousings, $housing);
        }
        array_pop($userHousings);
        return $userHousings;
    }
}
