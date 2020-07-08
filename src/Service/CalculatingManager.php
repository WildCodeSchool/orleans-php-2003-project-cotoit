<?php


namespace App\Service;

use App\Entity\UserActivity;
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

    /**
     * Compute cost for one activity
     * @param float $hours
     * @return float
     */
    private function costActivity(float $hours): float
    {
        return $hours * $this->getHourlyRateRepo->findOneBy([])->getRate();
    }

    /**
     * Compute profits for each condo
     * @param array $housings
     * @return array
     */
    public function profitabilityCondo(array $housings): array
    {
        $condoProfit = [];
        $hourlyRate = $this->getHourlyRateRepo->findOneBy([])->getRate();
        foreach ($housings as $housing) {
            $activities = $housing->getHousingActivities();
            $hoursTotal = $this->getHourActivities($activities);

            $profit = $housing->getFee() - ($hoursTotal * $hourlyRate);
            $condoProfit[$housing->getName()]['profit'] = round($profit, 2);
        }
        return $condoProfit;
    }

    /**
     * Compute total hours spent on activities for one condo
     * @param array $activities
     * @return float
     */
    private function getHourActivities(array $activities): float
    {
        $hoursTotal = 0;
        foreach ($activities as $activity) {
            $hours = $activity->getHour();
            $minutes = $activity->getMinute();
            $hours += $this->minutesToHours($minutes);
            $hoursTotal += $hours * $activity->getNumber();
        }
        return $hoursTotal;
    }

    /**
     * Compute hours spent on one activity
     * @param UserActivity $activity
     * @return float
     */
    private function timeActivity(UserActivity $activity): float
    {
        return $activity->getHour() + $this->minutesToHours($activity->getMinute());
    }

    /**
     * Transform minutes into an hour float
     * @param int $minutes
     * @return float
     */
    private function minutesToHours(int $minutes): float
    {
        return $minutes / 60;
    }

    /**
     * Get an array of housing objects based on their name
     * @param array $housings
     * @param array $housingNames
     * @return array
     */
    public function getHousingFromName(array $housings, array $housingNames): array
    {
        $selectedHousings = [];
        for ($i = 0; $i < count($housingNames); $i++) {
            foreach ($housings as $housing) {
                if ($housing->getName() == $housingNames[$i]) {
                    $selectedHousings[] = clone $housing;
                    continue;
                }
            }
        }
        return $selectedHousings;
    }

    /**
     * Compute the total cost for one condo
     * @param array $deficitHousings
     * @param array $deficitHousingArray
     * @return array
     */
    public function costsPerCondo(array $deficitHousings, array $deficitHousingArray)
    {
        foreach ($deficitHousings as $deficitHousing) {
            $condoName = $deficitHousing->getName();
            $housingActivities = $deficitHousing->getHousingActivities();

            $deficitHousingArray = $this->costPerActivity($deficitHousingArray, $housingActivities, $condoName);
        }
        return $deficitHousingArray;
    }

    /**
     * Compute the cost for one activity
     * @param array $deficitHousingArray
     * @param array $activities
     * @param string $condoName
     * @return array
     */
    private function costPerActivity(array $deficitHousingArray, array $activities, string $condoName): array
    {
        $totalCost = 0;
        foreach ($activities as $activity) {
            $hours = $this->timeActivity($activity);
            $hoursTotal = ($hours * $activity->getNumber());
            $cost = $this->costActivity($hoursTotal);
            $totalCost += $cost;

            $deficitHousingArray[$condoName]['activities'][$activity->getActivity()] = $cost;
        }
        $deficitHousingArray[$condoName]['totalCost'] = $totalCost;

        return $deficitHousingArray;
    }

    /**
     * Compute cost percentage of total cost per activity
     * @param array $deficitHousings
     * @param array $deficitHousingArray
     * @return array
     */
    public function percentageLossActivity(array $deficitHousings, array $deficitHousingArray): array
    {
        $deficitHousingArray = $this->costsPerCondo($deficitHousings, $deficitHousingArray);

        foreach ($deficitHousingArray as $deficitHousingName => $deficitHousing) {
            $activities = $deficitHousing['activities'];
            foreach ($activities as $activityName => $activityCost) {
                $percentage = ($activityCost / $deficitHousing['totalCost']) * 100;
                $activities[$activityName] = $percentage;
            }
            $deficitHousingArray[$deficitHousingName]['activities'] = $activities;

            arsort($deficitHousingArray[$deficitHousingName]['activities'], SORT_NUMERIC);
            $deficitHousingArray[$deficitHousingName]['activities'] = array_slice(
                $deficitHousingArray[$deficitHousingName]['activities'],
                0,
                3,
                true
            );
        }
        return $deficitHousingArray;
    }
}
