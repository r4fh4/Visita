<?php
class authentication{
	
	function __construct(){}
	
	/**
	 * efetuar autenticaчуo
	 */	
	public function execute_authentication(){
	 
		@session_start() ;	
		
		if( isset($_SESSION{"login_data"}) ){
			session_regenerate_id() ;
		} else {
			$user_info = $this->authenticate() ;

			if( !$user_info ){

				if( !isset($_SESSION{"error_message"}) ){
					$_SESSION{"error_message"} = "Acesso restrito!" ;
				}					
				header( "Location: login.php" ) ;
				header("Content-Length: 0") ;
				exit();
			}

			if( isset($_SESSION{"error_message"}) ){
				unset( $_SESSION{"error_message"} ) ;
			}
		}		
	}	
	
	/**
	 * mщtodo para autenticar usuсrio.
	 */
	public function authenticate(){

		global $connection ;		
		
		$login	= trim( strip_tags( ( $_POST{"login"} ) ) ) ;
		$pws	= trim( strip_tags( ( $_POST{"password"} ) ) ) ;
		$now	= date( "Y-m-d H:i:s" ) ;
		
		// caso nуo haja sessуo pega os dados do form de login.
		if( $login != '' || $pws != '' ){

			$login	= trim( $login ) ;
			$pws	= trim( $pws ) ;
			
			$sql = "SELECT * FROM tb_admin_user WHERE login = '".mysql_real_escape_string( $login )."' AND senha = MD5('".mysql_real_escape_string( $pws )."') ";
			$results = $connection->execute( $sql, true ) ;

			// se encontrou o login digitado verifica a senha
			if( $results ){
			
				// alterar status do usuсrio para logado
				$sql = "UPDATE tb_admin_user SET logged = '1', dt_last_login = '" . $now . "' WHERE id_usuario = '" . mysql_real_escape_string( $results[0]{"id_usuario"} ) . "' " ;
				$connection->execute( $sql ) ;

				$ip						= $_SERVER['REMOTE_ADDR'] ;
				$hora					= time();
				$_SESSION{"login_data"} = array( 
					"full_name"		=> $results[0]{"nm_usuario"} ,
					"ip"			=> $ip , 
					"user_key"		=> $results[0]{"id_usuario"}
				) ;
				unset( $login ) ;
				unset( $pws ) ;
				session_regenerate_id() ;
				return $results;
			}
			else{
				if(!isset($_SESSION{"error_message"})){
					$_SESSION{"error_message"} = "Dados de acesso incorretos, contate o Administrador do Sistema." ;
				}
				return false ;
			}
		}
		else{
			if(!isset($_SESSION{"error_message"})){
				$_SESSION{"error_message"} = "Preencha os campos para efetuar o login." ;
			}
			return false ;
		}		
		return false ;
	}
	
	/**
	 * mщtodo para logout do sistema.
	 */
	static public function logout(){
		
		global $connection ;
		$user_info = $_SESSION["login_data"] ;
		
		$sql = "UPDATE tb_admin_user SET logged = '0', dt_last_login = NOW() WHERE id_usuario = '" . mysql_real_escape_string( $user_info{"user_key"} ) . "' " ;
		$connection->execute( $sql ) ;
		
		$_SESSION["login_data"] = null ;
		unset( $user_info ) ;
		unset( $_SESSION{"login_data"} );
		session_destroy() ;
		
		header( "Location: login.php" ) ;
		header("Content-Length: 0");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		exit();
		
	}
	
}
?>