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
     * @Assert\NotBlank(message="Le nombre d'heures allouées à l'activité doit être défini")
     * @Assert\PositiveOrZero(message="Le nombre d'heures allouées à l'activité doit être égal à 0 ou positif")
     */
    private $hours;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max = 59,
     *     minMessage="Le nombre de minutes allouées à l'activité doit être au minimum de {{ min }}",
     *     maxMessage="Le nombre de minutes allouées à l'activité doit être au maximum de {{ max }}",
     * )
     */
    private $minutes;

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

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getMinutes(): ?int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }
}
