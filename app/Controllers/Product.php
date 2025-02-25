<?php

namespace App\Controllers;

use App\Validation\ProductUpdateValidation;
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
        if ($id !== null) {
            $product = $this->model->where('id', $id)->first();
        } else {
            $product = $this->model->findAll();
        }
    
        if ($product === null || empty($product)) {
            return $this->respondWithFormat([], 404, "Produto não encontrado.");
        }
        
        return $this->respondWithFormat($product, 200, "Produto retornado com sucesso.");
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
        
        $validationResult = ProductUpdateValidation::validateUpdate($data);
        
        if (!empty($validationResult['errors'])) {
            return $this->respondWithFormat($validationResult['errors'], 400, "Erro na validação dos dados.");
        }
    
        $product = $this->model->where('id',$id)->where('client_id_creator', $this->request->decodedToken->id)->first();
        if (!$product) {
            return $this->respondWithFormat([], 404, "Produto não encontrado ou você não pode editar esse produto.");
        }
    
        if (!$this->model->update($id, $data)) {
            return $this->respondWithFormat([], 400, "Erro ao atualizar o produto.");
        }
    
        return $this->respondWithFormat($this->model->find($id), 200, "Produto atualizado com sucesso.");
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
        $product = $this->model->where('id', $id)->where('client_id_creator', $this->request->decodedToken)->first(); 
        if ($product === null) {
            return $this->respondWithFormat([], 404, "Produto não encontrado ou você não é o dono dele.");
        }
    
        if (!$this->model->delete($id)) {
            return $this->respondWithFormat([], 400, "Erro ao tentar deletar o produto.");
        }
    
        return $this->respondWithFormat([], 200, "Produto deletado com sucesso.");
    }
    
}
