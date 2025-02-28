<?php

namespace App\Resources;

class ClientResource
{
    public static function toArray($user): array
    {
        if (is_object($user)) {
            $user = (array) $user;
        }

        return [
            'id'         => $user['id'] ?? null,
            'cpf'        => $user['cpf'],
            'nome'       => $user['name'],
            'email'      => $user['email'],
            'criado_em' => $user['created_at'] ?? date('Y-m-d H:i:s'),
            'atualizado_em' => $user['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($users): array
    {
        return array_map(fn($user) => self::toArray($user), $users);
    }
}
