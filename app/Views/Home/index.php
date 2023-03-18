<?php echo $this->extend('Layout/principal'); ?>


<?php echo $this->section('titulo'); ?>
<?php echo $titulo ?>
<?php echo $this->endSection() ?>




<?php echo $this->section('styles'); ?> <!---------- INICIO STYLES -->

<!--- COLOCAR AQUI OS ESTILOS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->

<?php echo $this->endSection() ?>



<?php echo $this->section('conteudo'); ?> <!-------- INICIO CONTEÚDO -->

<!-- COLOCAR AQUI OS CONTEUDOS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="mt-2 mb-4">
                <h2 class="text-white text-center">Bem vindo ! </h2>
            </div>
            <div class="row">

                <div class="col-md-4">
                    <div class="card card-dark bg-success">
                        <div class="card-body pb-0">
                            <div class="h1 float-right">
                                <i class="flaticon-download"></i>
                            </div>
                            <h2 class="mb-2" style="color: white;">Usuarios</h2>
                            <p class="<?php echo (url_is('usuarios*') ? 'active' : '') ?>"><a style="color: white;" href="<?php echo site_url('usuarios') ?>">
                                    Visualizar
                                </a></p>

                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-dark bg-info">
                        <div class="card-body pb-0">
                            <div class="h1 float-right">
                                <i class="flaticon-analytics"></i>
                            </div>
                            <h2 class="mb-2" style="color: white;">Grupos de Acesso</h2>
                            <p class="<?php echo (url_is('grupos*') ? 'active' : '') ?>"><a style="color: white;" href="<?php echo site_url('grupos') ?>">Visualizar</a></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


</div>


<?php echo $this->endSection() ?>



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->

<!--- COLOCAR AQUI OS SCRIPTS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->


<?php echo $this->endSection() ?>