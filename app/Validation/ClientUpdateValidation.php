<?php

namespace App\Validation;
use Config\Services;

class ClientUpdateValidation
{
    public static function validateUpdate(array $data): array
    {
        $validation = Services::validation();

        $rules = [
            'name' => 'permit_empty|min_length[3]|max_length[255]',
            'email' => 'permit_empty|valid_email|max_length[255]|is_unique[clients.email]',
            'password' => 'permit_empty|min_length[6]',
        ];

        $messages = [
            'name' => [
                'min_length' => 'O campo nome deve ter pelo menos 3 caracteres.',
                'max_length' => 'O campo nome não pode ter mais de 255 caracteres.',
            ],
            'email' => [
                'valid_email' => 'O campo email deve conter um endereço de email válido.',
                'max_length' => 'O campo email não pode ter mais de 255 caracteres.',
                'is_unique' => 'Este email já está cadastrado.',
            ],
            'password' => [
                'min_length' => 'O campo senha deve ter pelo menos 6 caracteres.',
            ],
        ];

        $validation->setRules($rules, $messages);

        if (!$validation->run($data)) {
            return ['errors' => $validation->getErrors()];
        }

        return [];
    }
}