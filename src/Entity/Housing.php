<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Housing
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(max = 255, maxMessage="Le nom de la copropriété doit comporter {{ limit }} caractères maximum")
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(max = 100, maxMessage="Le code postal doit comporter {{ limit }} caractères maximum")
     */
    private $postCode;

    /**
     * @var float
     * @Assert\PositiveOrZero(message="L'honoraire doit être égal à 0 ou positif")
     */
    private $fee;

    /**
     * @var int
     * @Assert\PositiveOrZero(message="Le nombre de lot doit être égal à 0 ou positif")
     */
    private $numberLot;

    /**
     * @var array
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
