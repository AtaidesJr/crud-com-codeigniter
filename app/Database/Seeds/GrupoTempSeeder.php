<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GrupoTempSeeder extends Seeder
{
    public function run()
    {
        $grupoModel = new  \App\Models\GrupoModel();

        $grupos = [
            [   //ID 01 - ADM
                'nome' => 'Administrador',
                'descricao' => 'Grupo com acesso total ao sistema',
                'exibir' => false,
            ],
            [   //ID 02 - CLIENTES
                'nome' => 'Clientes',
                'descricao' => 'Esse grupo é destinado atribuição de clientes, para acessar suas ordens de serviços',
                'exibir' => false,
            ],
            [   //ID 03 - ATENDENTES
                'nome' => 'Atendentes',
                'descricao' => 'Grupo com acesso , para realização de atendimentos',
                'exibir' => false,
            ],
        ];


        foreach ($grupos as $grupo) {
            $grupoModel->insert($grupo);
        }

        echo "Grupos criados com sucesso!";
    }
}
