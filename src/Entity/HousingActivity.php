<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class HousingActivity
{
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivity(UserActivity $userActivity): self
    {
        if (!$this->activities->contains($userActivity)) {
            $this->activities[] = $userActivity;
        }

        return $this;
    }
}
