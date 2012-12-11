<h2 class="page-title">Página de Administração</h2>
<p>Página de Administração do sistema, gerencie usuários.</p>

<form name="form" method="POST" action="administracao.php">
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
<!-- LIST DATA -->
<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
<?if( $records ){?>
	<table id="main-grid" width="98%" align="center">
		<thead>
			<tr>
				<th width="55%">Usuário</th>
				<th width="30%">Login</th>
				<th width="10%">Data</th>
				<th width="5%">Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i = 0 ;			
			foreach( $records as $item ){
				?>
				<tr <?php print ( $i % 2 ?  'class="ops"' : "" )?>>
					<td><b><?=htmlspecialchars($item{"nm_user"})?></b></td>
					<td><?=htmlspecialchars($item{"login"})?></td>
					<td><?=date('d/m/Y', strtotime($item{"dt_cadastro"}));?></td>
					<td class="check-action">
					<?if($item{"id_grupo"}!=1){?>
						<input type="checkbox" name="action_item[]" value="<?=$item{"id_user"}?>">
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

		
