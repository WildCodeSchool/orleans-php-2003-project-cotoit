<?php


namespace App\Service;

class CalculatingManager
{
    public function profitLot(array $housings)
    {
        $this->profit($housings);
        $totalTime = $this->totalTime($housings);
        dd($totalTime);
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


//    private function globalCost(array $activity)
//    {
//
//    }
}
