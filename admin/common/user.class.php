<?php
class user{
	
	function __construct(){}
	
	function delete_user( $data ){
		global $connection ;
		$sql = "UPDATE tb_user SET active = '0', verify = '0' WHERE id_user in(" . $data . ") " ;
		$connection->execute( $sql ) ;
		
	}
	
	function build_menu(){
	
		global $connection ;
		$sql = "SELECT * FROM tb_admin_menu ORDER BY nm_menu ASC " ;
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}
	
	function get_user( $id ) {
	
		global $connection ;
		$sql = "SELECT * FROM tb_user WHERE id_user = " .$id ;
		$results = $connection->execute( $sql, true ) ;
		return $results;
		
	}

}
?>