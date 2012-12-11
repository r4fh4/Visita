<script language="javascript">
	$(document).ready(function(){
		$('#onibus').change(function(){
			$('form[name=form]').submit();
		});
	});
</script>
<h2 class="page-title">Rotas</h2>
<p>Página de edição de rotas de um ônibus.</p>
<br /><br />
<form name="form" method="POST" action="rotas.php">
	<!-- ACTIONS BUTTONS -->
	<p class="action-buttons">
		<?
		foreach( $list as $v ){
			$item_user[$v{"id_onibus"}] = $v{"ds_onibus"} ;
		}
		print "<label>Ônibus </label>" . gui_render_select( "onibus" , $item_user , ( get_vars("onibus") ), "-", 'id="onibus"' ) ;
		?>
	</p>
</form>
<br class='clean' />
<? if( get_vars("onibus") ) { ?>
	<form name="form" method="POST" action="rotas.php" target="response-form">
		<input type='hidden' name='onibus' value='<?=get_vars('onibus');?>' />
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
			foreach( $sentido as $kk => $vv ){
				$gr[$kk] = $kk.' - '.$vv ;
			}
			print "<label>Sentido </label>" . gui_render_select( "sentido" , $gr , ( get_vars("sentido") ), "-", 'id="sentido"' ) ;
			?>
			<br class='clean' />
			<label>Sequência </label><input type='text' name='sequencia' value='' />
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
				<th width="70%">Endereço</th>
				<th width="10%">Sentido</th>
				<th width="10%">Sequencia</th>
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
						<td><?=$item{"sentido"};?></td>
						<td><?=$item{"sequencia"};?></td>
						<td class="check-action">
							<input type="checkbox" name="action_item[]" value="<?=$item{"id_rota"}?>">
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