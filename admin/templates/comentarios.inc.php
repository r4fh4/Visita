<h2 class="page-title">Página de Comentários</h2>
<p>Página de Administração dos comentários do sistema.</p>

<form name="form" method="POST" action="comentarios.php">
<br class='clean' /><br />
<!-- LIST DATA -->
<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
<?if( $item_records ){?>
	<table id="main-grid" width="98%" align="center">
		<thead>
			<tr>
				<th width="20%">Usuário</th>
				<th width="45%">Comentário</th>
				<th width="20%">Ponto Turistíco</th>
				<th width="10%">Data</th>
				<th width="5%">Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i = 0 ;			
			foreach( $item_records as $item ){
				?>
				<tr <?php print ( $i % 2 ?  'class="ops"' : "" )?>>
					<td><b><?=htmlspecialchars($item{"user"})?></b></td>
					<td><?=htmlspecialchars($item{"comentario"})?></td>
					<td><?=htmlspecialchars($item{"ponto"})?></td>
					<td><?=$item{"data"};?></td>
					<td class="check-action">
					<?if($item{"id_grupo"}!=1){?>
						<input type="checkbox" name="action_item[]" value="<?=$item{"id"}?>">
					<?}
					else{ echo "-" ; }?>
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
	<br class='clean' />
</form>

		
