<?php

namespace App\DTOValidator;

use App\DTO\Input\Post\StorePostInputDTO;
use App\Exception\ValidateException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostDTOValidator
{

    public function __construct(
        private ValidatorInterface $validator,
    )
    {
    }

    public function validate(StorePostInputDTO $post): void
    {
        $errors = $this->validator->validate($post);

        if (count($errors) > 0) {
            $messages = [];

            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new ValidateException();
        }
    }
}
