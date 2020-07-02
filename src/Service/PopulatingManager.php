<?php

namespace App\Service;

use App\Entity\Housing;

class PopulatingManager
{

    const FIXED_COLUMNS = [
        'HOUSING_NAME' => 'nom-de-la-copropriete',
        'POSTAL_CODE' => 'cp',
        'NUMBER_LOTS' => 'nombre-de-lots',
        'FEES' => 'honoraires',
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
                $this->parsing->convertToZeroOrOne($property['immeuble-de-moins-de-2-ans']);
            $activities = $this->stringToInteger(array_slice($property, count(self::FIXED_COLUMNS), null, true));

            $property[self::FIXED_COLUMNS['FEES']] = str_replace(',', '.', $property[self::FIXED_COLUMNS['FEES']]);

            //this is a whitespace used for numbers (different of the usual whitespace)
            //careful when modifying this line
            //unicode(\u202F)
            $property[self::FIXED_COLUMNS['FEES']] =
                ltrim(str_replace(' ', '', $property[self::FIXED_COLUMNS['FEES']]));

            $housing = new Housing();
            $housing->setName($property[self::FIXED_COLUMNS['HOUSING_NAME']]);
            $housing->setPostCode($property[self::FIXED_COLUMNS['POSTAL_CODE']]);
            $housing->setNumberLot(intval($property[self::FIXED_COLUMNS['NUMBER_LOTS']]));
            $housing->setFee(floatval($property[self::FIXED_COLUMNS['FEES']]));
            $housing->setHousingActivities($activities);

            array_push($userHousings, $housing);
        }
        array_pop($userHousings);
        return $userHousings;
    }
}
