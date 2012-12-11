<h2 class="page-title">Incluir/Editar Ponto Turístico</h2>
<p>Inclua ou edite os dados de um ponto turístico.</p>
<br />
<form name="form" class="input-form" method="POST" action="pontos-turisticos_editar.php" target="response-form" enctype="multipart/form-data">
	<!-- HIDDEN INPUTS -->
	<input type="hidden" name="id_ponto" value="<?=$ponto_info[0]{"id_ponto_turistico"}?>" />
	
	<p class="action-buttons">
		<label>*Nome </label><input type="text" name="nome" value="<?=htmlspecialchars( $ponto_info{0}{"nm_ponto_turistico"} )?>" />
		<br class='clean' />
		<label>*História </label><textarea name="historia" cols="33" rows="6"><?=htmlspecialchars( $ponto_info{0}{"historia"} )?></textarea>
		<br class='clean' /><br />
		<label>Preços </label><textarea name="preco" cols="33" rows="6"><?=htmlspecialchars( $ponto_info{0}{"preco"} )?></textarea>
		<br class='clean' /><br />
		<label>Funcionamento </label><textarea name="funcionamento" cols="33" rows="6"><?=htmlspecialchars( $ponto_info{0}{"funcionamento"} )?></textarea>
		<br class='clean' /><br />
		<label>Informações </label><textarea name="informacoes" cols="33" rows="6"><?=htmlspecialchars( $ponto_info{0}{"informacoes"} )?></textarea>
		<br class='clean' /><br />
		<label>*Latitude </label><input type="text" name="latitude" value="<?=htmlspecialchars( $ponto_info{0}{"latitude"} )?>" />
		<br class='clean' />
		<label>*Longitude </label><input type="text" name="longitude" value="<?=htmlspecialchars( $ponto_info{0}{"longitude"} )?>" />
		<br class='clean' />
		<label>*Imagem </label><input type="file" name="imagem" value="" />
		<br class='clean' /><br />
		<div class='box-buttons'>
			<input type="submit" class="btn-form" name="back_to_list" value="Voltar para a lista" />
			<? if($ponto_info{0}{"id_ponto_turistico"}) { ?>
				<input type="submit" class="btn-form" name="edit" value="Editar" />
			<? } else { ?>
				<input type="submit" class="btn-form" name="new" value="Inserir" />
			<? } ?>
		</div>
		<br class='clean' />
	</p>	
</form>

<iframe id="response-form" name="response-form" frameborder="0" class="iframe"></iframe>