<div id='m-main'>
	<input type='hidden' id="destino" value="<?=get_vars('destino');?>" />
	<input type='hidden' id="onibus" value="<?=get_vars('onibus');?>" />
	<input type='hidden' id="lat" value="<?=get_vars('lat');?>" />
	<input type='hidden' id="lng" value="<?=get_vars('lng');?>" />
	<p class='welcome'>Rota Traçada</p>
	<br /><br />
	<ul id='legenda'>
		<li><img src="<?=$furniture_directory;?>images/flag_start.png" /> Ponto de Partida</li>
		<li><img src="<?=$furniture_directory;?>images/flag_rote.png" /> Rota</li>
		<li><img src="<?=$furniture_directory;?>images/flag_end.png" /> Ponto de Chegada</li>
		<li><img src="<?=$furniture_directory;?>images/flag_destino.png" /> Destino</li>
	</ul>
	<br class='clean' /><br />
	<div id="mapa" class="mapa"></div>
	<br class="clean" /><br />
	<input type='submit' value='' class='btn-voltar' />
	<br class='clean' /><br />
</div>