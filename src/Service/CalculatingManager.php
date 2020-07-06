<?php


namespace App\Service;

class CalculatingManager
{
    public function profitLot(array $housings): array
    {
        $profit = $this->profit($housings);
        $totalTime = $this->totalTime($housings);
        $totalLots = $this->totalLots($housings);
        dd($profit, $totalTime, $totalLots);


        return $housings;
    }

    private function profit(array $housings)
    {
        $profit = 0;
        foreach ($housings as $housing) {
            $profit += $housing->getFee();
        }
        return $profit;
    }

    private function totalTime(array $housings)
    {
        $totalTime = 0;
        foreach ($housings as $housing) {
            $hours = 0;
            $minutes = 0;
            $activities = $housing->getHousingActivities();

            foreach ($activities as $activity) {
                $hours += $activity->getHour();
                $minutes += $activity->getMinute();
            }
            $hours += $minutes / 60;
            $totalTime += $hours;
        }
        return round($totalTime, 2);
    }

    private function totalLots(array $housings)
    {
        $totalLots = 0;
        dd($housings);
        foreach ($housings as $housing) {
            $totalLots += $housing->getNumberLot();
            var_dump($totalLots);
        }
        exit();
    }


//    private function globalCost(array $activity)
//    {
//
//    }
}
