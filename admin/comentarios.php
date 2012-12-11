<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

$item_records = null ;
$geral = new geral() ;
$user = new user();

// parametros para query
$where[] = " ativo = '1' " ;

list( $r , $records , $page , $total_pages ) = default_search( "tb_comentario" , $where, "", "dt_comentario DESC" ) ;

if( $records ) {
	foreach( $records as $k => $v ) {
		$ponto = $geral->get_ponto_turistico( $v{"id_ponto_turistico"} );
		$nm = $user->get_user( $v{"id_user"} );
		$item_records[$k]["id"] = $v{"id_comentario"};
		$item_records[$k]["comentario"] = $v{"ds_comentario"};
		$item_records[$k]["user"] = $nm{0}{"nm_user"};
		$item_records[$k]["ponto"] = $ponto{0}{"nm_ponto_turistico"};
		$item_records[$k]["data"] = date( 'd/m/Y', strtotime( $v{"dt_comentario"} ) );
	}
}

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_comentario( "'" . implode( "','", $list_itens ) . "'" ) ;
		
		show_message( "Comentário(s) removido(s) com sucesso!" ) ;
		redir_page( $url ) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url ) ;
	}
}

include( $template_directory . "comentarios.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

