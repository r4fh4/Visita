<h2 class="page-title">Incluir/Editar Ponto de ônibus</h2>
<p>Inclua ou edite os dados de um ponto de ônibus.</p>
<br />
<form name="form" class="input-form" method="POST" action="paradas_editar.php" target="response-form">
	<!-- HIDDEN INPUTS -->
	<input type="hidden" name="id_ponto" value="<?=$ponto_info[0]{"id_ponto"}?>" />
	
	<p class="action-buttons">
		<label>*Endereço </label><input type="text" name="endereco" value="<?=htmlspecialchars( $ponto_info{0}{"endereco"} )?>" />
		<br class='clean' />
		<label>*Latitude </label><input type="text" name="latitude" value="<?=htmlspecialchars( $ponto_info{0}{"latitude"} )?>" />
		<br class='clean' />
		<label>*Longitude </label><input type="text" name="longitude" value="<?=htmlspecialchars( $ponto_info{0}{"longitude"} )?>" />
		<br class='clean' /><br />
		<div class='box-buttons'>
			<input type="submit" class="btn-form" name="back_to_list" value="Voltar para a lista" />
			<? if($ponto_info{0}{"id_ponto"}) { ?>
				<input type="submit" class="btn-form" name="edit" value="Editar" />
			<? } else { ?>
				<input type="submit" class="btn-form" name="new" value="Inserir" />
			<? } ?>
		</div>
		<br class='clean' />
	</p>	
</form>

<iframe id="response-form" name="response-form" frameborder="0" class="iframe"></iframe>