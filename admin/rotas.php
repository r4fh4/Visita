<?php
require_once( "scripts/init.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

$geral = new geral();

if( get_vars("onibus") ) {
	$url = set_url( $url, array( "onibus" => get_vars("onibus") ) ) ;
	$where[] = "id_onibus = ".get_vars("onibus");
	list( $r , $records , $page , $total_pages ) = default_search( "tb_rota a INNER JOIN tb_ponto b ON a.latitude = b.latitude AND a.longitude = b.longitude" , $where, "a.id_rota, b.endereco, a.sentido, a.sequencia", "sentido, sequencia" ) ;
}

if( get_vars("new") ){

	$list_error = null ;
	
	if( get_vars("onibus") == "-" ){
		$list_errors[] = 'Campo "Ônibus" é obrigatório!' ;
	}
	
	if( get_vars("ponto") == "-" ){
		$list_errors[] = 'Campo "Ponto" é obrigatório!' ;
	}
	
	if( get_vars("sentido") == "-" ){
		$list_errors[] = 'Campo "Sentido" é obrigatório!' ;
	}
	
	if( get_vars("sequencia") == "" ){
		$list_errors[] = 'Campo "Sequencia" é obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		$coords = explode( ',', get_vars('ponto') );
		$data = array(
			"latitude" => $coords{0}, 
			"longitude" => $coords{1},
			"sentido" => get_vars('sentido'),
			"onibus" => get_vars('onibus'),
			"sequencia" => get_vars('sequencia')
		) ;
		
		$verify = $geral->get_rota_sequencia( get_vars('onibus'), get_vars('sentido'), get_vars('sequencia') );
		
		if( $verify ) {
			foreach( $verify as $v ) {
				$geral->update_rota( $v{"id_rota"} );
			}
		}
		
		$geral->insert_rota( $data );
		
		show_message( "Rota inserida com sucesso!" ) ;
		redir_page( $url , true);
	}
}

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_rota( "'" . implode( "','", $list_itens ) . "'" ) ;
			
		show_message( "Rota(s) removida(s) com sucesso!" ) ;
		redir_page( $url , true) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url, true ) ;
	}
}

$list = $geral->get_onibus();
$parada = $geral->get_parada();
$sentido = array(
	1 => 'Ida',
	2 => 'Volta'
);

include( $template_directory . "header.inc.php" ) ;

include( $template_directory . "rotas.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>