<?php
require_once( "scripts/init.php" ) ;

$ponto = new geral() ;

if( get_vars("new") ){

	$list_error = null ;
	
	if( !get_vars("endereco") ){
		$list_errors[] = 'Campo "Endereço" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("latitude") ){
		$list_errors[] = 'Campo "Latitude" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("longitude") ){
		$list_errors[] = 'Campo "Longitude" é de preenchimento obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		
		$data = array(
			"endereco" => get_vars("endereco"),
			"latitude" => get_vars("latitude"),
			"longitude" => get_vars("longitude")
		) ;
		
		$ponto->insert_parada( $data );
		
		show_message( "Ponto inserido com sucesso!" ) ;
		redir_page( "paradas.php", true ) ;
	}
}

if( get_vars("edit") ){

	$list_error = null ;
	
	if( !get_vars("endereco") ){
		$list_errors[] = 'Campo "Endereço" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("latitude") ){
		$list_errors[] = 'Campo "Latitude" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("longitude") ){
		$list_errors[] = 'Campo "Longitude" é de preenchimento obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		
		$data = array(
			"id_ponto" => get_vars("id_ponto"),
			"endereco" => get_vars("endereco"),
			"latitude" => get_vars("latitude"),
			"longitude" => get_vars("longitude")
		) ;
		
		$ponto->edit_parada( $data );
		
		show_message( "Dados do ponto editados com sucesso!" ) ;
		redir_page( "paradas.php", true ) ;
	}
}

// voltar para a lista
if( get_vars("back_to_list") ){
	redir_page( "paradas.php", true) ;
}

include( $template_directory . "header.inc.php" ) ;

// passo ID
if( get_vars("id") ){

	$ponto_info = array();
	$ponto_info = $ponto->get_parada( get_vars("id") ) ;
	if(!$ponto_info){
		redir_page( "paradas.php" ) ;
	}
}

include( $template_directory . "paradas_editar.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

