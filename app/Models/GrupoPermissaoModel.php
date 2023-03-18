<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoPermissaoModel extends Model
{

    protected $table            = 'grupos_permissoes';
    protected $returnType       = 'object';
    protected $allowedFields    = ['grupos_id', 'permissao_id', 'grupo_id'];


    // METODO QUE RECUPERA AS PERMISSOES DO GRUPOS DE ACESSO
    public function recuperaPermissoesdoGrupo(int $grupo_id, int $quantidade_paginacao)
    {
        $atributos = [
            'grupos_permissoes.id AS principal_id', //SERÁ UTILIZADO COMO IDENTIFICADOR NO MOMENTO DE REMOÇÃO DO GRUPO
            'grupos.id AS grupo_id',
            'permissoes.id AS permissao_id',
            'permissoes.nome',
        ];

        return $this->select($atributos)
            ->join('grupos', 'grupos.id = grupos_permissoes.grupo_id')
            ->join('permissoes', 'permissoes.id = grupos_permissoes.permissao_id')
            ->where('grupos_permissoes.grupo_id', $grupo_id)
            ->groupBy('permissoes.nome')
            ->paginate($quantidade_paginacao);
    }
}
