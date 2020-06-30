<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 * @UniqueEntity("name")
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="L'activité doit comporter un nom")
     * @Assert\Length(max="100", maxMessage="Le nom de l'activité doit comporter {{ limit }} caractères maximum")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero(message="Le nombre d'heures allouées à une activité doit être égal à 0 ou positif")
     */
    private $hour;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max = 59,
     *     minMessage="Le nombre de minutes allouées à une activité doit être au minimum de {{ limit }}",
     *     maxMessage="Le nombre de minutes allouées à une activité doit être au maximum de {{ limit }}",
     * )
     */
    private $minute;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHour(): ?int
    {
        return $this->hour;
    }

    public function setHour(int $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
