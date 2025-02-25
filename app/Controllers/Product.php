<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Product extends BaseController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
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
        $data = $this->verifyIfEmptyRequest($this->request);
        if ($data === null) {
            return $this->respondWithFormat([], 400, "Nenhum dado foi enviado.");
        }

        $data['client_id_creator'] = $this->request->decodedToken->id;
    
        if (!$this->model->insert($data)) {
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao cadastrar produto.");
        }

        $productId = $this->model->insertID();
        $data['id'] = $productId;

        return $this->respondWithFormat($data, 201, "Produto cadastrado com sucesso.");
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
        $decoded = $this->request->decodedToken;
    
        $product = $this->model->where('id', $id) 
                               ->where('client_id_creator', $decoded->id) 
                               ->first(); 
        if ($product === null) {
            return $this->respondWithFormat([], 404, "Produto não encontrado ou você não é o dono dele.");
        }
    
        if (!$this->model->delete($id)) {
            return $this->respondWithFormat([], 400, "Erro ao tentar deletar o produto.");
        }
    
        return $this->respondWithFormat([], 200, "Produto deletado com sucesso.");
    }
    
}
