<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'client_id',
        'product_id',
        'quantity',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'product_id' => 'required|is_not_unique[products.id]',
        'quantity' => 'required|integer',
        'status' => 'required|in_list[Em Aberto,Pago,Cancelado]',
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'O ID do produto é obrigatório.',
            'is_not_unique' => 'Este ID de produto não existe.',
        ],
        'quantity' => [
            'required' => 'A quantidade é obrigatória.',
            'integer' => 'A quantidade deve ser um número inteiro.',
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list' => 'O status deve ser um dos seguintes: Em Aberto, Pago, Cancelado.',
        ],
    ];
}
