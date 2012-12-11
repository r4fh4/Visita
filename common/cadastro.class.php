<?php
class cadastro{
	
	var $target_redirect = null ;
	function __construct(){}
	
	private function verify_email( $email, $get_data_from_email = null , $token = null ){
		global $connection;
		if( $token ){
			$SQL = 'SELECT * FROM tb_user WHERE email = "'.mysql_real_escape_string($email).'" AND verification_code = "'.mysql_real_escape_string($token).'"' . (  $get_data_from_email ? " AND active='1' AND verify='1' AND verification_code is not null" : "" ) ;
		}
		else{
			$SQL = 'SELECT * FROM tb_user WHERE email = "'.mysql_real_escape_string($email).'"' . (  $get_data_from_email ? " AND active='1' AND verify='1' AND verification_code is not null" : "" ) ;
		}
		
		$result = $connection->execute($SQL,true);
		if($result){
			if( $get_data_from_email ){
				return $result ;
			}
			
			return is_array($result) ;
		}
		return false ;		
	}
	
	/**
	 * efetuar autenticaчуo
	 */	
	public function execute_authentication( $target_redirect = null ){
		global $secury_key2;
	
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		@session_start() ;
		if( $target_redirect && !preg_match( "/(\.\.|\"|\'|\.)+/", $target_redirect ) ){
			$this->target_redirect = $target_redirect ;
		}
		else if( get_vars( "target_redirect" ) && !preg_match( "/(\.\.|\"|\'|\.)+/", get_vars( "target_redirect" ) ) ){
			$target_redirect = get_vars( "target_redirect" ) ;
		}

		$user_info = null ;
		
		if ( array_key_exists( 'HTTP_USER_AGENT', $_SESSION ) ){
			if ( $_SESSION['HTTP_USER_AGENT'] != md5( $_SERVER['HTTP_USER_AGENT'] . $secury_key2 ) ){
			 
				$_SESSION{"error_message"} = "Acesso restrito!." ;
				header( "Location: " . $alias . "login?target_redirect=" . $this->target_redirect ) ;
				header("Content-Length: 0") ;
				exit();
			}
		}
		else{
			$_SESSION['HTTP_USER_AGENT'] = md5( $_SERVER['HTTP_USER_AGENT'] . $secury_key2 ) ;
		}	
				
		$test_authenticate = $this->authenticate() ;
		
		if( !$test_authenticate ){

			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Acesso restrito!" ;
			}					
			header( "Location: " . $alias . "login?target_redirect=" . $this->target_redirect ) ;
			header("Content-Length: 0") ;
			exit();
		}
		if( isset( $_SESSION{"login_data_site"} ) ){ 
			$user_info = $_SESSION{"login_data_site"} ;
		}
		
		if( isset($_SESSION{"error_message"}) ){
			unset( $_SESSION{"error_message"} ) ;
		}
		
		return $user_info ;	 
	 }
	 
	 /**
	 * mщtodo para autenticar usuсrio.
	 */
	public function authenticate(){

		global $secury_key ;
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;		
		
		$login	= trim( strip_tags( ( isset($_POST{"login"}) ? $_POST{"login"} : "" ) ) ) ;
		$pws	= trim( strip_tags( ( isset($_POST{"password"}) ? $_POST{"password"} : "" ) ) ) ;
		$now	= date( "Y-m-d H:i:s" ) ;

		// verificar se existe sessуo criada
		if( isset($_SESSION{"login_data_site"}) ){

			$session_data = $_SESSION{"login_data_site"} ;				
			if( $session_data{"login_key"} == md5( $secury_key .  $session_data{"ip"} . $session_data{"user_key"} ) ){ 
				$SQL = "SELECT * FROM tb_user WHERE id_user = '". mysql_real_escape_string( $session_data{"user_key"} ). "' AND active='1' AND verify='1' ";
				$results = $connection->execute( $SQL, true ) ;
				
				if( $results ){
					
					//calcular tempo do ultimo acesso ao sistema
					$diff_last_login = EXPIRATION_TIME ;
					if( $results[0]{"dt_last_login"} ){
						$last_login	= $results[0]{"dt_last_login"} ;
						$diff_last_login = timeDiff( $last_login, $now ) ;
					}
					
					if( $results[0]{"dt_last_login"} && $diff_last_login > EXPIRATION_TIME ){
						$this->logout() ;	
					}		
					
					// alterar status do usuсrio para logado
					$SQL = "UPDATE tb_user SET dt_last_login = '" . $now . "' WHERE id_user = '" . mysql_real_escape_string(  $session_data{"user_key"} ) . "' " ;
					$connection->execute( $SQL ) ;
					session_regenerate_id() ;
					return true ;	
				}
			}
		}
		
		//caso nуo haja sessуo, verifica se o acesso foi feito pelo facebook
		if ( $_POST['facebook-login'] == 1 && !empty($_POST['facebook-name']) ) {
			
			//cria senha padrуo para usuсrios facebook
			$pws = 'fb#us3r$p455w0rd';
			
			//verifica se jс existe o user
			$SQL = 'SELECT * FROM tb_user WHERE email = "'.$login.'" ';
			$res = $connection->execute($SQL, true);
			
			
			//caso nуo exista o usuсrio, щ criado um usuсrio com dados do facebook
			if( !$res ) {
				$SQL = 'INSERT INTO tb_user(nm_user, email, password, verification_code, active, verify, logged, login)';
				$SQL .= ' VALUES("'.$_POST['facebook-name'].'", "'.mysql_real_escape_string($login).'", MD5("'.$pws.'"), "f7a4c6e3b8o0o0k2", 1, 1, 0, "'.mysql_real_escape_string($login).'")';
				$connection->execute($SQL);
			}
		}		
		
		// caso nуo haja sessуo pega os dados do form de login.
		if( !empty( $login ) || !empty( $pws ) ){
		
			$SQL = "SELECT * FROM tb_user WHERE login = '". mysql_real_escape_string( $login ) ."' AND active='1' AND verify='1' ";
			$results = $connection->execute( $SQL, true ) ;

			// se encontrou o login digitado verifica a senha
			if( $results ){
				
				// verificar senhas
				if( !empty($results[0]{"password"}) && $results[0]{"password"} == md5( $pws ) ) {
				
					// alterar status do usuсrio para logado
					$SQL = "UPDATE tb_user SET logged = '1', dt_last_login = '" . $now . "' WHERE id_user = '" . mysql_real_escape_string( $results[0]{"id_user"} ) . "' " ;
					$connection->execute( $SQL ) ;
					
					// armazenar dados na session
					$ip						= $_SERVER['REMOTE_ADDR'] ;
					$hora					= time();
					$secury_key				= md5( $secury_key . $ip . $results[0]{"id_user"} ) ;
					$_SESSION{"login_data_site"} = array( 
						"full_name"		=> $results[0]{"nm_user"} ,
						"email"			=> $results[0]{"email"} ,
						"login"			=> $results[0]{"login"} ,
						"login_key"		=> $secury_key , 
						"ip"			=> $ip , 
						"user_key"		=> $results[0]{"id_user"}
					) ;
					unset( $login ) ;
					unset( $pws ) ;
					session_regenerate_id() ;
					$target_redirect = null ;
					if( $this->target_redirect ){
						$target_redirect = $this->target_redirect ;
					}
					else if( get_vars( "target_redirect" ) && !preg_match( "/(\.\.|\"|\'|\.)+/", get_vars( "target_redirect" ) ) ){
						$target_redirect = get_vars( "target_redirect" ) ;
					}
					
					header( "Location: " . $alias . $target_redirect ) ;
					header("Content-Length: 0") ;
					exit();
	
				}
				else{ 
					if(!isset($_SESSION{"error_message"})){
						$_SESSION{"error_message"} = "Dados de acesso incorretos." ;
					}
					return false ;
				}
			}
			else{
				if(!isset($_SESSION{"error_message"})){
					$_SESSION{"error_message"} = "Dados de acesso incorretos." ;
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
	public function logout(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$user_info = $_SESSION["login_data_site"] ;
		
		$SQL = "update tb_cadastro set logged = '0', dt_last_login = NOW() where id_cadastro = '" . mysql_real_escape_string( $user_info{"user_key"} ) . "' " ;
		$connection->execute( $SQL ) ;
		
		$_SESSION["login_data_site"] = null ;
		unset( $user_info ) ;
		unset( $_SESSION{"login_data_site"} );
		session_destroy() ;
		
		header( "Location: " . $alias ) ;
		header("Content-Length: 0");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		exit();
		
	}
	
	public function check_email_exists( $email, $id ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = "SELECT * FROM tb_user WHERE email = '". mysql_real_escape_string( $email ). "' AND id_user NOT IN (".$id.") ";
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function check_login_exists( $login, $id = null ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$where = $id ? " AND id_user NOT IN (".$id.") " : "";
		$SQL = "SELECT * FROM tb_user WHERE login = '". mysql_real_escape_string( $login ). "' " . $where ;
		$results = $connection->execute( $SQL, true ) ;
		return $results;
		
	}
	
	public function recover_password( $email = null, $token = null ){
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$results = $this->verify_email( $email, true, $token ) ;		
		if( $results ){
			return $results ;
		}
		return false ;
	
	}
	
	public function recover_dados( $email = null, $token = null ) {
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$results = $this->verify_email( $email, false, $token ) ;		
		if( $results ){
			return $results ;
		}
		return false ;
		
	}
	
	public function change_password( $new_pass, $email ){
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$SQL = sprintf( "update tb_user set password = md5('%s') where email = '%s'", mysql_real_escape_string( $new_pass ), mysql_real_escape_string( $email ) ) ;
		$connection->execute( $SQL ) ;		
	}
	
	public function update_user( $data ) {
	// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = 'UPDATE tb_user SET nm_user = "'.mysql_real_escape_string($data{"nome"}).'", login = "'.mysql_real_escape_string($data{"login"}).'", email = "'.mysql_real_escape_string($email).'" WHERE id_user = '.$data{"user"};
		$connection->execute( $SQL ) ;
		
	}
	
	public function novo_user( $nome, $login, $email, $senha, $code ) {
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = 	'INSERT INTO tb_user( nm_user, email, password, verification_code, active, verify, login) VALUES("'.mysql_real_escape_string($nome).'", "'.mysql_real_escape_string($email).'", '.
				'MD5("'.mysql_real_escape_string($senha).'"), "'.mysql_real_escape_string($code).'", "1", "0", "'.mysql_real_escape_string($login).'")';
		$connection->execute( $SQL ) ;
	}
	
	public function active_user( $email ) {
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$SQL = 'UPDATE tb_user SET verify = "1" WHERE email = "'.mysql_real_escape_string($email).'" ';
		$connection->execute( $SQL ) ;
	}
}
?>