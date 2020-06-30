<?php

namespace App\Entity;

use App\Repository\HousingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HousingRepository::class)
 */
class Housing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postCode;

    /**
     * @ORM\Column(type="float")
     */
    private $fee;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberLot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLessThanTwoYears;

    /**
     * @ORM\Column(type="array")
     */
    private $housingActivities = [];

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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getFee(): ?float
    {
        return $this->fee;
    }

    public function setFee(float $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getNumberLot(): ?int
    {
        return $this->numberLot;
    }

    public function setNumberLot(int $numberLot): self
    {
        $this->numberLot = $numberLot;

        return $this;
    }

    public function getIsLessThanTwoYears(): ?bool
    {
        return $this->isLessThanTwoYears;
    }

    public function setIsLessThanTwoYears(bool $isLessThanTwoYears): self
    {
        $this->isLessThanTwoYears = $isLessThanTwoYears;

        return $this;
    }

    public function getHousingActivities(): ?array
    {
        return $this->housingActivities;
    }

    public function setHousingActivities(array $housingActivities): self
    {
        $this->housingActivities = $housingActivities;

        return $this;
    }
}
