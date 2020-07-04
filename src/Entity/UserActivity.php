<?php


namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("activity")
 */
class UserActivity
{
    /**
     * @Assert\NotBlank("L'activité doit porter un nom")
     * @Assert\Length(max="100", maxMessage="Le nom de l'activité doit comporter {{ limit }} caractères maximum")
     */
    private $activity;

    /**
     * @Assert\PositiveOrZero(message="Le nombre d'heures allouées à une activité doit être égal à 0 ou positif")
     */
    private $hour;

    /**
     * @Assert\Range(
     *     min = 0,
     *     max = 59,
     *     minMessage="Le nombre de minutes allouées à une activité doit être au minimum de {{ limit }}",
     *     maxMessage="Le nombre de minutes allouées à une activité doit être au maximum de {{ limit }}",
     * )
     */
    private $minute;

    /**
     * @Assert\PositiveOrZero(message="Le nombre d'activités allouées doit être égal à 0 ou positif")
     */
    private $number;

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity): void
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param mixed $hour
     */
    public function setHour($hour): void
    {
        $this->hour = $hour;
    }

    /**
     * @return mixed
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param mixed $minute
     */
    public function setMinute($minute): void
    {
        $this->minute = $minute;
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
