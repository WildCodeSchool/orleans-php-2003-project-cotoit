<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Portfolio
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Le fichier est trop lourd {{ size }} {{ suffix }}.
     La taille maximum autorisée est de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"text/plain", "text/csv"},
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $firstTrimesterFile;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Le fichier est trop lourd {{ size }} {{ suffix }}.
    La taille maximum autorisée est de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"text/plain", "text/csv"},
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $secondTrimesterFile;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Le fichier est trop lourd {{ size }} {{ suffix }}.
    La taille maximum autorisée est de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"text/plain", "text/csv"},
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $thirdTrimesterFile;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Le fichier est trop lourd {{ size }} {{ suffix }}.
    La taille maximum autorisée est de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"text/plain", "text/csv"},
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $fourthTrimesterFile;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Le fichier est trop lourd {{ size }} {{ suffix }}.
    La taille maximum autorisée est de {{ limit }} {{ suffix }}.",
     *     mimeTypes = {"text/plain", "text/csv"},
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $activityFile;

    /**
     * @return mixed
     */
    public function getFirstTrimesterFile()
    {
        return $this->firstTrimesterFile;
    }

    public function setFirstTrimesterFile($firstTrimesterFile)
    {
        $this->firstTrimesterFile = $firstTrimesterFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecondTrimesterFile(): string
    {
        return $this->secondTrimesterFile;
    }

    /**
     * @param string $secondTrimesterFile
     */
    public function setSecondTrimesterFile(string $secondTrimesterFile): void
    {
        $this->secondTrimesterFile = $secondTrimesterFile;
    }

    /**
     * @return string
     */
    public function getThirdTrimesterFile(): string
    {
        return $this->thirdTrimesterFile;
    }

    /**
     * @param string $thirdTrimesterFile
     */
    public function setThirdTrimesterFile(string $thirdTrimesterFile): void
    {
        $this->thirdTrimesterFile = $thirdTrimesterFile;
    }

    /**
     * @return string
     */
    public function getFourthTrimesterFile(): string
    {
        return $this->fourthTrimesterFile;
    }

    /**
     * @param string $fourthTrimesterFile
     */
    public function setFourthTrimesterFile(string $fourthTrimesterFile): void
    {
        $this->fourthTrimesterFile = $fourthTrimesterFile;
    }

    /**
     * @return string
     */
    public function getActivityFile(): string
    {
        return $this->activityFile;
    }

    /**
     * @param string $activityFile
     */
    public function setActivityFile(string $activityFile): void
    {
        $this->activityFile = $activityFile;
    }
}
