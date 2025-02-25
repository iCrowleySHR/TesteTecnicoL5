<?php

namespace App\Filters;

use App\Libraries\JWTAuth;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JwtFilter implements FilterInterface
{
    private $jwtAuth;

    public function __construct()
    {
        $this->jwtAuth = new JWTAuth();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $token = $request->getHeaderLine('Authorization');

        if (!$token) {
            return \Config\Services::response()->setJSON([
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Token não fornecido.'
                ],
                'retorno' => []
            ])->setStatusCode(401);
        }

        $token = trim(str_replace('Bearer ', '', $token)); // Remove 'Bearer ' e espaços

        $decoded = $this->jwtAuth->validateToken($token);


        if (!$decoded) {
            return \Config\Services::response()->setJSON([
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Token inválido.'
                ],
                'retorno' => []
            ])->setStatusCode(401);
        }

        $request->decodedToken = $decoded;
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
