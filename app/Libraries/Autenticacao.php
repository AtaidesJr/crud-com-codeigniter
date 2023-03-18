<?php

namespace App\Libraries;

class Autenticacao
{

    private $usuario;
    private $usuarioModel;
    private $grupoUsuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
        $this->grupoUsuarioModel = new \App\Models\grupoUsuarioModel();
    }



    // METODO  QUE REALIZA O LOGIN NA A APLICAÇÃO
    public function login(string $email, string $password): bool
    {

        // BUSCAMOS O USUARIO DEFINIDO NO * MODELS -> usuarioModel.php *  
        $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

        if ($usuario === null) {
            exit('usuário não encontrado');
            return false;
        }

        // VERIFICA SE A SENHA E VÁLIDA , MÉTODO INVOCADO APARTIR DE   * ENTITIES -> USUARIO.PHP *
        if ($usuario->verificaPassword($password) == false) {
            exit('senha inválida');
            return false;
        }

        // VERIFICA SE O USUARIO ESTÁ ATIVO E PODE REALIZAR LOGIN NO SISTEMA , FALSE = USUARIO DESATIVADO NÂO PODE LOGAR
        if ($usuario->ativo == false) {

            exit('Usuario Desativado');

            return false;
        }

        // REALIZAR O LOGIN DO USUARIO NO SISTEMA
        $this->logaUsuario($usuario);

        // RETORNA TRUE , O USUARIO PODE REALIZAR O LOGIN
        return true;
    }



    // METODO DE LOGOUT  DO USUARIO
    public function Logout(): void
    {
        // LOGOUT DO USUARIO ,  FINALIZA A SESSÃO 
        session()->destroy();
    }



    public function  retornaUsuarioLogado()
    {
        if ($this->usuario === null) {

            //  BUSCAR O USUARIO QUE ESTÁ LOGADO 
            $this->usuario = $this->retornaUsuarioDaSessao();
        }

        return $this->usuario;
    }



    /**
     *  MÉTODO QUE VERIFICAR SE O USUARIO ESTÁ LOGADO
     * 
     * @return boolean
     */
    public function usuarioLogado(): bool
    {
        return $this->retornaUsuarioLogado() !== null;
    }



    // ----------------- MÉTODOS PROIVADOS -------------------- //

    /**
     * MÉTODO QUE INSERE NA SESSÃO O ID DO USUÁRIO
     * 
     * @param object $usuario
     * 
     * @return void
     */
    private function logaUsuario(object $usuario): void
    {

        // RECUPERA A INSTÂNCIA DA SESSÃO
        $session = session();

        // ANTES DE INSERIR O ID DO USUARIO NA SESSÃO , VAI GERAR UM NOVO ID PARA A SESSÃO
        $_SESSION['__ci_last_regenerate'] = time();

        // SETAMOS NA SESSÃO O ID DO USUÁRIO
        $session->set('usuario_id', $usuario->id);
    }



    /**
     * MÉTODO QUE RECUPERA DA SESSÃO E VALIDA O USUARIO LOGADO
     *
     * @return null|object
     * 
     */

    private function retornaUsuarioDaSessao()
    {

        if (session()->has('usuario_id') == false) {
            return null;
        }

        // BUSCA O USUARIO NA BASE DE DADOS
        $usuario = $this->usuarioModel->find(session()->get('usuario_id'));

        // VALIDA SE O USUARIO EXISTE E SE ESTÁ ATIVO PARA REALIZAR O LOGIN NO SISTEMA
        if ($usuario == null || $usuario->ativo == false) {
            return null;
        }

        // DEFINIR AS PERMISSÕES DO USUÁRIO LOGADO 
        $usuario = $this->definePermissaoUsuarioLogado($usuario);


        // RETORNA O USUARIO
        return $usuario;
    }



    /**
     * MÉTODO QUE VERIFICAR SE O USUARIO LOGADO ESTÁ ASSOCIADO AO GRUPO ADMINISTRADOR
     *
     * @return true|false
     */
    private function isAdmin(): bool
    {
        // ID DO GRUPO ADMINISTRADOR
        $grupoAdmin = 1;

        // VERIFICAR SE O USUARIO LOGADO ESTÁ NO GRUPO DE ADMINISTRADOR
        $administrador = $this->grupoUsuarioModel->usuarioEstaNoGrupo($grupoAdmin, session()->get('usuario_id'));

        // VERIFICAR SE EXISTE ALGUM REGISTRO DE LOGIN
        if ($administrador == null) {
            return false;
        }

        // RETORNA VERDADEIRO , OU SEJA , O USUARIO LOGADO FAZ PARTE DO GRUPO ADMIN
        return true;
    }


    /**
     * MÉTODO QUE VERIFICAR SE O USUARIO LOGADO ESTÁ ASSOCIADO AO GRUPO CLIENTE
     *
     * @return true|false
     * 
     */
    private function isCliente(): bool
    {
        // ID DO GRUPO ADMINISTRADOR
        $grupoCliente = 2;

        // VERIFICAR SE O USUARIO LOGADO ESTÁ NO GRUPO DE ADMINISTRADOR
        $cliente = $this->grupoUsuarioModel->usuarioEstaNoGrupo($grupoCliente, session()->get('usuario_id'));

        // VERIFICAR SE EXISTE ALGUM REGISTRO DE LOGIN
        if ($cliente == null) {
            return false;
        }

        // RETORNA VERDADEIRO , OU SEJA , O USUARIO LOGADO FAZ PARTE DO GRUPO ADMIN
        return true;
    }



    /**
     * MÉTODO QUE DEFINE AS PERMISSÕES QUE O USUARIO LOGADO POSSUI
     * É UTILIZADO EXCLUSIVAMENTE NO MÉTODO retornaUsuarioDaSessão()
     * 
     * @param object $usuario
     * 
     * @return object
     * 
     */
    private function definePermissaoUsuarioLogado(object $usuario): object
    {
        // DEFINIMOS SE O USUÁRIO LOGADO É ADMIN
        // ATRIBUTO is_admin É UTILIZADO  NO MÉTODO temPermissaoPara() NA ENTITIES USUARIOS
        $usuario->is_admin = $this->isAdmin();


        if ($usuario->is_admin == true) {

            $usuario->is_cliente = false;

            //

        } else {

            // VERIFICAR SE O USUÁRIO LOGADO É UM CLIENTE
            $usuario->is_cliente = $this->isCliente();
        }

        // VERIFICAR SE O USUARIO NÃO É ADMIN E NEM CLIENTE
        if ($usuario->is_admin == false && $usuario->is_cliente == false) {


            /* O ATRIBUTO $usuario->permissoes SERÁ EXAMINADO NA ENTITIES USUARIOS.PHP
               SE O USUARIO LOGADO POSSUI O ATRIBUTO $usuario->permissoes SIGNIFICA QUE ELE NÃO
               PERTENCE NEM UM DOS DOIS GRUPOS , ADMIN OU CLIENTE  */
            $usuario->permissoes = $this->recuperaPermissaoUsuarioLogado();
        }

        return $usuario;
    }



    /**
     * MÉTODO QUE RETORNA AS PERMISSÕES DO USUARIO LOGADO
     * 
     * @return array
     * 
     */
    private function recuperaPermissaoUsuarioLogado(): array
    {
        $permissoesDoUsuario = $this->usuarioModel->recuperaPermissaoUsuarioLogado(session()->get('usuario_id'));

        return array_column($permissoesDoUsuario, 'permissao');
    }
}
