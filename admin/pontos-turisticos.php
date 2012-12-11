<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

// parametros para query
$where[] = " active = '1' " ;

if( get_vars("search_content") ){	
	$where[] = "nm_ponto_turistico like '%".get_vars('search_content')."%'"; 
	$url = set_url( $url, array( "search_content" => get_vars("search_content") ) ) ;
}

list( $r , $records , $page , $total_pages ) = default_search( "tb_ponto_turistico" , $where, "", "nm_ponto_turistico ASC" ) ;

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$geral = new geral() ;
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_ponto_turistico( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Ponto(s) Turístico removido(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

// redirecionar para tela de inclusão
if( get_vars("new") ){
	redir_page( "pontos-turisticos_editar.php" ) ;
}

include( $template_directory . "pontos-turisticos.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

