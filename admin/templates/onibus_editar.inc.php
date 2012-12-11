<h2 class="page-title">Incluir/Editar Ônibus</h2>
<p>Inclua ou edite os dados de um ônibus.</p>
<br />
<form name="form" class="input-form" method="POST" action="onibus_editar.php" target="response-form">
	<!-- HIDDEN INPUTS -->
	<input type="hidden" name="id_onibus" value="<?=$onibus_info[0]{"id_onibus"}?>" />
	
	<p class="action-buttons">
		<label>*Nome </label><input type="text" name="nome" value="<?=htmlspecialchars( $onibus_info{0}{"ds_onibus"} )?>" />
		<br class='clean' /><br />
		<div class='box-buttons'>
			<input type="submit" class="btn-form" name="back_to_list" value="Voltar para a lista" />
			<? if($onibus_info{0}{"id_onibus"}) { ?>
				<input type="submit" class="btn-form" name="edit" value="Editar" />
			<? } else { ?>
				<input type="submit" class="btn-form" name="new" value="Inserir" />
			<? } ?>
		</div>
		<br class='clean' />
	</p>	
</form>

<iframe id="response-form" name="response-form" frameborder="0" class="iframe"></iframe>