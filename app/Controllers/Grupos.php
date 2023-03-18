<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Grupo;
use PhpParser\Node\Stmt\Else_;

class Grupos extends BaseController
{

    private  $grupoModel;
    private  $grupoPermissaoModel;
    private  $permissaoModel;


    public function __construct()
    {
        $this->grupoModel = new \App\Models\GrupoModel();
        $this->grupoPermissaoModel = new \App\Models\GrupoPermissaoModel();
        $this->permissaoModel = new \App\Models\PermissaoModel();
    }

    public function index()
    {

        $data = [
            'titulo' => 'Listando os grupos de acesso do sistema'
        ];

        return view('Grupos/index', $data);
    }

    public function recuperarGrupos()
    {
        //VERIFICAR SE A REQUESIÇÃO ESTA SENDO PELA AJAX MESMO!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }



        $atributos = [
            'id',
            'nome',
            'exibir',
            'descricao',
            'deletado_em'

        ];

        $grupos = $this->grupoModel->select($atributos)

            ->orderBy('id', 'DESC')
            ->findAll();


        // RECEBERÁ O ARRAY  DE OBJETOS DE USUÁRIOS    
        $data = [];

        //ESSE CODIGO RETORNAR DADOS QUE ESTÃO NA TABELA USUARIOS DO BANCO DE DADOS
        foreach ($grupos as $grupo) {


            $data[] = [
                'nome' =>  anchor("grupos/exibir/$grupo->id", esc($grupo->nome), 'title="Exibir grupo' . esc($grupo->nome) . ' "'),
                'descricao' =>  esc($grupo->descricao),
                'exibir' => ($grupo->exibir == true ? '<i class="fa fa-eye text-secondary"></i>&nbsp;Exibir' : '<i class="fa fa-eye-slash text-danger"></i>&nbsp;Não Exibir')
                //'exibe' => ($grupo->ativo == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo' : '<i class="fa fa-lock text-warning"></i>&nbsp;Inativo'),
            ];
        }

        $retorno = [
            'data' =>  $data
        ];

        return $this->response->setJSON($retorno);
    }


    public function criar()
    {

        $grupo = new Grupo();


        $data  = [
            'titulo' => "Criando novo grupo ",
            'grupo' => $grupo,
        ];


        return view('Grupos/criar', $data);
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


        //CRIO NOVO OBJETO DA ENTIDADE Grupo
        $grupo = new Grupo($post);



        if ($this->grupoModel->save($grupo)) {

            //$btnCriar = anchor("usuarios/criar", 'Criar novo grupo de acesso',  ['class' => 'btn btn-danger mt2']); //CRIAR BOTÃO PARA ADC NOVO USUARIOS 

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');

            //RETORNA O ULTIMO ID INSERIDO NA TABELA DE USUARIO , 
            $retorno['id'] = $this->grupoModel->getInsertID();

            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'Favor Verificar erros abaixo';
        $retorno['erro_model'] = $this->grupoModel->errors();


        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    public function exibir(int $id = null)
    {

        $grupo = $this->buscarGrupoOu404($id);

        $data  = [
            'titulo' => "Detalhando o grupo " . esc($grupo->nome),
            'grupo' => $grupo,
        ];


        return view('Grupos/exibir', $data);
    }

    public function editar(int $id = null)
    {

        $grupo = $this->buscarGrupoOu404($id);

        if ($grupo->id < 3) {
            return redirect()
                ->back()
                ->with('atencao', "O grupo" . esc($grupo->nome) . "não pode ser editado ou excluído!");
        }

        $data  = [
            'titulo' => "Editando o grupo " . esc($grupo->nome),
            'grupo' => $grupo,
        ];


        return view('Grupos/editar', $data);
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
        $grupo = $this->buscarGrupoOu404($post['id']);


        // VALIDAÇÃO PARA NÃO EDITAR GRUPOS ADM E CLIENTES
        if ($grupo->id < 3) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'O grupo ' . esc($grupo->nome) . ' Não pode ser editado ou excluído!';
            $retorno['erro_model'] = ['grupo' => 'O grupo ' . esc($grupo->nome) . ' Não pode ser editado ou excluído!'];
            return $this->response->setJSON($retorno);
        }


        //PREENCHER E ATUALIZAR COLUNAS DO GRUPOS QUE ESTÁ NO BD COM OS VALORES DOS POST
        $grupo->fill($post);

        if ($grupo->hasChanged() == false) {


            $retorno['info'] = 'info()';
            return $this->response->setJSON($retorno);
        }

        if ($this->grupoModel->protect(false)->save($grupo)) {

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');
            return $this->response->setJSON($retorno);
        }

        //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
        $retorno['erro'] = 'error()';
        $retorno['erro_model'] = $this->grupoModel->errors();

        //RETORNO PARA O AJAX REQUEST
        return $this->response->setJSON($retorno);
    }

    public function excluir(int $id = null)
    {

        $grupo = $this->buscarGrupoOu404($id);


        if ($grupo->id < 3) {
            return redirect()
                ->back()
                ->with('atencao', "O grupo " . esc($grupo->nome) . " não pode ser editado ou excluído!");
        }

        if ($grupo->deletado_em != null) {
            return redirect()->back()->with('info', "Esse grupo já foi excluído!");
        }

        if ($this->request->getMethod() === 'post') {

            // EXCLUIR GRUPO
            $this->grupoModel->delete($grupo->id);

            return redirect()->to(site_url("grupos"))->with('sucesso', "Grupo " . esc($grupo->nome) . " excluído com sucesso!");
        }

        $data  = [
            'titulo' => "Excluindo o grupo" . esc($grupo->nome),
            'grupo' => $grupo,
        ];


        return view('Grupos/excluir', $data);
    }


    public function permissoes(int $id = null)
    {

        $grupo = $this->buscarGrupoOu404($id);

        if ($grupo->id == 1) {

            return redirect()
                ->back()
                ->with('info', "Não é necessário atribuir ou remover permissões de acesso para o grupo " . esc($grupo->nome) . " pois esse grupo e o ADMINISTRADO!");
        }

        // GRUPO DE CLIENTES
        if ($grupo->id == 2) {

            return redirect()
                ->back()
                ->with('info', "Não é necessário atribuir ou remover permissões de acesso para o grupo de " . esc($grupo->nome));
        }

        // RECUPERANDO PERMISSÕES INSERIDAS NO BANCO DE DADOS
        if ($grupo->id > 2) {

            $grupo->permissoes = $this->grupoPermissaoModel->recuperaPermissoesdoGrupo($grupo->id, 5);
            $grupo->pager = $this->grupoPermissaoModel->pager;
        }


        $data  = [
            'titulo' => "Gerenciado as permissões do grupo " . esc($grupo->nome),
            'grupo' => $grupo,
        ];

        if (!empty($grupo->permissoes)) {

            // CRIA ARRAY COM AS PERMISSOES JÀ ATRIBUIDAS AOS GRUPOS
            $permissoesExistentes = array_column($grupo->permissoes, 'permissao_id');

            // VERIFICAR AS PERMISSOES DISPONIVEIS PARA ADICIONAR AO GRUPO EXCETO AS QUE JÀ FORAM ATRUIBUIDAS
            $data['permissoesDisponiveis'] = $this->permissaoModel->whereNotIn('id', $permissoesExistentes)->findAll();
        } else {

            // MOSTRA TODAS AS PERMISSOES QUANDO O GRUPO NÃO TEM NENHUMA PERMISSAO ATRUIBUIDA1
            $data['permissoesDisponiveis'] = $this->permissaoModel->findAll();
        }

        return view('Grupos/permissoes', $data);
    }


    public function salvarPermissoes()
    {
        //CONTROLLER SÓ PODE SER ACESSADO POR AJAX!
        if (!$this->request->isAJAX()) {
            return  redirect()->back();
        }

        $retorno['token'] = csrf_hash();

        //$retorno['erro'] = "logar()";

        $post = $this->request->getPost();


        //VALIDANDO SE O USUARIO EXISTE!
        $grupo = $this->buscarGrupoOu404($post['id']);

        if (empty($post['permissao_id'])) {

            //RETORNAMOS OS ERROS DE VALIDAÇÃO !!
            $retorno['erro'] = 'Escolha uma ou mais permissão antes de salvar';
            $retorno['erro_model'] = ['permissao_id' => 'Escolha uma ou mais permissão antes de salvar'];

            //RETORNO PARA O AJAX REQUEST
            return $this->response->setJSON($retorno);
        }

        // RECEBERA AS PERMISSÕES DO POST PARA ADICIONAR AS PERMISSÕES NO BANCO
        $permissaoPush = [];

        foreach ($post['permissao_id'] as $permissoes) {

            //ATRIBUTOS SALVOS DA TABELA GRUPOS_PERMISSÕES MODEL
            array_push($permissaoPush, [
                'grupo_id' => $grupo->id,
                'permissao_id' => $permissoes
            ]);
        }

        $this->grupoPermissaoModel->insertBatch($permissaoPush);

        session()->setFlashdata('sucesso', 'Dados salvos com sucesso!');
        return $this->response->setJSON($retorno);
    }

    public function removePermissao(int $principal_id = null)
    {


        if ($this->request->getMethod() === 'post') {

            // EXCLUIR AS PERMISSÕES ($principal_id)
            $this->grupoPermissaoModel->delete($principal_id);

            return redirect()->back()->with('sucesso', "Permissão excluída com sucesso!");
        }

        // VALIDA E RETORNA PARA PAGINA INICIAL QUANDO A REQUISÃO NÃO E POST
        return redirect()->back();
    }

    //METODO QUE RECUPERAR OS USUARIOS
    private function buscarGrupoOu404(int $id = null)
    {
        if (!$id || !$grupo = $this->grupoModel->withDeleted(false)->find($id)) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o grupo de acesso $id");
        }

        return $grupo;
    }
}
