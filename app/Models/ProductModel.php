<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'client_id_creator',
        'price',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'price' => 'required|decimal',
        'description' => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome do produto é obrigatório.',
            'min_length' => 'O nome do produto deve ter pelo menos 3 caracteres.',
        ],
        'price' => [
            'required' => 'O preço do produto é obrigatório.',
            'decimal' => 'O preço deve ser um número decimal válido.',
        ],
        'description' => [
            'min_length' => 'A descrição deve ter pelo menos 3 caracteres.',
            'required' => 'A descrição é obrigatório.',
        ],
    ];
}
