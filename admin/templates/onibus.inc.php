<h2 class="page-title">Painel de Administração de Ônibus</h2>
<p>Inclua e altere os dados dos ônibus que fazem parte do sistema.</p>

<form name="form" method="POST" action="onibus.php">
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
				<th width="90">Ônibus</th>
				<th width="5%">Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i = 0 ;			
			foreach( $records as $item ){
				?>
				<tr <?php print ( $i % 2 ?  'class="ops"' : "" )?>>
					<td class="check-action"><a href="onibus_editar.php?id=<?=htmlspecialchars($item{"id_onibus"})?>"><img src="furniture/images/icn-edit.png" alt="Editar" title="Editar" /></a>
					</td>
					<td><b><?=htmlspecialchars($item{"ds_onibus"})?></b></td>
					<td class="check-action">
					<input type="checkbox" name="action_item[]" value="<?=$item{"id_onibus"}?>">
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