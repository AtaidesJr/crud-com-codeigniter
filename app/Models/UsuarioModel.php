<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Libraries\Token;

class UsuarioModel extends Model
{

    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'senha_hash',  //CAMPOS QUE PODEM SER EDITADOS DO BANCO DE DADOS!
        'nome',
        'email',
        'senha',
        'reset_hash',
        'reset_expira_em',
        'imagem',
        //NÃO NECESSITA COLOCAR O CAMPO *ATIVO* , POIS EXISTE A MANIPULAÇÃO DE FORMULARIO!
        // OS CAMPOS **CRIADO_EM , ATUALIZADO_EM , DELETADO_EM** , IRÁ CONTER INFORMAÇÕES ATUALIZADAS DE FORMA AUTOMATICAS!
    ];

    // DATAS
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // VALIDAÇÃO
    protected $validationRules      = [
        'nome'         => 'required|min_length[3]|max_length[120]',
        'email'        => 'required|valid_email|is_unique[usuarios.email,id,{id}]|max_length[230]',
        'senha'     => 'required|min_length[6]',
        'confirmacao_senha' => 'required_with[senha]|matches[senha]',
    ];


    protected $validationMessages   = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio!',
            'min_length' => 'O campo nome precisa ter pelo menos 3 caracteres!',
            'max_length' => 'O campo não pode ser maior que 125 caracteres!',
        ],
        'email' => [
            'required' => 'O campo e-mail é obrigatorio!',
            'max_length' => 'O campo email não pode ser maior que 230 caracteres!',
            'is_unique' => 'Esse e-mail já foi cadastrado',
        ],
        'confirmacao_senha' => [
            'required_with' => 'Por favor confirme sua senha!',
            'matches' => 'As senhas não conferem , tente novamente.',

        ],
    ];

    // CALLBACKS
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];




    protected function hashPassword(array $data)
    {

        if (isset($data['data']['senha'])) {

            $data['data']['senha_hash'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);

            //REMOVENDO OS DADOS A SEREM SALVOS 
            unset($data['data']['senha']);
            unset($data['data']['confirmacao_senha']);
        }

        return $data;
    }




    # METODO QUE RECUPERAR O USUARIO PARA LOGAR NO SISTEMA
    public function buscaUsuarioPorEmail($email)
    {
        // BUSCAR O EMAIL DO USUARIO NO BD , ONDE O USUARIO NÃO ESTEJA EXCLUÍDO
        return $this->where('email', $email)->where('deletado_em', null)->first();
    }


    /**
     * METODO QUE RECUPERAR AS PERMISSÕES DO USUARIO LOGADO
     * 
     * @param integer $usuario_id
     * 
     * @return null|array
     * 
     */
    public function recuperaPermissaoUsuarioLogado(int $usuario_id)
    {

        // CONSULTA NO BANCO DE DADOS TRAZENDO INFORMAÇÃO DA TABELA *USUARIOS*
        $sql = [
            /*'usuarios.id',
            'usuarios.nome AS usuario',
            'grupos_usuarios.*', */
            'permissoes.nome AS permissao',
        ];

        return  $this->select($sql)
            ->asArray() // RECUPERAR NO FORMATO ARRAY
            ->join('grupos_usuarios', 'grupos_usuarios.usuario_id = usuarios.id')
            ->join('grupos_permissoes', 'grupos_permissoes.grupo_id = grupos_usuarios.grupo_id')
            ->join('permissoes', 'permissoes.id = grupos_permissoes.permissao_id ')
            ->where('usuarios.id',  $usuario_id)
            ->groupBy('permissoes.nome')
            ->findAll();
    }


    /**
     * METODO QUE RECUPERAR O USUARIO DE ACORDO COM O HASH DO TOKEN 
     * 
     * 
     */
    public function buscaUsuarioPorTokenHash(string $token)
    {

        # INSTANCIANDO O OBJETO DA CLASSE, PASSANDO COMO PARÂMETRO NO CONSTRUTOR O TOKEN
        $token = new Token($token);

        # CONSULTANDO O HASH  DO TOKEN 
        $tokenHash = $token->getHash();

        # CONSULTA SQL
        $usuario = $this->where('reset_hash',  $tokenHash)
            ->where('deletado_em', null)
            ->first();

        # VALIDAR SE O USUARIO FOI ENCONTRADO    
        if ($usuario === null) {

            return null;
        }

        # VALIDA SE O TOKEN NÃO EXPIROU 
        if ($usuario->reset_expira_em < date('Y-m-d H:i:s')) {

            return null;
        }

        # RETORNA O USARIO EXISTENTE E TOKEN VÁLIDO
        return $usuario;
    }
}
