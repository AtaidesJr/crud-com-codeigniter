<div class="form-group">
    <label class="form-control-label">Nome do Grupo</label>
    <input type="text" required name="nome" placeholder="Insira o nome do grupo" class="form-control" value="<?php echo esc($grupo->nome); ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Descrição</label>
    <textarea name="descricao" placeholder="Insira a descrição do grupo" class="form-control" required><?php echo esc($grupo->descricao); ?></textarea>
</div>


<div class=" custom-control custom-checkbox">

    <input type="hidden" name="exibir" value="0">

    <input type="checkbox" name="exibir" value="1" class="custom-control-input" id="exibir" <?php if ($grupo->exibir ==  true) : ?> checked <?php endif; ?>>

    <label class="custom-control-label" for="exibir">Exibir grupo de acesso</label>

    <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-trigger="focus" title="Importante" data-content="Se esse grupo for definido como 
    <b>Exibir grupo de acesso</b>
    ele será mostrado como opção na hora de definir 
    <b>Resposável Técnico</b> para ordem de serviço.">
        &nbsp;&nbsp;<i class="fa fa-question-circle fa-lg text-danger"></i>
    </a>

</div>