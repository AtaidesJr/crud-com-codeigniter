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


    <!--VALIDAÇÃO PARA APRESENTAR MENSAGEM QUE NÃO PODE SER EXCLUÌDO-->
    <?php if ($grupo->id < 3) : ?>
        <div class="text-center col-md-12">

            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Importante!</h4>
                <p>O grupo <b><?php echo esc($grupo->nome); ?></b> não pode ser editado ou excluído </p>
                <hr>
                <p class="mb-0">Os demais grupos podem ser excluídos ou editados conforme sua necessidade! </p>
            </div>
        </div>
    <?php endif ?>


    <div class="col-lg-3">


        <div class="user-block block ">


            <h5 class="text-center card-title mt-2"><?php echo esc($grupo->nome); ?></h5>
            <div class="text-center">
                <p class="contributions mt-0"><?php echo ($grupo->exibir == true ?  'Exibir Grupo' : 'Não Exibir Grupo'); ?>


                    <?php if ($grupo->deletado_em == null) : ?>

                        <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-trigger="focus" title="Importante" data-content="Esse grupo <?php echo ($grupo->exibir == true ? 'será' : 'não sera') ?> exibido como opção na hora de definir um <b>Resposável Técnico</b> para ordem de serviço.">&nbsp;&nbsp;<i class="fa fa-question-circle fa-lg text-danger"></i></a>

                    <?php endif ?>

            </div>
            </p>
            <p class="text-center card-text"><?php echo esc($grupo->descricao); ?></p>
            <p class="text-center card-text">Criado <?php echo $grupo->criado_em->humanize(); ?></p>
            <p class="text-center card-text">Atualizado <?php echo $grupo->atualizado_em->humanize(); ?></p>


            <!-- INICIO VALIDAÇÃO PARA NÃO APRESENTAR BOTOÕES DE EDIÇÃO E EXCLUSÃO DOS GRUPOS ADM E CLIENTES -->
            <?php if ($grupo->id > 2) : ?>

                <div class="text-center dropdown">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="<?php echo site_url("grupos/editar/$grupo->id") ?>" class="dropdown-item"> Editar grupo</a>


                        <?php if ($grupo->id > 2) : ?>
                            <a href="<?php echo site_url("grupos/permissoes/$grupo->id") ?>" class="dropdown-item">Visualizar permissões</a>
                        <?php endif ?>


                        <a class="dropdown-item" href="<?php echo site_url("grupos/excluir/$grupo->id"); ?>">Excluir</a>
                    </div>

                <?php endif; ?>
                <!-- FIM DA VALIDAÇÃO PARA NÃO APRESENTAR BOTOÕES DE EDIÇÃO E EXCLUSÃO DOS GRUPOS ADM E CLIENTES -->

                <a href="<?php echo site_url("grupos/index"); ?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>

                </div>


        </div>

    </div>

</div>

<?php echo $this->endSection() ?>



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php echo $this->include('Layout/_mensagens'); ?>


<?php echo $this->endSection() ?>