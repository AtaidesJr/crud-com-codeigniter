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

                <?php echo $this->include('Layout/_mensagens'); ?>

                <!-- EXIBIRA OS RETORNO DE REQUEST , BACKEND -->
                <div id="response">


                </div>


                <?php echo form_open('/', ['id' => 'form']) ?>

                <div class="form-group">
                    <label class="form-control-label">Digite a senha antiga</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-control-label">Digite uma nova senha</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-control-label">Confirme a nova senha</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-danger btn-sm mr-2">


                </div>

                <?php echo form_close(); ?>


            </div>

        </div>

    </div>

</div>

</div>

<?php echo $this->endSection() ?>


<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->



<script>
    $(document).ready(function() {
        $("#form").on('submit', function(e) {

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '<?php echo site_url('usuarios/atualizarSenha') ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#response").html(''); //LIMPAR OS DADOS DE REQUEST DA PÁGINA
                    $("#btn-salvar").val('Por favor aguarde..'); //ALTERAR O TEXTO DO INPUT APÓS CLICAR 

                },

                success: function(response) { //FUNÇÃO SUCESSO 


                    $("#btn-salvar").val('Salvar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-salvar").removeAttr("disabled");

                    $('[name=csrf_test_name]').val(response.token);

                    if (!response.erro) {

                        // LIMPA O FORMULARIO DEPOIS QUE FOI SALVO , SEM ERROS 
                        $("#form")[0].reset();

                        if (response.info) {


                            $("#response").html(function info() {
                                swal({
                                    title: "Informação",
                                    text: "Não há , dados para atualizar!",
                                    icon: "info",
                                });
                            });

                        } else {

                            //REDIRECIONANDO PARA PAGINA DE EXIBIR
                            $("#response").html('<div class="alert alert-sucesso">' + response.sucesso + '</div>');
                        }

                    }

                    if (response.erro) {

                        //ERROS DE VALIDAÇÃO NO FORMULARIO
                        $("#response").html('<div class="alert alert-danger">' + response.erro + '</div>');


                        if (response.erros_model) {

                            $.each(response.erros_model, function(key, value) {

                                $("#response").append(
                                    '<ul class="list-unstyled"><li class="text-danger">' +
                                    value + '</li></ul>');

                            });

                        }

                    }


                },

                error: function() {

                    swal({
                        title: "Erro ao processar a solicitação.",
                        text: "Por gentileza entrar em contato com TI.",
                        icon: "error",
                    });
                    $("#btn-salvar").val('Salvar'); //RETORNA O TEXTO ORIGINAL DO INPUT APÓS ENVIO 
                    $("#btn-salvar").removeAttr("disabled");

                },

            });


        });


        //FUNÇÃO PARA DESABILITAR DUPLO CLICK , AGUARDO RETORNO DA AQUISIÇÃO
        $("#form").submit(function() {

            $(this).find(":submit").attr('disabled', 'disabled');

        });
    });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php echo $this->endSection() ?>