<?php


namespace App\Entity;

class HousingActivity
{
    private $userActivity;

    private $number;

    /**
     * @return mixed
     */
    public function getUserActivity()
    {
        return $this->userActivity;
    }

    /**
     * @param mixed $userActivity
     */
    public function setUserActivity($userActivity): void
    {
        $this->userActivity = $userActivity;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }
}
