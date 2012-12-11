<?php
class geral{
	
	function __construct(){}
	
	function delete_onibus( $data ){
	
		global $connection ;
		$sql = "UPDATE tb_onibus SET ativo = '0' WHERE id_onibus in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function get_onibus( $id = null ){
	
		global $connection ;
		$where = $id ? "WHERE id_onibus = ".$id : "";
		$sql = "SELECT * FROM tb_onibus ".$where;
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}
	
	function insert_onibus( $data ) {
	
		global $connection ;
		$sql = "INSERT INTO tb_onibus(ds_onibus, ativo) VALUES('".$data{"nome"}."', '1') " ;
		$connection->execute( $sql ) ;
		
	}
	
	function edit_onibus( $data ) {
	
		global $connection ;
		$sql = "UPDATE tb_onibus SET ds_onibus = '".$data{"nome"}."' WHERE id_onibus = ". $data{"id_onibus"} ;
		$connection->execute( $sql ) ;
		
	}
	
	function delete_parada( $data ){
	
		global $connection ;
		$sql = "UPDATE tb_ponto SET ativo = '0' WHERE id_ponto in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function get_parada( $id = null ){
	
		global $connection ;
		$where = $id ? "WHERE id_ponto = ".$id : "";
		$sql = "SELECT * FROM tb_ponto ".$where." ORDER BY endereco" ;
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}
	
	function insert_parada( $data ) {
	
		global $connection ;
		$sql = "INSERT INTO tb_ponto(endereco, latitude, longitude, ativo) VALUES('".$data{"endereco"}."', '".$data{"latitude"}."', '".$data{"longitude"}."', '1') " ;
		$connection->execute( $sql ) ;
		
	}
	
	function edit_parada( $data ) {
	
		global $connection ;
		$sql = "UPDATE tb_ponto SET endereco = '".$data{"endereco"}."', latitude = '".$data{"latitude"}."', longitude = '".$data{"longitude"}."' WHERE id_ponto = ". $data{"id_ponto"} ;
		$connection->execute( $sql ) ;
		
	}
	
	function get_ponto_turistico( $id = null ) {
	
		global $connection ;
		$where = $id ? "WHERE id_ponto_turistico = " .$id : "";
		$sql = "SELECT * FROM tb_ponto_turistico ".$where." ORDER BY nm_ponto_turistico";
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}
	
	function delete_comentario( $data ){
	
		global $connection ;
		$sql = "UPDATE tb_comentario SET ativo = '0' WHERE id_comentario in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function delete_ponto_turistico( $data ){
	
		global $connection ;
		$sql = "UPDATE tb_ponto_turistico SET active = '0' WHERE id_ponto_turistico in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function insert_ponto_turistico( $data ) {
	
		global $connection ;
		$sql = 	"INSERT INTO tb_ponto_turistico(nm_ponto_turistico, historia, preco, funcionamento, informacoes, imagem, latitude, longitude, active) ".
				"VALUES('".$data{"nome"}."', '".$data{"historia"}."', '".$data{"preco"}."', '".$data{"func"}."', '".$data{"info"}."', '".$data{"imagem"}."', '".$data{"latitude"}."', '".$data{"longitude"}."', '1') " ;
		$connection->execute( $sql ) ;
		
	}
	
	function edit_ponto_turistico( $data ) {
	
		global $connection ;
		$adc = $data{"imagem"} ? ", imagem = '".$data{"imagem"}."' " : "";
		$sql = 	"UPDATE tb_ponto_turistico SET nm_ponto_turistico = '".$data{"nome"}."', latitude = '".$data{"latitude"}."', longitude = '".$data{"longitude"}."', ".
				"historia = '".$data{"historia"}."', preco = '".$data{"preco"}."', funcionamento = '".$data{"func"}."', informacoes = '".$data{"info"}."' ".$adc.
				"WHERE id_ponto_turistico = ". $data{"id_ponto"} ;
		$connection->execute( $sql ) ;
		
	}
	
	function delete_imagem( $data ){
	
		global $connection ;
		$sql = "UPDATE tb_imagem SET ativo = '0' WHERE id_imagem in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function insert_imagem( $data ) {
	
		global $connection ;
		$sql = "INSERT INTO tb_imagem(file_name, id_ponto_turistico, ativo) VALUES('".$data{"imagem"}."', '".$data{"ponto"}."', '1') " ;
		$connection->execute( $sql ) ;
		
	}
	
	function delete_proximidade( $data ){
	
		global $connection ;
		$sql = "DELETE FROM tb_proximidade WHERE id_proximidade in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function insert_proximidade( $data ) {
	
		global $connection ;
		$sql = 	"INSERT INTO tb_proximidade(latitude, longitude, grau_proximidade, id_ponto_turistico) ".
				"VALUES('".$data{"latitude"}."', '".$data{"longitude"}."', ".$data{"grau"}.", ".$data{"turistico"}.") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function delete_rota( $data ){
	
		global $connection ;
		$sql = "DELETE FROM tb_rota WHERE id_rota in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function insert_rota( $data ) {
	
		global $connection ;
		$sql = 	"INSERT INTO tb_rota(latitude, longitude, sentido, id_onibus, sequencia) ".
				"VALUES('".$data{"latitude"}."', '".$data{"longitude"}."', ".$data{"sentido"}.", ".$data{"onibus"}.", '".$data{"sequencia"}."') " ;
		$connection->execute( $sql ) ;
		
	}
	
	function get_rota_sequencia( $onibus, $sentido, $sequencia ) {
		
		global $connection ;
		$sql = "SELECT * FROM tb_rota WHERE id_onibus = ".$onibus." AND sentido = ".$sentido." AND sequencia >= ".$sequencia;
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}
	
	function update_rota ( $id ) {
		
		global $connection ;
		$sql = "UPDATE tb_rota SET sequencia = sequencia + 1 WHERE id_rota = ".$id ;
		$connection->execute( $sql ) ;
		
	}
	
}
?>