<?php

namespace App\Controllers;

use App\Libraries\JWTAuth;
use App\Resources\ClientResource;
use App\Validation\ClientUpdateValidation;
use CodeIgniter\HTTP\ResponseInterface;

class Client extends BaseController
{
    protected $modelName = 'App\Models\ClientModel';
    protected $format    = 'json';
    private $jwtAuth;

    public function __construct()
    {
        $this->jwtAuth = new JWTAuth();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function auth()
    {
        $data = $this->request->getJSON(true);
        if ($data === null || empty($data['email']) || empty($data['password'])) {
            return $this->respondWithFormat([], 400, "Nenhum dado foi enviado.");
        }

        $client = $this->model->where('email', $data['email'])->first();
        
        if(!$client || !password_verify($data['password'], $client['password'])){
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao autenticar cliente.");
        }

        unset($client['password']);
        $token = $this->jwtAuth->generateToken($client);

        return $this->respondWithFormat(["token" => $token], 201, "Cliente autenticado com sucesso.");
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $client = $this->model->find($this->request->decodedToken->id);
        return $this->respondWithFormat(ClientResource::toArray($client) , 200, "Dados do cliente retornados com sucesso.");
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($data === null) {
            return $this->respondWithFormat([], 400, "Nenhum dado foi enviado.");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if(!$this->validateCpf($data['cpf'])){
            return $this->respondWithFormat([], 400, "CPF inválido.");
        }

        if (!$this->model->insert($data)) {
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao cadastrar cliente.");
        }
        
        $client = $this->model->find($this->model->getInsertID());

        return $this->respondWithFormat(ClientResource::toArray($client), 201, "Cliente cadastrado com sucesso.");
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($data === null) {
            return $this->respondWithFormat([], 400, "Nenhum dado foi enviado.");
        }
    
        $validationResult = ClientUpdateValidation::validateUpdate($data);
    
        if (!empty($validationResult) && isset($validationResult['errors'])) {
            return $this->respondWithFormat($validationResult['errors'], 400, "Erro ao atualizar cliente.");
        }
        
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
    
        if (!$this->model->update($this->request->decodedToken->id, $data)) {
            return $this->respondWithFormat([], 400, "Erro ao tentar atualizar o cliente.");
        }

        $client = $this->model->find($this->request->decodedToken->id);

        return $this->respondWithFormat(ClientResource::toArray($client), 200, "Cliente atualizado com sucesso.");
    }
    
    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $deleteResult = $this->model->delete($this->request->decodedToken);

        if ($deleteResult === false) {
            return $this->respondWithFormat([], 400, "Erro ao tentar deletar o cliente.");
        }
    
        return $this->respondWithFormat([], 200, "Cliente deletado com sucesso.");
    }
}
