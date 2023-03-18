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
                    <h1>Realize o seu login</h1>
                </div>
                <p>Portal para abertura & Consultas de ordens de serviços</p>
            </div>
        </div>
    </div>
    <!-- Form Panel    -->
    <div class="col-lg-6 bg-white">
        <div class="form d-flex align-items-center">
            <div class="content">

                <?php echo $this->include('Layout/_mensagens'); ?>

                <?php echo form_open('/', ['id' => 'form'], ['class' => 'form-validate']); ?>

                <div id="response">

                </div>


                <div class="form-group">
                    <input id="login-username" class="input-material" type="text" name="email" required>
                    <label for="login-username" class="label-material">E-mail</label>
                </div>
                <div class="form-group">
                    <input id="login-password" class="input-material" type="password" name="password" required>
                    <label for="login-password" class="label-material">Senha</label>
                </div>
                <input id="btn-login" type="submit" class="btn btn-primary" value="Continuar">

                <?php echo form_close() ?>
                <br>
                <a href="<?php echo site_url('esqueci') ?>" class="forgot-pass">Esqueçeu a sua senha?</a>

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
                url: '<?php echo site_url('login/criar') ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#response").html(''); //LIMPAR OS DADOS DE REQUEST DA PÁGINA
                    $("#btn-login").val('Por favor aguarde..'); //ALTERAR O TEXTO DO INPUT APÓS CLICAR 

                },

                success: function(response) { //FUNÇÃO SUCESSO 


                    $("#btn-login").val('Continuar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-login").removeAttr("disabled");

                    $('[name=csrf_test_name]').val(response.token);

                    if (!response.erro) {

                        //REDIRECIONANDO PARA PAGINA DE EXIBIR
                        window.location.href = "<?php echo site_url(); ?>" + response.redirect;

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
                    $("#btn-login").val('Continuar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-login").removeAttr("disabled");

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