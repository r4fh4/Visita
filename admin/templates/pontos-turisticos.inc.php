<h2 class="page-title">Painel de Administração de Ponto Turístico</h2>
<p>Inclua e altere os dados dos pontos turístico que fazem parte do sistema.</p>

<form name="form" method="POST" action="pontos-turisticos.php">
<!-- ACTIONS BUTTONS -->
<p class="action-buttons">
	<label>Nome </label><input type="text" name="search_content" value="<?=htmlspecialchars(get_vars("search_content"))?>" size="50" class='' />
	<br class='clean' /><br />
	<center>
		<input type="submit" class="btn-form" name="search" value="Buscar" />
		<input type="submit" class="btn-form" name="clear_search" value="Limpar" />
	</center>
</p>
<br class='clean' /><br />
<input type="submit" class="btn-form left" name="new" value="Inserir Novo" />
<br class='clean' />
<!-- LIST DATA -->
<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
<?if( $records ){?>
	<table id="main-grid" width="98%" align="center">
		<thead>
			<tr>						
				<th width="5%">Editar</th>
				<th width="5%">Galeria</th>
				<th width="85">Ponto Turístico</th>
				<th width="5%">Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i = 0 ;			
			foreach( $records as $item ){
				?>
				<tr <?php print ( $i % 2 ?  'class="ops"' : "" )?>>
					<td class="check-action"><a href="pontos-turisticos_editar.php?id=<?=htmlspecialchars($item{"id_ponto_turistico"})?>"><img src="furniture/images/icn-edit.png" alt="Editar" title="Editar" /></a>
					</td>
					<td class="check-action"><a href="galeria.php?id=<?=htmlspecialchars($item{"id_ponto_turistico"})?>"><img src="furniture/images/icn-edit.png" alt="Galeria" title="Galeria" /></a>
					</td>
					<td><b><?=htmlspecialchars($item{"nm_ponto_turistico"})?></b></td>
					<td class="check-action">
					<input type="checkbox" name="action_item[]" value="<?=$item{"id_ponto_turistico"}?>">
					</td>
				</tr>		
				<?
				$i++ ;
			}
			?>
		</tbody>
	</table>
	<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
<?
}
else{
	
	?><h3>Nenhum resultado encontrado!</h3><?
}
?>

<!-- ACTIONS BUTTONS -->
	<input type="submit" class="btn-form right" name="delete" value="Apagar" />
	<input type="submit" class="btn-form right" name="new" value="Inserir Novo" />
	<br class='clean' />
</form>