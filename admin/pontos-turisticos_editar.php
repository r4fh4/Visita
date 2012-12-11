<?php
require_once( "scripts/init.php" ) ;

$ponto = new geral() ;

if( get_vars("new") ){

	$list_error = null ;
	
	if( !get_vars("nome") ){
		$list_errors[] = 'Campo "Nome" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("historia") ){
		$list_errors[] = 'Campo "História" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("latitude") ){
		$list_errors[] = 'Campo "Latitude" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("longitude") ){
		$list_errors[] = 'Campo "Longitude" é de preenchimento obrigatório!' ;
	}
	
	if( !$_FILES["imagem"]["tmp_name"] ){
		$list_errors[] = 'Você precisa enviar uma imagem para este ponto turistico!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
	
		if( $_FILES["imagem"]["tmp_name"] ){
			$original_image_path = $images_relative_directory . $_FILES["imagem"]["name"] ;
			move_uploaded_file( $_FILES["imagem"]["tmp_name"], $original_image_path );
		}
		
		$data = array(
			"nome" => get_vars("nome"),
			"historia" => get_vars("historia"),
			"preco" => get_vars("preco"),
			"func" => get_vars("funcionamento"),
			"info" => get_vars("informacoes"),
			"imagem" => $_FILES["imagem"]["name"],
			"latitude" => get_vars("latitude"),
			"longitude" => get_vars("longitude")
		) ;
		
		$ponto->insert_ponto_turistico( $data );
		
		show_message( "Ponto Turístico inserido com sucesso!" ) ;
		redir_page( "pontos-turisticos.php", true ) ;
	}
}

if( get_vars("edit") ){

	$list_error = null ;
	
	if( !get_vars("nome") ){
		$list_errors[] = 'Campo "Nome" é de preenchimento obrigatório!' ;
	}
	
	if( !get_vars("historia") ){
		$list_errors[] = 'Campo "História" é de preenchimento obrigatório!' ;
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
		if( $_FILES["imagem"]["tmp_name"] ){
			$original_image_path = $images_relative_directory . $_FILES["imagem"]["name"] ;
			move_uploaded_file( $_FILES["imagem"]["tmp_name"], $original_image_path );
		}
		
		$data = array(
			"id_ponto" => get_vars("id_ponto"),
			"nome" => get_vars("nome"),
			"historia" => get_vars("historia"),
			"preco" => get_vars("preco"),
			"func" => get_vars("funcionamento"),
			"info" => get_vars("informacoes"),
			"imagem" => $_FILES["imagem"]["name"] ? $_FILES["imagem"]["name"] : null,
			"latitude" => get_vars("latitude"),
			"longitude" => get_vars("longitude")
		) ;
		
		$ponto->edit_ponto_turistico( $data );
		
		show_message( "Dados do ponto turístico editados com sucesso!" ) ;
		redir_page( "pontos-turisticos.php", true ) ;
	}
}

// voltar para a lista
if( get_vars("back_to_list") ){
	redir_page( "pontos-turisticos.php", true) ;
}

include( $template_directory . "header.inc.php" ) ;

// passo ID
if( get_vars("id") ){

	$ponto_info = array();
	$ponto_info = $ponto->get_ponto_turistico( get_vars("id") ) ;
	if(!$ponto_info){
		redir_page( "pontos-turisticos.php" ) ;
	}
	
}

include( $template_directory . "pontos-turisticos_editar.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

