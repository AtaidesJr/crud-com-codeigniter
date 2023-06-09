<?php

use App\Controllers\Usuarios;
use App\Entities\Usuario;

echo $this->extend('Layout/principal'); ?>


<?php echo $this->section('titulo'); ?>
<?php echo $titulo ?>
<?php echo $this->endSection() ?>




<?php echo $this->section('styles'); ?> <!---------- INICIO STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo site_url('recursos/selectize/selectize.bootstrap4.css') ?>" />

<style>
    /* Estilizando o select para acompanhar a formatação do template */

    .selectize-input,
    .selectize-control.single .selectize-input.input-active {
        background: #2d3035 !important;
    }

    .selectize-dropdown,
    .selectize-input,
    .selectize-input input {
        color: #777;
    }

    .selectize-input {
        /*        height: calc(2.4rem + 2px);*/
        border: 1px solid #444951;
        border-radius: 0;
    }
</style>

<?php echo $this->endSection() ?>



<?php echo $this->section('conteudo'); ?> <!-------- INICIO CONTEÚDO -->




<div class="row">

    <div class="col-lg-6">

        <div class="user-block text-center block">

            <!-- VERIFICAR SE ARRAY ESTIVER VAZIO , O GRUPO JÁ TEM TODAS AS PERMISSÕES --->
            <?php if (empty($permissoesDisponiveis)) : ?>

                <p class="contributions text-warning mt-0">Esse grupo já possui todas as permissões disponiveis!</p>

            <?php else : ?>

                <!-- EXIBIRA OS RETORNO DE REQUEST , BACKEND -->
                <div id="response">


                </div>


                <?php echo form_open('/', ['id' => 'form'], ['id' => "$grupo->id"]) ?>


                <div class="form-group">
                    <label class="form-control-label">Escolha as permissões </label>

                    <select name="permissao_id[]" class="selectize" multiple>

                        <option value="">Selecione aqui...</option>

                        <?php foreach ($permissoesDisponiveis as $permissao) : ?>

                            <option value="<?php echo $permissao->id; ?>"><?php echo esc($permissao->nome); ?></option>

                        <?php endforeach ?>

                    </select>

                </div>


                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-danger btn-sm mr-2">
                    <a href="<?php echo site_url("grupos/exibir/$grupo->id"); ?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>


                </div>

                <?php echo form_close(); ?>

            <?php endif; ?>


        </div>


    </div>

    <div class="col-lg-6">


        <div class="user-block text-center block">

            <?php if (empty($grupo->permissoes)) : ?>

                <p class="contributions text-warning mt-0">Esse grupo ainda não possui permissões de acesso!</p>


            <?php else : ?>

                <div class="table-responsive">

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Permissão</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($grupo->permissoes as $permissao) :  ?>
                                <tr>
                                    <td><?php echo esc($permissao->nome); ?></td>
                                    <td>

                                        <?php $atributos = [
                                            'onSubmit' => "return confirm('Tem certeza da exclusão da permissão?');"
                                        ]; ?>

                                        <?php echo form_open("grupos/removePermissao/$permissao->principal_id", $atributos); ?>

                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>

                                        <?php echo form_close(); ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <div class="mt-3 ml-1">
                        <?php echo $grupo->pager->links(); ?>
                    </div>

                </div>

            <?php endif; ?>

        </div> <!--- FINAL DA DIV BLOCK --->


    </div>

</div>

</div>

<?php echo $this->endSection() ?>



<?php echo $this->section('scripts'); ?> <!--------- INICIO SCRIPTS -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('recursos/selectize/selectize.min.js') ?>"></script>
<?php echo $this->include('Layout/_mensagens'); ?>

<script>
    $(document).ready(function() {
        $('.selectize').selectize();
    });


    $("#form").on('submit', function(e) {

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '<?php echo site_url('grupos/salvarPermissoes') ?>',
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
                        window.location.href = "<?php echo site_url("grupos/permissoes/$grupo->id") ?>"
                    }

                }

                if (response.erro) {

                    //ERROS DE VALIDAÇÃO NO FORMULARIO
                    $("#response").html('<div class="alert alert-danger">' + response.erro + '</div>');


                    if (response.erros_model) {

                        $.each(response.erros_model, function(key, value) {

                            $("#response").append('<ul class="list-unstyled"><li class="text-danger">' + value + '</li></ul>');

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
</script>


<?php echo $this->endSection() ?>