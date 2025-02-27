<?php

namespace App\Controllers;

use App\Resources\OrderResource;
use App\Validation\OrderUpdateValidation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Order extends BaseController
{
    protected $modelName = 'App\Models\OrderModel';
    protected $format    = 'json';


    /**
     * Usado para mostrar as ordens do próprio cliente, pode usar parâmetros para busca e ID.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        if ($id !== null) {
            $order = $this->model->where('id', $id)
                ->where('client_id', $this->request->decodedToken->id)
                ->first();
    
            if ($order === null) {
                return $this->respondWithFormat([], 404, "Ordem não encontrada ou ordem de outro cliente.");
            }
    
            return $this->respondWithFormat(OrderResource::toArray($order), 200, "Ordem retornada com sucesso.");
        }
    
        $filters = [
            'client_id'         => $this->request->getGet('client_id'),
            'status'            => $this->request->getGet('status'),
            'created_at'        => $this->request->getGet('created_at'),
            'updated_at'        => $this->request->getGet('updated_at'),
        ];
    
        $perPage = $this->request->getGet('por_pagina') ?? 10;
        $page = $this->request->getGet('pagina') ?? 1;
    
        $query = $this->applyFilters($this->model, $filters);
        $orders = $query->paginate($perPage, 'page', $page);
    
        if (empty($orders)) {
            return $this->respondWithFormat([], 404, "Nenhuma ordem encontrada para este cliente.");
        }
    
        return $this->respondWithFormat(OrderResource::collection($orders), 200, "Ordens retornadas com sucesso.");
    }

    /**
     * Usado para criar novas ordens no banco.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($data === null) {
            return $this->respondWithFormat([], 400, "Nenhum dado foi enviado.");
        }

        $data['client_id'] = $this->request->decodedToken->id;

        if (!$this->model->insert($data)) {
            return $this->respondWithFormat($this->model->errors(), 400, "Erro ao cadastrar ordem.");
        }

        $order = $this->model->find($this->model->getInsertID());

        return $this->respondWithFormat(OrderResource::toArray($order), 201, "Ordem cadastrada com sucesso.");
    }


    /**
     * Usado para atualizar dados da ordem pelo ID.
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
    
        $validationResult = OrderUpdateValidation::validateUpdate($data);
        if (!empty($validationResult) && isset($validationResult['errors'])) {
            return $this->respondWithFormat($validationResult['errors'], 400, "Erro ao atualizar ordem.");
        }

        $order = $this->model->where('id',$id)->where('client_id', $this->request->decodedToken->id)->first();
        if (!$order) {
            return $this->respondWithFormat([], 404, "Ordem não encontrado ou você não pode editar essa ordem.");
        }
    
        if (!$this->model->update($id, $data)) {
            return $this->respondWithFormat([], 400, "Erro ao atualizar ordem.");
        }
        
        return $this->respondWithFormat(OrderResource::toArray($this->model->find($id)), 200, "Produto atualizado com sucesso.");
    }

    /**
     * Usado para deletar ordens pelo ID.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $order = $this->model->where('id', $id)->where('client_id', $this->request->decodedToken->id)->first(); 
        if ($order === null) {
            return $this->respondWithFormat([], 404, "Ordem não encontrado ou você não é o dono dele.");
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
                case 'status':
                    $query->where($key, $value);
                    break;
                case 'client_id':
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
