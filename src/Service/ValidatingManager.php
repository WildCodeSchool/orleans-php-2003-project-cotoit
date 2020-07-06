<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatingManager
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validationLoop(array $input)
    {
        $errorMessages = [];
        foreach ($input as $data) {
            $errors = $this->validator->validate($data);
            for ($i = 0; $i < $errors->count(); $i++) {
                $error = $errors->get($i);
                $errorRoot = $error->getRoot();
                $errorMessages[$errorRoot->getActivity()] = $error->getMessage();
            }
        }
        return $errorMessages;
    }
}
