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
    <div class="col-lg-6">
        <div class="info d-flex align-items-center">
            <div class="content">
                <div class="logo">
                    <h1><?php echo $titulo; ?></h1>
                </div>
                <p>Crie a sua nova senha.</p>
            </div>
        </div>
    </div>
    <!-- Form Panel    -->
    <div class="col-lg-6 bg-white">
        <div class="form d-flex align-items-center">
            <div class="content">

                <?php echo $this->include('Layout/_mensagens'); ?>

                <?php echo form_open('/', ['id' => 'form', 'class' => 'form-validate'], ['token' => $token]); ?>

                <div id="response">

                </div>


                <div class="form-group">
                    <input id="login-password" class="input-material" type="password" name="senha" required>
                    <label for="login-password" class="label-material">Nova Senha</label>
                </div>
                <div class="form-group">
                    <input id="login-password" class="input-material" type="password" name="confirmacao_senha" required>
                    <label for="login-password" class="label-material">Confirme a nova senha</label>
                </div>
                <input id="btn-reset" type="submit" class="btn btn-primary" value="Criar">

                <?php echo form_close() ?>


            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection() ?> <!-------- FINAL DO CONTEÚDO -------->



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS --------->

<!--- COLOCAR AQUI OS SCRIPTS DAS VIEW QUE ESTENDE DO LAYOUT/PRINCIPAL --->

<script>
    $(document).ready(function() {
        $("#form").on('submit', function(e) {

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '<?php echo site_url('password/processareset') ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#response").html(''); //LIMPAR OS DADOS DE REQUEST DA PÁGINA
                    $("#btn-reset").val('Por favor aguarde..'); //ALTERAR O TEXTO DO INPUT APÓS CLICAR 

                },

                success: function(response) { //FUNÇÃO SUCESSO 


                    $("#btn-reset").val('Criar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-reset").removeAttr("disabled");

                    $('[name=csrf_test_name]').val(response.token);

                    if (!response.erro) {

                        //REDIRECIONANDO PARA PAGINA DE LOGIN
                        window.location.href = "<?php echo site_url('login'); ?>"

                    }

                    if (response.erro) {

                        //ERROS DE VALIDAÇÃO NO FORMULARIO
                        $("#response").html('<div class="alert alert-danger">' + response.erro + '</div>');


                        if (response.erros_model) {

                            $.each(response.erros_model, function(key, value) {

                                $("#response").append(
                                    '<ul class="list-unstyled"><li class="text-danger">' + value + '</li></ul>');

                            });

                        }

                    }


                },

                error: function() {

                    swal({
                        title: "Erro ao processar a solicitação.",
                        text: "Dados incorretos, Verifique e tente novamente",
                        icon: "error",
                    });
                    $("#btn-reset").val('Criar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-reset").removeAttr("disabled");

                },

            });


        });


        //FUNÇÃO PARA DESABILITAR DUPLO CLICK , AGUARDO RETORNO DA AQUISIÇÃO
        $("#form").submit(function() {

            $(this).find(":submit").attr('disabled', 'disabled');

        });
    });
</script>


<?php echo $this->endSection() ?> <!--------- FINAL DO SCRIPTS --------->