<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{

    protected $table            = 'grupos';
    protected $returnType       = 'App\Entities\Grupo';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'descricao', 'exibir']; //CAMPOS QUE PODEM SER EDITADOS DO BANCO DE DADOS!

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // VALIDAÇÃO
    protected $validationRules      = [
        'nome'        => 'required|is_unique[grupos.nome,id,{id}]|max_length[128]',
        'descricao'   => 'required|max_length[240]',
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio!',
        ]
    ];
}
