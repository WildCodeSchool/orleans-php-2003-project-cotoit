<?php

namespace App\Entity;

use App\Repository\ManualRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ManualRepository::class)
 */
class Manual
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le manuel doit comporter un texte")
     */
    private $instruction;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le manuel doit comporter un texte")
     */
    private $calculation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(string $instruction): self
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getCalculation(): ?string
    {
        return $this->calculation;
    }

    public function setCalculation(string $calculation): self
    {
        $this->calculation = $calculation;

        return $this;
    }
}
