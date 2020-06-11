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
     *     mimeTypes = "text/csv",
     *     mimeTypesMessage = "Le format du fichier n'est pas valide (merci de vous référer au mode d'emploi)."
     * )
     */
    private $portfolioFileName;

    /**
     * @return mixed
     */
    public function getPortfolioFileName()
    {
        return $this->portfolioFileName;
    }

    public function setPortfolioFileName($portfolioFileName)
    {
        $this->portfolioFileName = $portfolioFileName;

        return $this;
    }
}
