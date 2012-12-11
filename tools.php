<?php
require_once( "scripts/init.php" ) ;

$action = get_vars("action");

if( $action ) {
	
	switch( $action ) {
		case 'get_pontos':
			$entidade = new entidade();
			
			$endereco = $entidade->get_infos_by_coordenadas( get_vars('lat'), get_vars('lng') );
			$pontos = $entidade->get_proximidade( get_vars('ponto') );			
			$circulares = $entidade->get_circular_by_ponto( $pontos, get_vars('lat'), get_vars('lng') );
			$rota = array();
			if( $circulares ) {
				foreach( $circulares as $item ) {
					foreach( $item as $v ) {
						$rota[ $v{"id_onibus"} ] = $v{"ds_onibus"};
					}
				}
			}
			
			$data = array(
				'endereco' => utf8_encode($endereco{0}{"endereco"}),
				'rotas' => $rota
			);
			
			echo json_encode( $data );
			
		break;
		case 'get_rota':
			$entidade = new entidade();
			
			$proximidade = $entidade->get_proximidade( get_vars('destino') );		
			if( $proximidade ) {
			
				$pontos = $entidade->get_rota_by_circular( get_vars('onibus') );
				if( $pontos ) {
					
					$fk = 0;
					foreach( $pontos as $key => $item ) {
						if( $item{"latitude"} != get_vars('lat') || $item{"longitude"} != get_vars('lng') ){
							unset($pontos[$key]);
						} else {
							$fk = $key;
							break;
						}
					}
					
					$end = false;
					foreach( $proximidade as $v ) {
						foreach( $pontos as $k => $x ) {
							if( $end )
								unset($pontos[$k]);
						
							if( $x{"latitude"} == $v{"latitude"} && $x{"longitude"} == $v{"longitude"} && $x{"sentido"} == $pontos[$fk]{"sentido"} ){
								$pontos[$k]['end'] = 1;
								$end = true;
							}
						}
						if( $end )
							break;
					}
				}
				
			}
			
			echo json_encode( $pontos );
			
		break;
		case 'get_endereco':
			$entidade = new entidade();
			
			$endereco = $entidade->get_infos_by_coordenadas( get_vars('lat'), get_vars('lng') );
			
			echo json_encode( utf8_encode( $endereco{0}{"endereco"} ) );
			
		break;
		case 'get_all':
			$entidade = new entidade();
			
			$pontos = $entidade->get_all_pontos();
			
			echo json_encode( $pontos );
			
		break;
		case 'get_coords_ponto':
			$entidade = new entidade();
			
			$coords = $entidade->get_coords_ponto( get_vars('destino') );
			
			echo json_encode( $coords );
			
		break;
		case 'get_all_by_destino':
			$entidade = new entidade();
			
			$data = $entidade->get_proximidade( get_vars('destino') );	
			
			$opcoes = $entidade->get_all_by_proximidade( $data );
			
			$pontos = $entidade->get_all_rota( $opcoes );
			
			echo json_encode( $pontos );
			
		break;
		case 'set_comentario':
			$entidade = new entidade();
			
			if( !get_vars('comentario') ) {
				echo 'no';
				exit();
			}
			
			if( trim( strip_tags( get_vars('comentario') ) ) == '' ) {
				echo 'no';
				exit();
			}
			
			$entidade->insert_comentario( get_vars('comentario'), get_vars('user'), get_vars('ponto') );
			echo 'ok';
			
		break;
	}
	
}

?>