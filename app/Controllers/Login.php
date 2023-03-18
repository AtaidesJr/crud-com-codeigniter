<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{


    public function novo()
    {
        $data = [
            'titulo' => 'Efetue o Login',
        ];

        return view('Login/novo', $data);
    }

    public function criar()
    {
        //VERIFICAR SE A REQUESIÇÃO ESTA SENDO PELA AJAX MESMO!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // RECUPERAR A INSTÂNCIA DO SERVIÇO 
        $autenticacao = service('autenticacao');



        if ($autenticacao->login($email, $password) === false) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'Por favor verifique os erros abaixo';
            $retorno['erros_model'] = ['crendenciais', 'Dados incorretos, verifique e tente novamente'];
            //RETORNO PARA O AJAX REQUEST
            return $this->response->setJSON($retorno);
        }

        // RECUPERAR O USUARIO LOGADO 
        $usuarioLogado = $autenticacao->retornaUsuarioLogado();


        session()->setFlashdata('sucesso', "Olá $usuarioLogado->nome, Seja Bem vindo!");

        // VALIDANDO SE UM CLIENTE
        if ($usuarioLogado->is_cliente) {

            $retorno['redirect'] = 'ordens/minhas';
            return $this->response->setJSON($retorno);
        }


        $retorno['redirect'] = 'home';
        return $this->response->setJSON($retorno);
    }

    public function logout()
    {
        // RECUPERAR A INSTÂNCIA DO SERVIÇO 
        $autenticacao = service('autenticacao');

        $usuarioLogado = $autenticacao->retornaUsuarioLogado();

        $autenticacao->logout();

        return redirect()->to(site_url("login/mostraMensagemLogout/$usuarioLogado->nome"));
    }

    public function mostraMensagemLogout($nome = null)
    {

        return redirect()->to(site_url("login"))->with("sucesso",  "$nome, esperamos ver você em breve!");
    }
}
