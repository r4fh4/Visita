<?php
/**
* Classe entidade 
*/
class entidade{
	
	var $target_redirect = null ;
	function __construct(){}
	
	public function get_ponto_turistico( $id = null ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT * FROM tb_ponto_turistico ".( $id ? "WHERE id_ponto_turistico = ".$id : "")." ORDER BY nm_ponto_turistico";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_imagens( $id ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT file_name FROM tb_imagem WHERE id_ponto_turistico = ".$id;
		$results = $connection->execute( $SQL, true ) ;
		return $results;		
		
	}
	
	public function get_comentarios( $id ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = 	"SELECT a.ds_comentario, a.dt_comentario, b.nm_user FROM tb_comentario a INNER JOIN tb_user b ON a.id_user = b.id_user ".
				"WHERE a.ativo = '1' AND a.id_ponto_turistico = ".$id." ORDER BY dt_comentario DESC";
		$results = $connection->execute( $SQL, true ) ;
		return $results;		
		
	}
	
	public function get_infos_by_coordenadas( $lat, $lng ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT endereco FROM tb_ponto WHERE latitude = '".$lat."' AND longitude = '".$lng."' ";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_proximidade( $ponto ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT latitude, longitude, grau_proximidade FROM tb_proximidade WHERE id_ponto_turistico = ".$ponto." ORDER BY grau_proximidade ";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_circular_by_ponto( $data, $lat, $lng ){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$pontos = array();
		foreach( $data as $v ) {
			$SQL = 	"SELECT a.id_onibus, c.ds_onibus FROM tb_rota a INNER JOIN tb_rota b ON a.id_onibus = b.id_onibus INNER JOIN tb_onibus c ON a.id_onibus = c.id_onibus ".
					"WHERE a.latitude = '".$lat."' AND a.longitude = '".$lng."' AND b.latitude = '".$v{"latitude"}."' AND b.longitude = '".$v{"longitude"}."' AND a.sentido = b.sentido ".
					"AND a.sequencia < b.sequencia";
			$results = $connection->execute( $SQL, true ) ;
			if( $results )
				array_push( $pontos, $results );
		}
		return $pontos;
		
	}
	
	public function get_rota_by_circular( $id ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT latitude, longitude, sequencia, sentido FROM tb_rota WHERE id_onibus = ".$id." ORDER BY sentido, sequencia ";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_all_pontos() {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT latitude, longitude FROM tb_ponto ";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_coords_ponto( $id ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT latitude, longitude FROM tb_ponto_turistico WHERE id_ponto_turistico = " .$id;
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_all_by_proximidade( $data ){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$first = true;
		foreach( $data as $v ) {
			if( $first ) {
				$SQL = 	"SELECT id_onibus, sentido, sequencia FROM tb_rota WHERE latitude = '".$v{"latitude"}."' AND longitude = '".$v{"longitude"}."' ";
				$first = false;
			} else {
				$SQL .= "UNION ALL SELECT id_onibus, sentido, sequencia FROM tb_rota WHERE latitude = '".$v{"latitude"}."' AND longitude = '".$v{"longitude"}."' ";
			}
		}
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function get_all_rota( $data ){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$first = true;
		foreach( $data as $v ) {
			if( $first ) {
				$SQL = 	"SELECT latitude, longitude FROM tb_rota WHERE id_onibus = '".$v{"id_onibus"}."' AND sentido = '".$v{"sentido"}."' AND sequencia <= '".$v{"sequencia"}."' ";
				$first = false;
			} else {
				$SQL .= "UNION ALL SELECT latitude, longitude FROM tb_rota WHERE id_onibus = '".$v{"id_onibus"}."' AND sentido = '".$v{"sentido"}."' AND sequencia <= '".$v{"sequencia"}."' ";
			}
		}
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function insert_comentario( $comment, $user, $ponto ) {
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "INSERT INTO tb_comentario(ds_comentario, id_user, id_ponto_turistico) VALUES('".mysql_real_escape_string($comment)."', ".mysql_real_escape_string($user).", ".mysql_real_escape_string($ponto)." )";
		$connection->execute( $SQL ) ;
		
	}
	
	
}
?>