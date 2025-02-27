<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\ClientModel;

class JWTAuth
{
    private $key;
    private $model; 

    public function __construct()
    {
        $this->key = getenv('JWT_SECRET_KEY');
        $this->model = new ClientModel(); 
    }

    public function generateToken($data)
    {
        $data['exp'] = time() + (365 * 24 * 60 * 60); // 1 year duration
        return JWT::encode($data, $this->key, 'HS256');
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            
            if ($decoded->exp < time()) {
                return null; 
            }

            if ($this->model->find($decoded->id) === null) {
                return null;
            }

            return $decoded;
        } catch (\UnexpectedValueException $e) {
            log_message('error', 'Token inválido: ' . $e->getMessage());
        }
        return null;
    }
}
