<?php

namespace App\Controllers;

use App\Libraries\Autenticacao;

class Home extends BaseController
{
    public function index()
    {

        $data = [
            'titulo' => 'Home'
        ];

        return view('Home/index', $data);
    }


    public function login()
    {
        /* $autenticacao = service('autenticacao');

        $autenticacao->login('juniorferreira020@gmail.com', '12345678');
        #$autenticacao->login('mayra@hotmail.com', '123456789');

        $usuario = $autenticacao->retornaUsuarioLogado();

        dd($usuario);

        $autenticacao->Logout();
        return redirect()->to(site_url('/'));

        dd($autenticacao->usuarioLogado()); */
    }

    public function email()
    {
        $email = service('email');

        $email->setFrom('no-reply@ordem.com', 'Ordem de serviço LTDA');
        $email->setTo('camiloteixeira038@gmail.com');

        $email->setSubject('Recuperação de senha');
        $email->setMessage('Iniciando a recuperação de senha');

        if ($email->send()) {
            echo 'Email Enviado';
        } else {
            echo $email->printDebugger();
        }
    }
}
