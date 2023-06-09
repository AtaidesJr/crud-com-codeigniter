<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoUsuarioModel extends Model
{

    protected $table            = 'grupos_usuarios';
    protected $returnType       = 'object';
    protected $allowedFields    = ['grupo_id', 'usuario_id', 'grupos_id'];


    // METODO QUE RECUPERA GRUPOS DE ACESSOS DO USUARIO
    // UTILIZADO NO CONTROLLER DE USUARIOS
    public function recuperaGruposDoUsuario(int $usuario_id, int $quantidade_paginacao)
    {

        $atributos = [
            'grupos_usuarios.id AS principal_id',
            'grupos.id AS grupo_id',
            'grupos.nome',
            'grupos.descricao'
        ];

        //SELECT NO BANCO DE DADOS 
        return $this->select($atributos)
            ->join('grupos', 'grupos.id = grupos_usuarios.grupo_id')
            ->join('usuarios', 'usuarios.id = grupos_usuarios.usuario_id')
            ->where('grupos_usuarios.usuario_id', $usuario_id)
            ->groupBy('grupos.nome')
            ->paginate($quantidade_paginacao);
    }


    /**
     * MÉTODO QUE RECUPERA O GRUPO AO QUAL O USUARIO ESTÁ LOGADO
     * IMPORTANTE : USADO APENAS PARA DEFINIR SE  O USUARIO ESTÁ NO GRUPO DE CLIENTE OU DE ADMIN
     * 
     * @param integer $grupo_id
     * @param integer $usuario_id
     * 
     * @return null|object
     */
    public function usuarioEstaNoGrupo(int $grupo_id, int $usuario_id)
    {
        return $this->where('grupo_id', $grupo_id)
            ->where('usuario_id', $usuario_id)
            ->first();
    }
}
