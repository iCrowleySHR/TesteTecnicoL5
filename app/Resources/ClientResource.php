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
            'name'       => $user['name'],
            'email'      => $user['email'],
            'created_at' => $user['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at' => $user['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($users): array
    {
        return array_map(fn($user) => self::toArray($user), $users);
    }
}
