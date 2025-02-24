<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private static $key;

    public function __construct()
    {
        self::$key = getenv('JWT_SECRET_KEY');
    }

    public static function generateToken($data)
    {
        $data['exp'] = time() + (365 * 24 * 60 * 60); // 1 year duration
        return JWT::encode($data, self::$key, 'HS256');
    }

    public static function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, 'HS256'));
            if ($decoded->exp < time()) {
                return null; 
            }
            return $decoded;
        } catch (\Exception $e) {
            log_message('error', 'Token inválido: ' . $e->getMessage());
            return null;
        }
    }
}
