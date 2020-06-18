<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class UserActivity
{

    /**
     * @Assert\Type(type="App\Entity\Activity")
     * @Assert\Valid
     */
    private $activities;

    /**
     * @return mixed
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param mixed $activities
     */
    public function setActivities($activities): void
    {
        $this->activities = $activities;
    }
}
