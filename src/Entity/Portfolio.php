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
     * @return mixed
     */
    public function getSecondTrimesterFile()
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
     * @return mixed
     */
    public function getThirdTrimesterFile()
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
     * @return mixed
     */
    public function getFourthTrimesterFile()
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
     * @return mixed
     */
    public function getActivityFile()
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
