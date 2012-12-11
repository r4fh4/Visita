<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

// parametros para query
$where[] = " ativo = '1' " ;

if( get_vars("search_content") ){	
	$where[] = "endereco like '%".get_vars('search_content')."%'"; 
	$url = set_url( $url, array( "search_content" => get_vars("search_content") ) ) ;
}

list( $r , $records , $page , $total_pages ) = default_search( "tb_ponto" , $where, "", "endereco ASC" ) ;

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$geral = new geral() ;
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_parada( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Parada(s) removida(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

// redirecionar para tela de inclusão
if( get_vars("new") ){
	redir_page( "paradas_editar.php" ) ;
}

include( $template_directory . "paradas.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

