<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Libraries\Token;

class Usuario extends Entity
{

    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em'
    ];


    // MÉTODO QUE VERIFICAR SE A SENHA E VÁLIDA/CORRETA
    public function verificaPassword(string  $password): bool
    {

        return password_verify($password, $this->senha_hash);
    }


    /**
     * MÉTODO QUE VALIDA SE O USUARIO LOGADO POSSUI A PERMISSÃO PARA VISUALIZAR/ACESSAR DETERMINADA ROTA
     * 
     * @param string $permissao
     * @return boolean
     * 
     */
    public function temPermissaoPara(string $permissao): bool
    {
        //  SE O USUARIO LOGADO E ADMIN , RETORNA VERDADEIRO 
        if ($this->is_admin == true) {
            return true;
        }

        // VALIDA SE O USUARIO POSSUI O ATRIBUTO PERMISSOES VAZIO , SIGNIFICA QUE ELE NÃO PARTE DE NENHUM GRUPO
        // OU O GRUPO NÃO TEM NENHUMA PERMISSÃO ATRIBUIDA
        if (empty($this->permissoes)) {
            return false;
        }

        // VERIFICA AS PERMISSÕES DO USUARIO LOGADO
        if (in_array($permissao, $this->permissoes) ==  false) {
            return false;
        }

        return true;
    }

    /**
     * MÉTODO QUE INICIA A RECUPERAÇÃO DE SENHA
     
     * @return void
     * 
     */
    public function iniciaPasswordReset(): void
    {
        $token = new Token();

        $this->reset_token = $token->getValue();

        $this->reset_hash = $token->getHash();

        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200);
    }

    /**
     * MÉTODO QUE FINALIZA O PROCESSO DE REDEFINIÇÃO DE SENHA , LIMPA OS CAMPOS reset_hash & reset_expira_em DA BASE DE DADOS
     
     * @return void
     * 
     */

    public function finalizaPasswordReset(): void
    {
        $this->reset_hash = null;
        $this->reset_expira_em = null;
    }
}
