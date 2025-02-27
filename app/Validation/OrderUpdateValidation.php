<?php

namespace App\Validation;
use Config\Services;

class OrderUpdateValidation
{
    public static function validateUpdate(array $data): array
    {
        $validation = Services::validation();

        $rules = [
            'quantity' => 'permit_empty|integer',
            'status' => 'permit_empty|in_list[Em Aberto,Pago,Cancelado]',
        ];

        $messages = [
            'quantity' => [
                'integer' => 'O campo quantidade deve ser um número inteiro.',
            ],
            'status' => [
                'in_list' => 'O campo status deve ser um dos seguintes valores: Em Aberto, Pago ou Cancelado.',
            ],
        ];

        $validation->setRules($rules, $messages);

        if (!$validation->run($data)) {
            return ['errors' => $validation->getErrors()];
        }

        return [];
    }
}
