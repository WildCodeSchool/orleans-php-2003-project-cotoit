<?php


namespace App\Entity;

class UserActivity
{
    private $activity;

    private $hour;

    private $minute;

    private $number;

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     */
    public function setActivity($activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @return integer
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param integer $hour
     */
    public function setHour($hour): void
    {
        $this->hour = $hour;
    }

    /**
     * @return integer
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param integer $minute
     */
    public function setMinute($minute): void
    {
        $this->minute = $minute;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param integer $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }
}
