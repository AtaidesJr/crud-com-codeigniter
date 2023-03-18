<?php echo $this->extend('Layout/principal'); ?>


<?php echo $this->section('titulo'); ?>
<?php echo $titulo ?>
<?php echo $this->endSection() ?>




<?php echo $this->section('styles'); ?> <!---------- INICIO STYLES -->



<?php echo $this->endSection() ?>



<?php echo $this->section('conteudo'); ?> <!-------- INICIO CONTEÚDO -->

<div class="row">

    <div class="col-lg-6">

        <div class="block">




            <div class="block-body">




                <?php echo form_open("usuarios/excluir/$usuario->id") ?>

                <!-- ALERTA DE MENSAGEM PARA EXCLUSÃO DE USUARIO -->
                <div class="alert alert-danger" role="alert">
                    <?php echo "Excluir usuário ? <br>" . $usuario->nome  ?>
                </div>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="Sim, Excluir" class="btn btn-primary btn-sm mr-2">

                    <?php if ($usuario->deletado_em == null) : ?>
                        <a href="<?php echo site_url("usuarios/exibir/$usuario->id"); ?>" class="btn btn-secondary btn-sm ml-2">Cancelar</a>
                    <?php endif; ?>

                </div>

                <?php echo form_close(); ?>


            </div>

        </div>

    </div>

</div>

</div>

<?php echo $this->endSection() ?>



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php echo $this->endSection() ?>