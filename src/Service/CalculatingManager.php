<?php


namespace App\Service;

use App\Repository\HourlyRateRepository;
use DivisionByZeroError;

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

        if ($totalLots > 0) {
            return round($profit / $totalLots, 2);
        } else {
            throw new DivisionByZeroError('Le nombre total de lots ne peut pas être égal à 0');
        }
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
            $activities = $housing->getHousingActivities();
            $totalTime += $this->getHourActivities($activities);
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

    public function profitabilityCondo(array $housings): array
    {
        $condoProfit = [];
        foreach ($housings as $housing) {
            $activities = $housing->getHousingActivities();
            $hoursTotal = $this->getHourActivities($activities);

            $profit = $housing->getFee() - ($hoursTotal * $this->getHourlyRateRepo->findOneBy([])->getRate());
            $condoProfit[$housing->getName()] = round($profit, 2);
        }
        return $condoProfit;
    }

    private function getHourActivities(array $activities): float
    {
        $hoursTotal = 0;
        foreach ($activities as $activity) {
            $hours = $activity->getHour();
            $minutes = $activity->getMinute();
            $hours += $minutes / 60;
            $hoursTotal += $hours * $activity->getNumber();
        }
        return $hoursTotal;
    }
}
