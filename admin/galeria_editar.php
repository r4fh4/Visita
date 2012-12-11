<?php
require_once( "scripts/init.php" ) ;

$galeria = new geral() ;

if( get_vars("new") ){

	$list_error = null ;
	
	if( !$_FILES["imagem"]["tmp_name"] ){
		$list_errors[] = 'Imagem é obrigatória' ;
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
			"imagem" => $_FILES["imagem"]["name"],
			"ponto" => get_vars('id')
		) ;
		
		$galeria->insert_imagem( $data );
		
		show_message( "Imagem inserida com sucesso!" ) ;
		redir_page( "galeria.php?id=".get_vars('id'), true ) ;
	}
}

// voltar para a lista
if( get_vars("back_to_list") ){
	redir_page( "galeria.php?id=".get_vars('id'), true) ;
}

include( $template_directory . "header.inc.php" ) ;

include( $template_directory . "galeria_editar.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

