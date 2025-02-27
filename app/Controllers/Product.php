<?php

namespace App\Controllers;

use App\Resources\ProductResource;
use App\Validation\ProductUpdateValidation;
use CodeIgniter\HTTP\ResponseInterface;

class Product extends BaseController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    /**
     * Usado para mostrar os produtos de todos cliente, pode usar parâmetros para busca e ID.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        if ($id !== null) {
            $product = $this->model->where('id', $id)->first();
    
            if ($product === null) {
                return $this->respondWithFormat("Produto não encontrado.", 404);
            }
    
            return $this->respondWithFormat(ProductResource::toArray($product), 200, "Produto retornado com sucesso.");
        }
    
        $filters = [
            'client_id_creator' => $this->request->getGet('client_id_creator'),
            'price'             => $this->request->getGet('price'),
            'name'              => $this->request->getGet('name'),
            'description'       => $this->request->getGet('description'),
            'created_at'        => $this->request->getGet('created_at'),
            'updated_at'        => $this->request->getGet('updated_at'),
        ];
    
        $perPage = $this->request->getGet('por_pagina') ?? 10;
        $page = $this->request->getGet('pagina') ?? 1;
    
        $query = $this->applyFilters($this->model, $filters);
        $products = $query->paginate($perPage, 'page', $page);
    
        return $this->respondWithFormat(ProductResource::collection($products), 200, "Produtos retornados com sucesso.");
    }
    
    
    
    
    /**
     * Usado para criar produtos.
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

        $product = $this->model->find($this->model->insertID());

        return $this->respondWithFormat(ProductResource::toArray($product), 201, "Produto cadastrado com sucesso.");
    }

    /**
     * Usado para atualizar produtos criado pelo próprio cliente pelo ID.
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
        
        return $this->respondWithFormat(ProductResource::toArray($this->model->find($id)), 200, "Produto atualizado com sucesso.");
    }
    

    /**
     * Usado para deletar produtos criado pelo próprio cliente pelo ID.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $product = $this->model->where('id', $id)->where('client_id_creator', $this->request->decodedToken->id)->first(); 
        if ($product === null) {
            return $this->respondWithFormat([], 404, "Produto não encontrado ou você não é o dono dele.");
        }
    
        if (!$this->model->delete($id)) {
            return $this->respondWithFormat([], 400, "Erro ao tentar deletar o produto.");
        }
    
        return $this->respondWithFormat([], 200, "Produto deletado com sucesso.");
    }

    /**
     * Usado para aplicar os filtros na consulta da função show.
     * @param mixed $query
     * @param mixed $filters
     */
    private function applyFilters($query, $filters)
{
    foreach ($filters as $key => $value) {
        if (!empty($value)) {
            switch ($key) {
                case 'name':
                case 'description':
                    $query->like($key, $value);
                    break;
                case 'client_id_creator':
                case 'price':
                    $query->where($key, $value);
                    break;
                case 'created_at':
                case 'updated_at':
                    $query->where("DATE($key)", $value);
                    break;
            }
        }
    }
    return $query;
}
    
}
