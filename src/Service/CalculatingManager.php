<?php


namespace App\Service;

use App\Repository\HourlyRateRepository;

class CalculatingManager
{
    /**
     * @var HourlyRateRepository
     */
    private $getHourlyRateRepo;

    public function __construct(HourlyRateRepository $hourlyRateRepository)
    {
        $this->getHourlyRateRepo = $hourlyRateRepository;
    }

    public function profitLot(array $housings): float
    {
        $totalLots = $this->totalLots($housings);
        $profit = $this->profit($this->revenue($housings), $this->globalCost($housings));

        return round($profit / $totalLots, 2);
    }

    private function profit(float $revenue, float $cost)
    {
        return $revenue - $cost;
    }

    private function revenue(array $housings)
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
        foreach ($housings as $housing) {
            $totalLots += $housing->getNumberLot();
        }
        return $totalLots;
    }

    private function globalCost(array $housings)
    {
        return $this->getHourlyRateRepo->findOneBy([])->getRate() * $this->totalTime($housings);
    }
}
