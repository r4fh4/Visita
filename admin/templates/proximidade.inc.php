<script language="javascript">
	$(document).ready(function(){
		$('#turistico').change(function(){
			$('form[name=form]').submit();
		});
	});
</script>
<h2 class="page-title">Proximidade</h2>
<p>Página de edição de proximidades de um ponto turístico.</p>
<br /><br />
<form name="form" method="POST" action="proximidade.php">
	<!-- ACTIONS BUTTONS -->
	<p class="action-buttons">
		<?
		foreach( $list as $v ){
			$item_user[$v{"id_ponto_turistico"}] = $v{"nm_ponto_turistico"} ;
		}
		print "<label>Ponto Turístico </label>" . gui_render_select( "turistico" , $item_user , ( get_vars("turistico") ), "-", 'id="turistico"' ) ;
		?>
	</p>
</form>
<br class='clean' />
<? if( get_vars("turistico") ) { ?>
	<form name="form" method="POST" action="proximidade.php" target="response-form">
		<input type='hidden' name='turistico' value='<?=get_vars('turistico');?>' />
		<!-- ACTIONS BUTTONS -->
		<p class="action-buttons">
			<?
			foreach( $parada as $key => $val ){
				$item_org[$val{"latitude"}.','.$val{"longitude"}] = $val{"endereco"} ;
			}
			print "<label>Ponto </label>" . gui_render_select( "ponto" , $item_org , ( get_vars("ponto") ), "-", 'id="ponto"' ) ;
			?>
			<br class='clean' />
			<?
			foreach( $grau as $kk => $vv ){
				$gr[$kk] = $kk.' - '.$vv ;
			}
			print "<label>Grau de Proximidade </label>" . gui_render_select( "grau" , $gr , ( get_vars("grau") ), "-", 'id="grau"' ) ;
			?>
			<br class='clean' /><br />
			<div class='box-buttons'>
				<input type="submit" class="btn-form" name="new" value="Adicionar" />
			</div>
			<br class='clean' />
		</p>
	
	<!-- LIST DATA -->
	<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
	<? if( $records ){ ?>
	<table id="main-grid">
		<thead>
			<tr>				
				<th width="80%">Endereço</th>
				<th width="10%">Proximidade</th>
				<th width="10%">Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?
				$i = 0 ;			
				foreach( $records as $item ){
					?>
					<tr <?php print ( $i % 2 ?  'class="ops"' : "" )?> >
						<td><b><?=$item{"endereco"};?></b></td>
						<td><?=$item{"grau_proximidade"};?></td>
						<td class="check-action">
							<input type="checkbox" name="action_item[]" value="<?=$item{"id_proximidade"}?>">
						</td>
					</tr>
					<?
					$i++ ;
				}
				?>
		</tbody>
		
	</table>
		<div id="paginate"><? print render_paginate( $page , $total_pages , $url , $results_per_page ); ?></div>
	<? } ?>
		<input type="submit" class="btn-form right" name="delete" value="Apagar" />
	</form>
<? } ?>

<iframe id="response-form" name="response-form" frameborder="0" class="iframe"></iframe>