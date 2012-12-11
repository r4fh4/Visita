<div id='main-pontos'>
	<div id='box-choose' class='box'>
		<p class='btn-user'><?=$ponto{0}{"nm_ponto_turistico"};?></p>
		<br /><br />
		<ul class='choose-list'>
			<li>
				<input type='button' class="btn-informacoes <?=$ponto{0}{"informacoes"} ? "btn-action" : "opacity";?>" id="informacoes" value="" />
			</li>
			<li>
				<input type='button' class="btn-historia <?=$ponto{0}{"historia"} ? "btn-action" : "opacity";?>" id="historia" value="" />
			</li>
			<li>
				<input type='button' class="btn-preco <?=$ponto{0}{"preco"} ? "btn-action" : "opacity";?>" id="preco" value="" />
			</li>
			<li>
				<input type='button' class="btn-horario <?=$ponto{0}{"funcionamento"} ? "btn-action" : "opacity";?>" id="horario" value="" />
			</li>
			<li>
				<input type='button' class="btn-imagem <?=$imagens ? "btn-action" : "opacity";?>" id="imagem" value="" />
			</li>
			<li>
				<input type='button' class="btn-comentario btn-action" id="comentario" value="" />
			</li>
		</ul>
		<br class='clean' /><br />
		<div class='action-buttons'>
			<form action="<?=$base_url_site;?>pontos-turisticos/<?=$data{"id_ponto"}."-".$title;?>" method="get">
			<input type='submit' class='btn-destino' name="destino" value='_' />
			<br />
			<input type='submit' class='btn-voltar' name="back" value='_' />
			</a>
		</div>
		<br class='clean' /><br />
	</div>
	<div id='box-informacoes' class='box element-hidden'>
		<p class='welcome'>Informa��es</p>
		<br /><br />
		<p class='text'><?=$ponto{0}{"informacoes"};?></p>
		<br /><br />
		<input type='button' class='btn-voltar btn-action' id="choose" value="" />
	</div>
	<div id='box-historia' class='box element-hidden'>
		<p class='welcome'>Hist�ria</p>
		<br /><br />
		<p class='text'><?=$ponto{0}{"historia"};?></p>
		<br /><br />
		<input type='button' class='btn-voltar btn-action' id="choose" value="" />
	</div>
	<div id='box-preco' class='box element-hidden'>
		<p class='welcome'>Pre�os</p>
		<br /><br />
		<p class='text'><?=$ponto{0}{"preco"};?></p>
		<br /><br />
		<input type='button' class='btn-voltar btn-action' id="choose" value="" />
	</div>
	<div id='box-horario' class='box element-hidden'>
		<p class='welcome'>Hor�rio de Funcionamento</p>
		<br /><br />
		<p class='text'><?=$ponto{0}{"funcionamento"};?></p>
		<br /><br />
		<input type='button' class='btn-voltar btn-action' id="choose" value="" />
	</div>
	<div id='box-imagem' class='box element-hidden'>
		<p class='welcome'>Imagens</p>
		<br /><br />
		<?
		if( $imagens ) { ?>
		<ul id='imagem-list'>
			<? foreach($imagens as $v) { ?>
			<li>
				<a href="<?=$furniture_directory;?>files/<?=$v{"file_name"};?>">
					<img src="<?=$furniture_directory;?>files/<?=$v{"file_name"};?>" />
				</a>
			</li>
			<? } ?>
		</ul>
		<? } ?>
		<br class="clean"/><br />
		<input type='button' class='btn-voltar btn-action' id="choose" value="" />
	</div>
	<div id='box-comentario' class='box element-hidden'>
		<p class='welcome'>Coment�rios</p>
		<br /><br />
		<p class='text'>Utilize este espa�o para comentar suas opini�es sobre este ponto tur�stico. Comente aqui para ajudar pessoas, expressar acontecimentos, dicas, etc. Os coment�rios est�o sujeito a modera��o.</p>
		<br /><br />
		<? if( $comentarios ) { ?>
			<ul class='coment-list'>
				<? foreach( $comentarios as $v ) { ?>
				<li>
					<b><?=$v{"nm_user"}.' - '.date('d/m/Y', strtotime($v{"dt_comentario"}));?></b>
					<br /><br />
					<?=htmlspecialchars(nl2br($v{"ds_comentario"}));?>
				</li>
				<? } ?>
			</ul>
		<? } else { ?>
		<p class='feedback-form'>Nenhum coment�rio encontrado. Seja o primeiro a comentar.</p>
		<? } ?>
		<br class='clean' /><br />
		<h4>Expresse sua opini�o</h4>
		<br /><br />
		<input type='hidden' id='text-ponto' value='<?=$data{"id_ponto"};?>' />
		<input type='hidden' id='text-user' value='<?=$_SESSION{"login_data_site"}{"user_key"};?>' />
		<textarea name='comentario' id="text-comentario" cols="40" rows="8"></textarea>
		<br /><br />
		<input type='button' class='btn-voltar btn-action left' id="choose" value="" />
		<input type='button' id='enviar' value='_' class='btn-submit left' />
		<br class='clean' /><br />
	</div>
</div>