<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = '/visita/admin/galeria.php?id='. get_vars('id') ;

$item_records = null ;

// parametros para query
$where[] = " ativo = '1' AND id_ponto_turistico = ". get_vars('id') ;

list( $r , $records , $page , $total_pages ) = default_search( "tb_imagem" , $where, "", "id_imagem ASC" ) ;

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$geral = new geral() ;
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_imagem( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Imagem(ns) removida(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

// redirecionar para tela de inclusão
if( get_vars("new") ){
	redir_page( "galeria_editar.php?id=".get_vars("id") ) ;
}

include( $template_directory . "galeria.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

