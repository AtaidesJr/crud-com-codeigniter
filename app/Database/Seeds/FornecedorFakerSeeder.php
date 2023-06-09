<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FornecedorFakerSeeder extends Seeder
{
    public function run()
    {
        $fornecedorModel = new  \App\Models\FornecedorModel();

        # METÓDO PARA CRIAR FORNECEDORES FAKES
        $faker = \Faker\Factory::create('pt-BR');

        $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker)); # CRIA CNPJ E RAZÃO NO FORMATO DO BRASIL
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker)); # CRIAR NUMERO DE TELEFONE NO FORMATO DO BRASIL

        $criarQuantosFornecedores = 20;

        $fornecedorPush = [];

        # CONTADOR PARA CRIAR OS FORNECEDORES
        for ($i = 0; $i < $criarQuantosFornecedores; $i++) {

            array_push($fornecedorPush, [
                'razao' => $faker->unique()->company,
                'cnpj' => $faker->unique()->cnpj,
                'ie' => $faker->unique()->numberBetween(1000000, 9000000),
                'telefone' => $faker->unique()->cellphoneNumber,
                'cep' => $faker->postcode,
                'endereco' => $faker->streetName,
                'numero' => $faker->buildingNumber,
                'bairro' => $faker->city,
                'cidade' => $faker->city,
                'estado' => $faker->stateAbbr,
                'ativo' => $faker->numberBetween(1, 0),
                'criado_em' => $faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),
                'atualizado_em' => $faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),

            ]);
        }



        # PULA AS VALIDAÇÕES DEFINIDAS NO MODELS
        $fornecedorModel->skipValidation(true)->insertBatch($fornecedorPush);

        echo "$criarQuantosFornecedores, criados com sucesso";
    }
}
