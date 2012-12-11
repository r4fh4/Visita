<?php
require_once( "scripts/init.php" ) ;

$onibus = new geral() ;

if( get_vars("new") ){

	$list_error = null ;
	
	if( !get_vars("nome") ){
		$list_errors[] = 'Campo "Nome" é de preenchimento obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		
		$data = array(
			"nome" => get_vars("nome")
		) ;
		
		$onibus->insert_onibus( $data );
		
		show_message( "Ônibus inserido com sucesso!" ) ;
		redir_page( "onibus.php", true ) ;
	}
}

if( get_vars("edit") ){

	$list_error = null ;
	
	if( !get_vars("nome") ){
		$list_errors[] = 'Campo "Nome" é de preenchimento obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		
		$data = array(
			"id_onibus" => get_vars("id_onibus"),
			"nome" => get_vars("nome")
		) ;
		
		$onibus->edit_onibus( $data );
		
		show_message( "Dados do ônibus editados com sucesso!" ) ;
		redir_page( "onibus.php", true ) ;
	}
}

// voltar para a lista
if( get_vars("back_to_list") ){
	redir_page( "onibus.php", true) ;
}

include( $template_directory . "header.inc.php" ) ;

// passo ID
if( get_vars("id") ){

	$onibus_info = array();
	$onibus_info = $onibus->get_onibus( get_vars("id") ) ;
	if(!$onibus_info){
		redir_page( "onibus.php" ) ;
	}
}

include( $template_directory . "onibus_editar.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

