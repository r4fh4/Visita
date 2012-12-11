<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

$item_records = null ;

// parametros para query
$where[] = " verify = '1' AND active = '1' " ;

if( get_vars("search_content") ){	
	$where[] = "nm_user like '%".get_vars('search_content')."%'"; 
	$url = set_url( $url, array( "search_content" => get_vars("search_content") ) ) ;
}

list( $r , $records , $page , $total_pages ) = default_search( "tb_user" , $where, "", "dt_cadastro DESC" ) ;

if( get_vars("clear_search") ){
	redir_page( set_url( $url, array("search_content" => null, "sr" => null ) ) ) ;
}

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$user = new user() ;
		$list_itens = $_POST{"action_item"} ;
		$user->delete_user( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Usuário(s) removido(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

include( $template_directory . "administracao.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

