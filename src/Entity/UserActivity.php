<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class UserActivity
{

    /**
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
