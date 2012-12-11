<h2 class="page-title">Incluir Imagem</h2>
<p>Inclua uma imagem na galeria de pontos turisticos.</p>
<br />
<form name="form" class="input-form" method="POST" action="galeria_editar.php" target="response-form" enctype="multipart/form-data">
	<input type='hidden' name='id' value='<?=get_vars('id');?>' />
	<p class="action-buttons">
		<label>*Imagem </label><input type="file" name="imagem" value="" />
		<br />
		<span style='font-size: 9px;color:#f90'>Não utilize imagens com o mesmo nome</span>
		<br class='clean' /><br />
		<div class='box-buttons'>
			<input type="submit" class="btn-form" name="back_to_list" value="Voltar para a lista" />
			<input type="submit" class="btn-form" name="new" value="Inserir" />
		</div>
		<br class='clean' />
	</p>	
</form>

<iframe id="response-form" name="response-form" frameborder="0" class="iframe"></iframe>