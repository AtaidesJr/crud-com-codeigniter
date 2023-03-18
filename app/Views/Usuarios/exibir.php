<?php

use App\Controllers\Usuarios;
use App\Entities\Usuario;

echo $this->extend('Layout/principal'); ?>


<?php echo $this->section('titulo'); ?>
<?php echo $titulo ?>
<?php echo $this->endSection() ?>




<?php echo $this->section('styles'); ?> <!---------- INICIO STYLES -->



<?php echo $this->endSection() ?>



<?php echo $this->section('conteudo'); ?> <!-------- INICIO CONTEÚDO -->




<div class="row">

    <div class="col-lg-4">

        <div class="user-block block ">

            <div class="text-center">

                <?php if ($usuario->imagem == null) : ?>

                    <img src="<?php echo site_url('recursos/img/perfil0.png'); ?>" class="card-img-top;" style="width: 80%;" alt="Usuario sem imagem">

                <?php else : ?>

                    <img src="<?php echo site_url("usuarios/imagem/$usuario->imagem"); ?>" class="card-img-top;" style="width: 90%;" alt="<?php echo esc($usuario->nome); ?> ">


                <?php endif ?>


                <a href="<?php echo site_url("usuarios/editarImagem/$usuario->id"); ?>" class="btn btn-outline-primary btn-sm mt-3">Altera Imagem</a>

            </div>

            <hr class="border-secondary">

            <h5 class="card-title mt-2"><?php echo esc($usuario->nome); ?></h5>
            <p class="card-text"><?php echo esc($usuario->email); ?></p>
            <p class="contributions mt-0"><?php echo ($usuario->ativo == true ?  'Usuário ativo' : 'Usuário inativo'); ?></p>
            <p class="card-text">Criado há <?php echo $usuario->criado_em->humanize(); ?></p>
            <p class="card-text">Atualizado há <?php echo $usuario->atualizado_em->humanize(); ?></p>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="<?php echo site_url("usuarios/editar/$usuario->id") ?>" class="dropdown-item"> Editar usuário</a>
                    <a href="<?php echo site_url("usuarios/grupos/$usuario->id") ?>" class="dropdown-item"> Gerenciar Grupos de Acesso</a>

                    <a class="dropdown-item" href="<?php echo site_url("usuarios/excluir/$usuario->id"); ?>">Excluir</a>
                </div>

                <a href="<?php echo site_url("usuarios/index"); ?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>

            </div>

        </div>

    </div>

</div>

<?php echo $this->endSection() ?>



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php echo $this->include('Layout/_mensagens'); ?>


<?php echo $this->endSection() ?>