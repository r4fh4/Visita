<div id='main-pontos'>
	<form action="<?=$base_url_site;?>destino" method="get">
		<p class='welcome'>Escolha um ponto turístico </p>
		<br /><br />
		<? if( $pontos ) { ?>
		<select id='choose_pontos' name='escolha'>
			<? foreach( $pontos as $item ) { ?>
			<option value="<?=$item{"id_ponto_turistico"}.'-'.normalize_text( htmlspecialchars($item{"nm_ponto_turistico"}), true );?>">
				<?=$item{"nm_ponto_turistico"};?>
			</option>
			<? } ?>
		</select>
		<? } ?>
		<br class='clean' /><br />
		<input type='submit' name="back" class='btn-voltar' value='_' />
		<input type='submit' name="destino" class='btn-destino' value='_' />
	</form>
</div>