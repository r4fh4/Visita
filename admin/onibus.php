<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

$item_records = null ;

// parametros para query
$where[] = " ativo = '1' " ;

list( $r , $records , $page , $total_pages ) = default_search( "tb_onibus" , $where, "", "id_onibus" ) ;

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$geral = new geral() ;
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_onibus( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Ônibus removido(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

// redirecionar para tela de inclusão
if( get_vars("new") ){
	redir_page( "onibus_editar.php" ) ;
}

include( $template_directory . "onibus.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

