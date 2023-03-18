<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Entities\Usuario;
use PhpParser\Node\Expr\List_;

use function PHPUnit\Framework\throwException;

class Usuarios extends BaseController
{


    private $usuarioModel;
    private $grupoUsuarioModel;
    private $grupoModel;


    public function __construct()
    {
        $this->usuarioModel = new \App\Models\UsuarioModel();
        $this->grupoUsuarioModel = new \App\Models\GrupoUsuarioModel();
        $this->grupoModel = new \App\Models\GrupoModel();
    }

    public function index()
    {

        $data = [
            'titulo' => 'Listando os usuarios do sistema'
        ];

        return view('Usuarios/index', $data);
    }

    public function recuperarUsuarios()
    {
        //VERIFICAR SE A REQUESIÇÃO ESTA SENDO PELA AJAX MESMO!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }



        $atributos = [
            'id',
            'nome',
            'email',
            'ativo',
            'imagem'
        ];

        $usuarios = $this->usuarioModel->select($atributos)

            ->orderBy('id', 'DESC')
            ->findAll();


        // RECEBERÁ O ARRAY  DE OBJETOS DE USUÁRIOS    
        $data = [];

        //ESSE CODIGO RETORNAR DADOS QUE ESTÃO NA TABELA USUARIOS DO BANCO DE DADOS
        foreach ($usuarios as $usuario) {

            // DEFINI O CAMINHO DA IMAGEM DO USUÁRIO
            if ($usuario->imagem != null) {

                // QUANDO TIVER IMAGEM DE USUARIO
                //ARRAY DE ATRIBUTOS
                $imagem = [
                    'src' => site_url("usuarios/imagem/$usuario->imagem"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => esc($usuario->nome),
                    'width' => '50',
                ];
            } else {

                // QUANDO NÃO TEM IMAGEM DE USUARIO
                $imagem = [
                    'src' => site_url("recursos/img/perfil0.png"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => 'Usuário sem imagem',
                    'width' => '50',
                ];
            }

            $data[] = [
                'imagem' =>  $usuario->imagem = img($imagem),
                'nome' =>  anchor("usuarios/exibir/$usuario->id", esc($usuario->nome), 'title="Exibir Usuário ' . esc($usuario->nome) . ' "'),
                'email' =>  esc($usuario->email),
                'ativo' => ($usuario->ativo == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-warning"></i>&nbsp;Inativo'),
            ];
        }

        $retorno = [
            'data' =>  $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function criar()
    {

        $usuario = new Usuario();

        $data  = [
            'titulo' => "Criando novo usuário ",
            'usuario' => $usuario,
        ];


        return view('Usuarios/criar', $data);
    }

    public function cadastrar()
    {

        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        //$retorno['erro'] = "logar()";

        $post = $this->request->getPost();


        //CRIO NOVO OBJETO DA ENTIDADE USUÁRIO
        $usuario = new Usuario($post);



        if ($this->usuarioModel->protect(false)->save($usuario)) {

            //$btnCriar = anchor("usuarios/criar", 'Criar outro usuário',  ['class' => 'btn btn-danger mt2']); //CRIAR BOTÃO PARA ADC NOVO USUARIOS 

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');

            //RETORNA O ULTIMO ID INSERIDO NA TABELA DE USUARIO , 
            $retorno['id'] = $this->usuarioModel->getInsertID();

            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'error()';
        $retorno['erro_model'] = $this->usuarioModel->errors();


        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    public function exibir(int $id = null)
    {

        $usuario = $this->buscarUsuarioOu404($id);

        $data  = [
            'titulo' => "Detalhando o usuário " . esc($usuario->nome),
            'usuario' => $usuario,
        ];


        return view('Usuarios/exibir', $data);
    }


    public function editar(int $id = null)
    {

        $usuario = $this->buscarUsuarioOu404($id);

        $data  = [
            'titulo' => "Editando o usuário " . esc($usuario->nome),
            'usuario' => $usuario,
        ];


        return view('Usuarios/editar', $data);
    }

    public function atualizar()
    {

        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        //$retorno['erro'] = "logar()";

        $post = $this->request->getPost();


        //VALIDANDO SE O USUARIO EXISTE!
        $usuario = $this->buscarUsuarioOu404($post['id']);


        // SE NÃO FOR INFORMADO A SENHA NO FORMULARIO DE EDITAR , REMOVEMOS DO  * $post * , ASSIM  PERMANECERÁ A ANTERIOR
        // SE NÃO FIZERMOS DESSA FORMA ,* a função hashpassword , que está em UsuarioModel* FARÁ A ATUALIZAÇÃO PARA BD , DE UMA STRING VAZIA
        if (empty($post['senha'])) {

            //ESSE É UM BYPASS PARA VERIFICAR SE ESTÁ VAZIO , SE ESTIVER NÃO ATUALIZA
            unset($post['senha']);
            unset($post['confirmacao_senha']);
        }


        //PREENCHER E ATUALIZAR COLUNAS DO USUARIOS QUE ESTÁ NO BD COM OS VALORES DOS POST
        $usuario->fill($post);

        if ($usuario->hasChanged() == false) {


            $retorno['info'] = 'info()';
            return $this->response->setJSON($retorno);
        }

        if ($this->usuarioModel->protect(false)->save($usuario)) {

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');
            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'error()';
        $retorno['erro_model'] = $this->usuarioModel->errors();

        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    public function editarImagem(int $id = null)
    {

        $usuario = $this->buscarUsuarioOu404($id);

        $data  = [
            'titulo' => "Alterando a imagem do usuário" . esc($usuario->nome),
            'usuario' => $usuario,
        ];


        return view('Usuarios/editar_imagem', $data);
    }

    public function upload()
    {

        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        $validacao =  service('validation');


        $regras = [
            'imagem' => 'uploaded[imagem]|max_size[imagem,1024]|ext_in[imagem,png,jpg,jpeg,webp]',

        ];

        $mensagens = [   // MENSAGENS DE ERROS
            'imagem' => [
                'uploaded' => 'Por favor escolha uma imagem',
                'max_size' => 'Tamanho da imagem ultrapassou o permitido',
                'ext_in' => 'Extensão de imagem  inválida!',
            ],

        ];

        $validacao->setRules(
            $regras,
            $mensagens

        );

        if ($validacao->withRequest($this->request)->run() == false) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'Por favor verifique os erros abaixo';
            $retorno['erros_model'] = $validacao->getErrors();

            //RETORNO PARA O AJAX REQUEST
            return $this->response->setJSON($retorno);
        }

        //$retorno['erro'] = "logar()";

        //RECUPERANDO DADOS DO POST DE REQUESIÇÃO
        $post = $this->request->getPost();


        //VALIDANDO SE O USUARIO EXISTE!
        $usuario = $this->buscarUsuarioOu404($post['id']);

        //RECUPERANDO A IMAGEM QUE VEM DO POST
        $imagem = $this->request->getFile('imagem');

        list($largura, $altura) = getimagesize($imagem->getPathName());

        if ($largura < "300" || $altura < "300") {

            $retorno['erro'] = 'Por favor verifique os erros abaixo';
            $retorno['erros_model'] = ['dimensao' => 'A imagem não pode ser menor que 300x300'];

            return $this->response->setJSON($retorno);
        }

        // SETAR O CAMINHO ONDE DEVER SER ARMAZENADO AS IMAGENS DOS USUÁRIOS
        $caminhoImagem = $imagem->store('usuarios');

        // C:\xampp\htdocs\ordem_servico\writable\uploads/usuarios/imagem.jpg
        $caminhoImagem = WRITEPATH . "uploads/$caminhoImagem";

        //INSTANCIANDO E CHAMANDO A CLASS OBJECT MANIPULAIMAGEM
        $this->manipulaImagem($caminhoImagem, $usuario->id);

        //APARTIR DAQUI ATUALIZAR A TABELA DE USUÁRIOS COM A IMAGEM ADC!  

        //RECUPERA A POSSÍVEL IMAGEM ANTIGA         
        $imagemAntiga = $usuario->imagem;

        $usuario->imagem = $imagem->getName();

        $this->usuarioModel->save($usuario);

        //REMOVE A IMAGEM ANTIGA , DEPOIS QUE INSERI UMA NOVA 
        if ($imagemAntiga != null) {

            $this->removeImagemDoFileSystem($imagemAntiga);
        }

        session()->setFlashdata('sucesso', 'Imagem atualizada com sucesso!');

        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    //VERIFICAR SE HÁ IMG ADICIONADO AO USUARIO NA VIEW    * exibir.php *
    public function imagem(string $imagem = null)
    {

        // BUSCA OS PARAMENTROS DEFINIDOS EM    * BaseController  * 
        if ($imagem != null) {
            $this->exibeArquivo('usuarios', $imagem);
        }
    }


    public function excluir(int $id = null)
    {

        $usuario = $this->buscarUsuarioOu404($id);

        if ($usuario->deletado_em != null) {
            return redirect()->back()->with('info', "Esse usuário já foi excluído!");
        }

        if ($this->request->getMethod() === 'post') {

            // EXCLUIR O USUÁRIO
            $this->usuarioModel->delete($usuario->id);

            //  DELETA A IMAGEM DO USUARIO NO FILE SYSTEM
            if ($usuario->imagem != null) {
                $this->removeImagemDoFileSystem($usuario->imagem);
            }

            $usuario->imagem = null;
            $usuario->ativo = false;

            $this->usuarioModel->protect(false)->save($usuario);

            return redirect()->to(site_url("usuarios"))->with('sucesso', "Usuário $usuario->nome excluído com sucesso!");
        }

        $data  = [
            'titulo' => "Excluindo o usuário " . esc($usuario->nome),
            'usuario' => $usuario,
        ];


        return view('Usuarios/excluir', $data);
    }


    public function grupos(int $id = null)
    {

        $usuario = $this->buscarUsuarioOu404($id);

        $usuario->grupos = $this->grupoUsuarioModel->recuperaGruposDoUsuario($usuario->id, 5);
        $usuario->pager = $this->grupoUsuarioModel->pager;



        $data  = [
            'titulo' => "Gerenciando os grupos de acesso do usuário " . esc($usuario->nome),
            'usuario' => $usuario,
        ];


        // QUANDO O USUARIO FOR UM CLIENTE , RETORNAR A VIEW DE  EXIBIÇÃO DO USUARIO INFORMANDO QUE NÃO E POSSIVEL ADC A OUTROS GRUPOS
        $grupoCliente = 2;
        if (in_array($grupoCliente, array_column($usuario->grupos, 'grupo_id'))) {
            return redirect()->to(site_url("usuarios/exibir/$usuario->id"))
                ->with('info', "Esse usuário é um cliente , portanto , não e necessário atruibuí-lo a outros grupos de acesso!");
        }

        //VERIFICAR SE O USUARIO ESTÁ NO GRUPO ADMIN SE JÁ ESTIVER NÃO MOSTRA AS OPÇÕES DE GRUPOS DISPONIVEIS 
        $grupoAdmin = 1;
        if (in_array($grupoAdmin, array_column($usuario->grupos, 'grupo_id'))) {
            $usuario->full_control = true;
            return view('Usuarios/grupos', $data);
        }

        $usuario->full_control = false;



        if (!empty($usuario->grupos)) {

            // RECUPERANDO OS GRUPOS QUE O USUÁRIO AINDA NÃO FAZ PARTE
            $grupoExistentes = array_column($usuario->grupos, 'grupo_id');

            $data['gruposDisponiveis'] = $this->grupoModel
                ->where('id !=', 2) // NÃO RECUPERAR O GRUPO DE CLIENTES
                ->whereNotIn('id', $grupoExistentes)
                ->findAll();
        } else {

            // RECUPERA TODOS OS GRUPOS , COM EXCEÇÃO DO GRUPO DE CLIENTES QUE É ASSOCIADO AUTOMATICO NA CRIAÇÃO DE UM CLIENTE

            $data['gruposDisponiveis'] = $this->grupoModel
                ->where('id !=', 2) // NÃO RECUPERAR O GRUPO DE CLIENTES
                ->findAll();
        }


        return view('Usuarios/grupos', $data);
    }

    public function salvarGrupos()
    {

        // ENVIO O HASH DO TOKEN DO FORM
        $retorno['token'] = csrf_hash();

        //$retorno['erro'] = "logar()";

        $post = $this->request->getPost();


        //VALIDANDO SE O USUARIO EXISTE!
        $usuario = $this->buscarUsuarioOu404($post['id']);

        // VALIDANDO SE O USUARIO CLICOU NO BOTÃO , SEM ADC ALGUM GRUPO
        if (empty($post['grupo_id'])) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'Escolha um ou mais grupos antes de salvar';
            $retorno['erro_model'] = ['grupo_id' => 'Escolha um ou mais grupos antes de salvar'];

            //RETORNO PARA O AJAX REQUEST
            return $this->response->setJSON($retorno);
        }


        //  VALIDA PARA O USUARIO NÃO MANIPULAR FORMULARIO PELA URL
        if (in_array(2, $post['grupo_id'])) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'O grupo de clientes não pode ser atruibuído de forma manual';
            $retorno['erro_model'] = ['grupo_id' => 'O grupo de clientes não pode ser atruibuído de forma manual'];

            //RETORNO PARA O AJAX REQUEST
            return $this->response->setJSON($retorno);
        }

        // VERIFICA SE NO POST ESTÁ RETORNANDO O GRUPO ADMIN (ID -> 1)
        if (in_array(1, $post['grupo_id'])) {

            $grupoAdmin = [
                'grupo_id' => 1,
                'usuario_id' => $usuario->id
            ];

            // AQUI INSERER O USUARIO NO GRUPO DE ADMIN E REMOVE OS GRUPOS QUE FOREM DIFERENTE DO ADMIN 
            $this->grupoUsuarioModel->insert($grupoAdmin);
            $this->grupoUsuarioModel->where('grupo_id !=', 1)
                ->where('usuario_id', $usuario->id)
                ->delete();

            session()->setFlashdata('sucesso', ' Ao selecionar o grupo Administrador , não e necessario associar os demais grupos ao usuario '  . $usuario->nome);
            return $this->response->setJSON($retorno);
        }



        // RECEBERA AS PERMISSÕES DO POST PARA ADICIONAR AS PERMISSÕES NO BANCO
        $grupoPush = [];

        foreach ($post['grupo_id'] as $grupo) {

            //ATRIBUTOS SALVOS DA TABELA GRUPOS_PERMISSÕES MODEL
            array_push($grupoPush, [
                'grupo_id' => $grupo,
                'usuario_id' => $usuario->id
            ]);
        }



        // INSERT INTO NA USUARIOS_GRUPOS
        $this->grupoUsuarioModel->insertBatch($grupoPush);

        session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');
        return $this->response->setJSON($retorno);
    }

    public function removeGrupo(int $principal_id = null)
    {

        if ($this->request->getMethod() === 'post') {

            $grupoUsuario = $this->buscarGrupoUsuarioOu404($principal_id);


            if ($grupoUsuario->grupo_id == 2) {

                return redirect()->to(site_url("usuarios/exibir/$grupoUsuario->usuario_id"))
                    ->with("info", "Não é permitida a exclusão do usuario no grupo de Clientes");
            }

            $this->grupoUsuarioModel->delete($principal_id);
            return redirect()->back()->with("sucesso", "Usuario removido do grupo de acesso com sucesso!");
        }

        return redirect()->back();
    }


    public function editarSenha()
    {
        //  ACL não vai adicionado aqui

        $data = [
            'titulo' => 'Edite a sua senha de acesso',
        ];

        return view('Usuarios/editar_senha', $data);
    }



    public function atualizarSenha()
    {

        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        /*  
        [current_password] => 123456
        [password] => 123456
        [password_confirmation] => 123456
        */

        $current_password = $this->request->getPost('current_password');

        //RECUPERAR O USUARIO LOGADO
        $usuario = usuario_logado();


        // VALIDANDO SE A SENHA DIGITADA A MESMA DA ATUAL QUE FOI INSERIDA PARA REALIZAR O LOGIN
        if ($usuario->verificaPassword($current_password) === false) {

            $retorno['erro'] = 'Por favor verifique os erros abaixo!';
            $retorno['erros_model'] = ['current_password' => 'Senha atual inválida'];
            return $this->response->setJSON($retorno);
        }


        $usuario->fill($this->request->getPost());

        if ($usuario->hasChanged() === false) {

            // $retorno['erro'] = "logar()";

            $retorno['info'] = "Não há dados para atualizar";
            return $this->response->setJSON($retorno);
        }


        if ($this->usuarioModel->save($usuario)) {

            $retorno['sucesso'] = "Senha atualizada com sucesso";
            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'Por favor verifique os erros abaixo!';
        $retorno['erros_model'] = $this->usuarioModel->errors();

        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    //METODO QUE RECUPERAR OS USUARIOS
    private function buscarUsuarioOu404(int $id = null)
    {
        if (!$id || !$usuario = $this->usuarioModel->withDeleted(false)->find($id)) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuario $id");
        }

        return $usuario;
    }


    //METODO QUE RECUPERAR OS REGISTROS DO GRUPO ASSOCIADO AO USUARIO
    private function buscarGrupoUsuarioOu404(int $principal_id = null)
    {
        if (!$principal_id || !$grupoUsuario = $this->grupoUsuarioModel->find($principal_id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o registro de associação ao grupo de acesso $principal_id");
        }

        return $grupoUsuario;
    }


    private function manipulaImagem(string  $caminhoImagem, int $usuario_id)
    {
        // REDIMENSIONA A IMAGEM QUE ESTÁ SALVA NO DIRETÓRIO 300x300
        service('image')
            ->withFile($caminhoImagem)
            ->fit(400, 400, 'center')
            ->save($caminhoImagem);


        $anoAtual = date('Y');

        //ADICIONANDO MARCA D'ÁGUA DE TEXTO NA IMAGEM
        \Config\Services::image('imagick')
            ->withFile($caminhoImagem)
            ->text("Ordem $anoAtual - User-ID $usuario_id", [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => false,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 10,
            ])
            ->save($caminhoImagem);
    }

    private function removeImagemDoFileSystem(string $imagem)
    {
        $caminhoImagem = WRITEPATH . "uploads/usuarios/$imagem";

        if (is_file($caminhoImagem)) {
            unlink($caminhoImagem);
        }
    }
}
