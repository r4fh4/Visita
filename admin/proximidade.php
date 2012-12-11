<?php
require_once( "scripts/init.php" ) ;

$url = $_SERVER{"REQUEST_URI"} ;

$geral = new geral();

if( get_vars("turistico") ) {
	$url = set_url( $url, array( "turistico" => get_vars("turistico") ) ) ;
	$where[] = "id_ponto_turistico = ".get_vars("turistico");
	list( $r , $records , $page , $total_pages ) = default_search( "tb_proximidade a INNER JOIN tb_ponto b ON a.latitude = b.latitude AND a.longitude = b.longitude" , $where, "a.id_proximidade, b.endereco, a.grau_proximidade", "grau_proximidade ASC" ) ;
}

if( get_vars("new") ){

	$list_error = null ;
	
	if( get_vars("turistico") == "-" ){
		$list_errors[] = 'Campo "Ponto Turístico" é obrigatório!' ;
	}
	
	if( get_vars("ponto") == "-" ){
		$list_errors[] = 'Campo "Ponto" é obrigatório!' ;
	}
	
	if( get_vars("grau") == "-" ){
		$list_errors[] = 'Campo "Grau Proximidade" é obrigatório!' ;
	}
	
	if( is_array($list_errors) ){
		show_message_html( implode( "<br />" , $list_errors ), false ) ;
		exit();
	} else {
		$coords = explode( ',', get_vars('ponto') );
		$data = array(
			"latitude" => $coords{0}, 
			"longitude" => $coords{1},
			"grau" => get_vars("grau"),
			"turistico" => get_vars('turistico')
		) ;
		
		$geral->insert_proximidade( $data );
		
		show_message( "Proximidade inserida com sucesso!" ) ;
		redir_page( $url , true);
	}
}

// deletar imagens
if( get_vars("delete") ){
	
	if( get_vars("action_item") ){
		$list_itens = $_POST{"action_item"} ;
		$geral->delete_proximidade( "'" . implode( "','", $list_itens ) . "'" ) ;
			
		show_message( "Proximidade(s) removida(s) com sucesso!" ) ;
		redir_page( $url , true) ;
	}
	else{
		show_message( "Nenhum item selecionado para exclusão, favor selecionar.", false ) ;
		redir_page( $url, true ) ;
	}
}

$list = $geral->get_ponto_turistico();
$parada = $geral->get_parada();
$grau = array(
	1 => 'Muito Próximo',
	2 => 'Próximo',
	3 => 'Perto',
	4 => 'Longe'
);

include( $template_directory . "header.inc.php" ) ;

include( $template_directory . "proximidade.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>