<?php
/**
* Classe connection 
* 
* Classe para conexгo ao banco de dados
* @author tamemiya 2011-03-16
* @version 1.0
*/
class connection{
	
	var $db_server	= "" ;
	var $db_user	= "" ;
	var $db_pass	= "" ;
	var $db_name	= "" ;
	var $conn		= false ;
	
	function __construct( $db_server, $db_user, $db_pass , $db_name ){

		$this->db_server	= $db_server ;
		$this->db_user		= $db_user ;
		$this->db_pass		= $db_pass ;
		$this->db_name		= $db_name ;
		
		return $this->connect() ;
	
	}
	
	/**
	 * mйtodo para iniciar conexгo com o banco.
	 */
	function connect(){
		
		$conn = @mysql_connect( $this->db_server, $this->db_user, $this->db_pass ) ;
		if( !$conn ){
			return false ;
		}
		$this->conn = $conn ;
		@mysql_select_db( $this->db_name, $this->conn );
		return $this->conn ;		
	}
	
	/**
	 * mйtodo para encerrar conexгo.
	 */
	function disconnect(){
		
		@mysql_close( $this->conn ) ;
		$this->conn = false ;
		
	}
	
	/**
	 * mйtodo para executar querys.
	 */
	function execute( $sql, $select = null ){

		$this->conn ;
		$query = @mysql_query( $sql ) ;
		$row = null ;
		
		// se for consulta retorna dados em array
		if( $select ){	
			$count_results = @mysql_num_rows( $query ) ;
			if( $count_results > 0 ){
				while( $row[] = @mysql_fetch_assoc( $query ) ){}				
				$data_list = null ;
				foreach( $row as $item => $value ){
					if($value){
						$data_list[$item] = $value ;
					}
				}
				if( $data_list ){
					return $data_list ;
				}
			}
		}
		return false ;	
	}
	
	/**
	 * mйtodo para  retornar ъltimo ID de inserзгo.
	 */
	function last_insert_id(){
		
		return mysql_insert_id() ;
		
	}
	
	/**
	 * mйtodo para retornar nъmero de linhas de querys.
	 */
	function get_num_rows( $sql ){
		
		$this->conn ;
		$result = @mysql_query( $sql ) ;
		return mysql_num_rows( $result ) ;
		
	}

}
?>