<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'cpf',
        'name',
        'created_at',
        'updated_at',
        'email',
        'password'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'cpf' => 'required|exact_length[11]|is_unique[clients.cpf]',
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[clients.email]',
        'password' => 'required|min_length[6]',
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
        'email' => [
            'required' => 'O email é obrigatório.',
            'valid_email' => 'O email deve ser válido.',
            'is_unique' => 'Este email já está cadastrado.',
        ],
        'password' => [
            'required' => 'A senha é obrigatória.',
            'min_length' => 'A senha deve ter pelo menos 6 caracteres.',
        ],
    ];

}
