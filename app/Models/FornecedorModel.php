<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorModel extends Model
{

    protected $table            = 'fornecedores';
    protected $returnType       = 'App\Entities\Fornecedor';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [ //CAMPOS QUE PODEM SER EDITADOS DO BANCO DE DADOS!
        'razao',
        'cnpj',
        'ie',
        'telefone',
        'cep',
        'endereço',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'ativo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // VALIDAÇÃO
    protected $validationRules      = [
        'razao'        => 'required|max_length[230]|is_unique[fornecedores.razao,id,{id}]',
        'cnpj'         => 'required|validaCNPJ|max_length[25]|is_unique[fornecedores.cnpj,id,{id}]',
        'ie'           => 'required|max_length[25]|is_unique[fornecedores.cnpj,id,{id}]',
        'telefone'     => 'required|max_length[18]|is_unique[fornecedores.telefone,id,{id}]',
        'cep'          => 'required|max_length[11]',
        'endereço'     => 'required',
        'numero'       => 'max_length[45]',
        'bairro'       => 'required',
        'cidade'       => 'required',
        'estado'       => 'required',

    ];



    protected $validationMessages   = [

        /* 'nome'         => [
            'required'     => 'O campo nome é obrigatorio!',
            'min_length'   => 'O campo nome precisa ter pelo menos 3 caracteres!',
            'max_length'   => 'O campo não pode ser maior que 125 caracteres!',

        ],

        'email' => [
            'required'     => 'O campo e-mail é obrigatorio!',
            'max_length'   => 'O campo email não pode ser maior que 230 caracteres!',
            'is_unique'    => 'Esse e-mail já foi cadastrado',
        ],

        'confirmacao_senha' => [
            'required_with' => 'Por favor confirme sua senha!',
            'matches'       => 'As senhas não conferem , tente novamente.',

        ], */];
}
