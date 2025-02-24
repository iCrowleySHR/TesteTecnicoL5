<?php
namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private static $key = env('JWT_SECRET_KEY');

    public static function generateToken($data)
    {
        return JWT::encode($data, self::$key, 'HS256');
    }

    public static function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
