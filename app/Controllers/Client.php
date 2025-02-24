<?php

namespace App\Controllers;

use App\Libraries\JWTAuth;
use CodeIgniter\HTTP\ResponseInterface;

class Client extends BaseController
{
    protected $modelName = 'App\Models\ClientModel';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $jwtAuth = new JWTAuth();

        $data = $this->request->getJSON(true);
        $client = $this->model->where('cpf', $data['cpf'])->first();
        
        if(!$client){
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao autenticar cliente.");
        }

        $token = $jwtAuth::generateToken($client);

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
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);

        if(!$this->validateCpf($data['cpf'])){
            return $this->respondWithFormat([], 400, "CPF inválido.");
        }

        if (!$this->model->insert($data)) {
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao cadastrar cliente.");
        }
    
        return $this->respondWithFormat($data, 201, "Cliente cadastrado com sucesso.");
    }
    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
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
        //
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
        //
    }
}
