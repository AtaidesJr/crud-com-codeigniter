<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController
{

    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }



    public function esqueci()
    {
        $data = [
            'titulo' => 'Esqueçi a Senha'
        ];

        return view('Password/esqueci', $data);
    }



    public function processaEsqueci()
    {
        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();


        // RECUPERA O E-MAIL DA REQUESIÇÃO DE REDEFINIR SENHA 
        $email = $this->request->getPost('email');

        $usuario = $this->usuarioModel->buscaUsuarioPorEmail($email);

        if ($usuario === null || $usuario->ativo === false) {

            $retorno['erro'] = 'Esse e-mail e inválido';
            return $this->response->setJSON($retorno);
        }

        $usuario->iniciaPasswordReset();


        $this->usuarioModel->save($usuario);

        $this->enviaEmailRedefinicaoSenha($usuario);

        return $this->response->setJSON([]);
    }




    public function resetEnviado()
    {
        $data = [
            'titulo' => 'E-mail enviado para sua caixa de entrada! '
        ];

        return view('Password/reset_enviado', $data);
    }




    public function reset($token = null)
    {

        // VERIFICAR SE O LINK AINDA E VÁLIDO OU SE NÃO EXPIROU 
        if ($token === null) {

            return redirect()->to(site_url("password/esqueci"))->with("atencao", "Link inválido ou expirado");
        }

        # VERIFICAR O USUARIO NA BASE DE DADOS DE ACORDO COM HASH DO TOKE QUE E SETADO COMO PARÂMETRO
        # MÈTODO DEFINIDO PARA VÁLIDAR : UsuarioModel -> buscaUsuarioPorTokenHash.php

        $usuario = $this->usuarioModel->buscaUsuarioPorTokenHash($token);

        if ($usuario === null) {
            return redirect()->to(site_url("password/esqueci"))->with("atencao", "Link inválido ou expirado");
        }

        $data = [
            'titulo' =>  "Crie a sua nova senha de acesso",
            'token' => $token,
        ];

        return view('Password/reset', $data);
    }


    public function processaReset()
    {

        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        # RECUPERAR TODOS OS DADOS DO POST  
        $post = $this->request->getPost();

        $usuario = $this->usuarioModel->buscaUsuarioPorTokenHash($post['token']);

        # VALIDAR SE O FORMULARIO FOI MANIPULADO PELO HTML
        if ($usuario === null) {

            $retorno['erro'] = 'Por favor verifique os erros abaixo!';
            $retorno['erros_model'] = ['link_invalido' => 'Link inválido ou expirado!'];
            return $this->response->setJSON($retorno);
        }

        # PREENCHER COM OS DADOS QUE ESTÃO VINDO DO POST
        $usuario->fill($post);

        $usuario->finalizaPasswordReset();


        if ($this->usuarioModel->save($usuario)) {

            session()->setFlashdata("sucesso", "Nova senha criada com sucesso!");

            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'Por favor verifique os erros abaixo';
        $retorno['erros_model'] = $this->usuarioModel->errors();
        return $this->response->setJSON($retorno);
    }

    /**
     * METODO QUE ENVIA O E-MAIL PARA REDEFINIR SENHA AO USUARIO
     */
    private function enviaEmailRedefinicaoSenha(object $usuario): void
    {
        $email = service('email');

        $email->setFrom('no-reply@ordem.com', 'Ordem de serviço LTDA');

        #$email->setTo('camiloteixeira038@gmail.com');

        $email->setTo($usuario->email);

        $email->setSubject('Redefinição de senha');

        // RENDERIZAR DA VIEW reset_email
        $data = [
            'token' => $usuario->reset_token
        ];

        $mensagem = view('Password/reset_email', $data);

        $email->setMessage($mensagem);

        /* if ($email->send()) {
            echo 'Email Enviado';
        } else {
            echo $email->printDebugger();
        } */

        $email->send();
    }
}
