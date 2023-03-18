<div class="form-group">
    <label class="form-control-label">Nome Completo</label>
    <input type="text" name="nome" required placeholder="Insira seu nome" class="form-control" value="<?php echo esc($usuario->nome); ?>">
</div>

<div class="form-group">
    <label class="form-control-label">E-mail</label>
    <input type="email" name="email" required placeholder="Insira seu e-mail" class="form-control" value="<?php echo esc($usuario->email); ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Senha</label>
    <input type="password" required name="senha" required placeholder="Senha" class="form-control">
</div>

<div class="form-group">
    <label class="form-control-label">Confirmar Senha</label>
    <input type="password" required name="confirmacao_senha" required placeholder="Confirmar Senha" class="form-control">
</div>

<div class=" custom-control custom-checkbox">

    <input type="hidden" name="ativo" value="0">

    <input type="checkbox" name="ativo" value="1" class="custom-control-input" id="ativo" <?php if ($usuario->ativo ==  true) : ?> checked <?php endif; ?>>

    <label class="custom-control-label" for="ativo">Usuário Ativo</label>
</div>