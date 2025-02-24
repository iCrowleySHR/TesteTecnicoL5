<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'cpf',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'cpf' => 'required|exact_length[11]|is_unique[client.cpf]',
        'name' => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'cpf' => [
            'required' => 'O CPF é obrigatório.',
            'exact_length' => 'O CPF deve ter exatamente 11 caracteres.',
            'is_unique' => 'Este CPF já está cadastrado.',
        ],
        'name' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
        ],
    ];

}
