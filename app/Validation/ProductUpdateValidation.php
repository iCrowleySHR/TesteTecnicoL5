<?php

namespace App\Validation;
use Config\Services;

class ProductUpdateValidation
{
    public static function validateUpdate(array $data): array
    {
        $validation = Services::validation();

        $rules = [
            'name' => 'permit_empty|min_length[3]|max_length[255]',
            'price' => 'permit_empty|decimal',
            'description' => 'permit_empty|min_length[3]',
        ];

        $messages = [
            'name' => [
                'min_length' => 'O campo nome deve ter pelo menos 3 caracteres.',
                'max_length' => 'O campo nome não pode ter mais de 255 caracteres.',
            ],
            'price' => [
                'decimal' => 'O campo preço deve ser um valor decimal válido.',
            ],
            'description' => [
                'min_length' => 'O campo descrição deve ter pelo menos 3 caracteres.',
            ],
        ];

        $validation->setRules($rules, $messages);

        if (!$validation->run($data)) {
            return ['errors' => $validation->getErrors()];
        }

        return [];
    }
}
