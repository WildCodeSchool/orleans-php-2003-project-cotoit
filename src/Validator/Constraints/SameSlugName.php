<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SameSlugName extends Constraint
{
    public $message = 'Le nom de la colonne {{ string }} n\'est pas valide.';
}
