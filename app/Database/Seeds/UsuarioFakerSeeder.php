<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioFakerSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new  \App\Models\UsuarioModel();

        //METÓDO PARA CRIAR USUARIOS FAKES
        $faker = \Faker\Factory::create();

        $criarQuantosUsuarios =  30;

        $usuarioPush = [];

        //CONTADOR PARA CRIAR OS USUARIOS 
        for ($i = 0; $i < $criarQuantosUsuarios; $i++) {

            array_push($usuarioPush, [
                'nome' => $faker->unique()->name,
                'email' => $faker->unique()->email,
                'senha_hash' => '123456', //ALTERAR O FAKE SEEDER QUANDO CONHECERMOS COMO CRIPTOGRAFAR A SENHA  - HASH
                'ativo' => $faker->numberBetween(0, 1)

            ]);
        }

        //echo '<pre>';
        //print_r($usuarioPush);
        //exit;

        $usuarioModel->skipValidation(true) //BYPASS PARA PULAR VALIDAÇÃO
            ->protect(false)   //BYPASS PARA DESATIVAR PROTEÇÃO DOS CAMPOS $allowedFields EM MODELS
            ->insertBatch($usuarioPush);

        echo "$criarQuantosUsuarios usuarios criados com sucesso!";
    }
}
