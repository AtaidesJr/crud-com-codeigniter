<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->


<script>
    $(document).ready(function() {

        <?php if (session()->has('sucesso')) : ?>

            swal({
                title: "Tudo certo!",
                text: "<?php echo session('sucesso'); ?>",
                icon: "success",
            });

        <?php endif; ?>


    })
</script>


<script>
    $(document).ready(function() {

        <?php if (session()->has('info')) : ?>

            swal({
                title: "Informação!",
                text: "<?php echo session('info'); ?>",
                icon: "info",
            });

        <?php endif; ?>


    })
</script>


<script>
    $(document).ready(function() {

        <?php if (session()->has('atencao')) : ?>

            swal({
                title: "Atenção!",
                text: "<?php echo session('atencao'); ?>",
                icon: "warning",
            });

        <?php endif; ?>


    })
</script>


<!-- UTILIZAR QUANDO APARECER ERROS NO BACKEND , VIA FORMULARIOS -->
<script>
    $(document).ready(function() {

        <?php if (session()->has('error')) : ?>

            swal({
                title: "Dados incorretos",
                text: "<?php echo session('error'); ?>",
                icon: "error",
            });

        <?php endif; ?>


    })
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php echo $this->endSection() ?>



<!-- UTILIZAR SOMENTE QUANDO FOR FAZER UM POST SEM AJAX -->
<?php if (session()->has('erros_model')) : ?>

    <ul>

        <?php foreach ($erros_model as $erro) : ?>

            <li class="text-danger"><?php echo $erro ?></li>

        <?php endforeach ?>

    </ul>

<?php endif; ?>