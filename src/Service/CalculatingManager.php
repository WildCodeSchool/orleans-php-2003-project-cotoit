<?php


namespace App\Service;

use App\Repository\HourlyRateRepository;

class CalculatingManager
{
    /**
     * @var HourlyRateRepository
     */
    private $getHourlyRateRepo;

    /**
     * CalculatingManager constructor.
     * @param HourlyRateRepository $hourlyRateRepository
     */
    public function __construct(HourlyRateRepository $hourlyRateRepository)
    {
        $this->getHourlyRateRepo = $hourlyRateRepository;
    }

    /**
     * Compute profits per lot
     * @param array $housings
     * @return float
     */
    public function profitLot(array $housings): float
    {
        $totalLots = $this->totalLots($housings);
        $profit = $this->profit($this->revenue($housings), $this->globalCost($housings));

        return round($profit / $totalLots, 2);
    }

    /**
     * Compute total profit of portfolio
     * @param float $revenue
     * @param float $cost
     * @return float
     */
    private function profit(float $revenue, float $cost): float
    {
        return $revenue - $cost;
    }

    /**
     * Compute total revenue of portfolio
     * @param array $housings
     * @return float
     */
    private function revenue(array $housings): float
    {
        $profit = 0;
        foreach ($housings as $housing) {
            $profit += $housing->getFee();
        }
        return $profit;
    }

    /**
     * Compute total hours spent on activities for the whole portfolio
     * @param array $housings
     * @return float
     */
    private function totalTime(array $housings): float
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
        return $totalTime;
    }

    /**
     * Compute total number of lots in portfolio
     * @param array $housings
     * @return int
     */
    private function totalLots(array $housings): int
    {
        $totalLots = 0;
        foreach ($housings as $housing) {
            $totalLots += $housing->getNumberLot();
        }
        return $totalLots;
    }


    /**
     * Compute total cost of activities for the whole portfolio
     * @param array $housings
     * @return float
     */
    private function globalCost(array $housings): float
    {
        return $this->getHourlyRateRepo->findOneBy([])->getRate() * $this->totalTime($housings);
    }
}
