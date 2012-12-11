<div id='main-pontos'>
	<p class='welcome'>Escolha um ponto turístico </p>
	<br /><br />
	<? if( $pontos ) { ?>
	<ul id='pontos-list'>
		<? foreach( $pontos as $item ) { ?>
		<li>
			<a href="pontos-turisticos/<?=$item{"id_ponto_turistico"}.'-'.normalize_text( htmlspecialchars($item{"nm_ponto_turistico"}), true );?>">
				<img src="<?=$furniture_directory;?>files/<?=$item{"imagem"};?>" />
				<br />
				<?=$item{"nm_ponto_turistico"};?>
			</a>
		</li>
		<? } ?>
	</ul>
	<? } ?>
	<br class='clean' /><br />
</div>