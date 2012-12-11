<div id='m-main'>
	<div class='transparent'>
		<div class='conteudo'></div>
	</div>
	<form action="<?=$base_url_site;?>tracar-rota" method="post" id="form-post">
		<input type='hidden' id='ponto' name='ponto' value="<?=$ponto[0]{"nm_ponto_turistico"};?>" />
		<input type='hidden' id='destino' name='destino' value="<?=$data{"id_ponto"};?>" />
		<input type='hidden' id="lat" name='lat' value="" />
		<input type='hidden' id="lng" name='lng' value="" />
		<input type='hidden' id="onibus" name='onibus' value="" />
	</form>
	<p class='welcome'>Escolha um ponto de origem</p>
	<br /><br />
	<div id="mapa" class="mapa"></div>
	<br class="clean" />
	<b class='aviso'>(Os pontos que aparecem no mapa são somente os que possuem rotas para o destino escolhido)</b>
	<br /><br />
	<input type='button' value='' class='btn-voltar' />
	<br class='clean' /><br />
</div>