<?php echo $this->extend('Layout/Autenticacao/principal_autenticacao'); ?>


<?php echo $this->section('titulo'); ?>
<?php echo $titulo ?>
<?php echo $this->endSection() ?>




<?php echo $this->section('styles'); ?> <!---------- INICIO STYLES -->

<!--- COLOCAR AQUI OS ESTILOS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->

<?php echo $this->endSection() ?>



<?php echo $this->section('conteudo'); ?> <!-------- INICIO CONTEÚDO -->

<div class="row">
    <!-- Logo & Information Panel-->
    <div class="col-lg-8 mx-auto">
        <div class="info d-flex align-items-center">
            <div class="content">
                <div class="logo">
                    <h1><?php echo $titulo; ?></h1>
                </div>
                <p>Por favor , conferir também a caixa de spam do seu e-mail.</p>
            </div>
        </div>
    </div>
    <!-- Form Panel    -->
    <div class="col-lg-6 bg-white d-none">
        <div class="form d-flex align-items-center">
            <div class="content">

                <?php echo $this->include('Layout/_mensagens'); ?>


            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection() ?> <!-------- FINAL DO CONTEÚDO -------->



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS --------->

<!--- COLOCAR AQUI OS SCRIPTS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->

<?php echo $this->endSection() ?> <!--------- FINAL DO SCRIPTS --------->