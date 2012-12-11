<?
class cadastro_controller{
	
	var $authenticated = false ;
	public $model = null ;
	
	public function  __construct(){
		session_start() ;
		$this->model = new cadastro ;
	}
	
	public function index(){
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		if( get_vars("email-send") ){
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
		
		//requer autenticação
		$user_info = $this->model->execute_authentication( get_vars( "target_redirect" ) ) ;
		
		if( !$user_info ){
			$_SESSION{"error_message"} = "Acesso restrito!." ;
			header( "Location: " . $base_url_site . "login?redirect=" . get_vars( "target_redirect" ) ) ;
			header("Content-Length: 0") ;
			exit();
		}		
		else{
			header( "Location: " . $base_url_site . get_vars( "target_redirect" ) ) ;
			header("Content-Length: 0") ;
			exit();
		}
	}
	
	public function authenticate( $target_redirect = null ){
		
		$user_info = $this->model->execute_authentication( ( $target_redirect ? $target_redirect : null ) ) ;
		
		if( !$user_info ){
			$_SESSION{"error_message"} = "Acesso restrito!." ;
			header( "Location: " . $alias . "login?target_redirect=" . ( $target_redirect ? $target_redirect : null ) ) ;
			header("Content-Length: 0") ;
			exit();
		}
		return true ;		
	}
	
	public function login_system(){
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$no_footer = true;
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "login.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;	
		
	}
	
	public function logout_system(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$this->model->logout() ;
	}
	
	public function password_remember(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		$default_message = '<h3>Redefinir senha</h3><p>Digite seu e-mail e clique em "enviar" para redefinir sua senha.</p>' ;
		$state = "begin" ;
		
		// se o campo hidden foi enviado redireciono para a HOME 
		if( get_vars("ok") && get_vars("email-send") ){
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
		// se nao digitou o email
		if( get_vars("ok") && !get_vars("email") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo e-mail é obrigatório!" ;
			}
		}
		// se digitou email
		if( get_vars("ok") && get_vars("email") && !get_vars("email-send") ){
			
			//se o email nao existe na base
			if(!check_email( get_vars("email") )){
				if( !isset($_SESSION{"error_message"}) ){
					$_SESSION{"error_message"} = "E-mail digitado não é válido!" ;
				}
			}
			//se existe
			else{
				$results = $this->model->recover_password( get_vars("email") ) ;
				if( !$results ){
					if(!isset($_SESSION{"error_message"})){
						$_SESSION{"error_message"} = "E-mail digitado não consta em nossa base de dados!" ;
					}
				}
				else{					
					$state = false ;
					$msg = '
					<h3>Alteração de senha de acesso ao Visita Santos</h3>
					<p>Para alterar sua senha você deve acessar o link abaixo:</p>
					<p>Clique no link ou copie e cole no seu navegador: <a href="' . $base_url_site . 'redefinir-acesso?token=' .  htmlspecialchars( $results[0]{"verification_code"} )  . '&email=' . get_vars("email") . '">' . $base_url_site . 'redefinir-acesso?token=' .  htmlspecialchars( $results[0]{"verification_code"} )  . '&email=' . get_vars("email") . '</a></p>' ;
					send_email( 'Contato Visita Santos','contato@lcmconsulting.com.br','Redefinir senha de acesso ao Visita Santos', $msg , get_vars("email") ) ;
					$default_message = "<h3>Dados enviados</h3><p>Enviamos um e-mail para que você possa redefinir sua senha.</p>" ;
					
				}
			}
		}
		//se acessou o email e clicou no link para redefinir a senha
		if( get_vars("email") && get_vars("token") ){
			$results = $this->model->recover_password( get_vars("email"), get_vars("token") ) ;
			if( !$results ){
				header( "Location: " . $base_url_site ) ;
				header("Content-Length: 0") ;
				exit();
			}
			else{
				$state = "change" ;
				$default_message = "<h3>Alterar dados</h3><p>Digite sua nova senha duas vezes nos campos acima.</p>" ;
			}
		}
		
		// se redefiniu a senha
		if( get_vars("change") && get_vars("password") && get_vars("re-password") && get_vars("email") ){
			
			if( ( get_vars("password") == get_vars("re-password") ) && ( get_vars("password") === get_vars("re-password") ) && ( strcmp( get_vars("password"), get_vars("re-password") ) == 0 ) ){
				$results = $this->model->recover_password( get_vars("email") ) ;
				if( $results ){
					$this->model->change_password( get_vars("password"), get_vars("email") ) ;
					$state = "success" ;
					$default_message = '<h3>Dados alterados com sucesso!</h3><p>Enviamos para o e-mail "' . htmlspecialchars( get_vars("email") ) . '" a nova senha de acesso ao Visita Santos. </p>' ;
					$msg = 'Sua nova senha de acesso ao Visita Santos foi enviada para o e-mail " '. get_vars("email") . ' ", guarde-a com segurança:<br />' . get_vars("password") ;
					send_email( 'Contato Visita Santos','contato@lcmconsulting.com.br','Nova senha de acesso', $msg , get_vars("email") ) ;
				}
				else{
					if( !isset($_SESSION{"error_message"}) ){
						$_SESSION{"error_message"} = "E-mail digitado não é válido!" ;
					}
				}
				
			}
			else{
				$state = "change" ;
				$default_message = '<h3>Redefinir senha</h3><p>Digite a nova senha para acesso ao Visita Santos.</p>' ;
				if(!isset($_SESSION{"error_message"})){
					$_SESSION{"error_message"} = "Dados digitados não conferem, digite novamente!" ;
				}	
			}
			
		}
		else if( get_vars("change") && ( !get_vars("password") || !get_vars("re-password") ) ){
			$state = "change" ;
				$default_message = '<h3>Redefinir senha</h3><p>Digite a nova senha para acesso ao Visita Santos.</p>' ;
				if(!isset($_SESSION{"error_message"})){
					$_SESSION{"error_message"} = "Dados digitados não conferem, digite novamente!" ;
			}
		}
		
		$css_files = write_css_header( array('password') );
		$no_footer = true;
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "password_remember.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;
	}
	
	public function cadastro_system(){
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		if( get_vars("back") ) {
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
	
		// se o campo hidden foi enviado redireciono para a HOME 
		if( get_vars("ok") && get_vars("email-send") ){
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
		
		// se nao digitou o nome
		if( get_vars("ok") && !get_vars("nome") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo nome é obrigatório!" ;
			}
		}
		
		// se nao digitou o email
		if( get_vars("ok") && !get_vars("email") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo e-mail é obrigatório!" ;
			}
		}
		
		// se nao digitou o login
		if( get_vars("ok") && !get_vars("login") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo login é obrigatório!" ;
			}
		}
		
		// se nao digitou a senha
		if( get_vars("ok") && strlen(get_vars("password")) < 5 ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo senha é obrigatório e precisa conter no minimo 5 caracteres!" ;
			}
		}
		
		// se digitou email
		if( get_vars("ok") && get_vars("email") && !get_vars("email-send") && get_vars("login") && get_vars("password") ){
			//se o email é valido
			if(!check_email( get_vars("email") )){
				if( !isset($_SESSION{"error_message"}) ){
					$_SESSION{"error_message"} = "E-mail digitado não é válido!" ;
				}
			}
			//se for valido
			else{
				$results = $this->model->recover_password( get_vars("email") ) ;
				if( $results ){
					if(!isset($_SESSION{"error_message"})){
						$_SESSION{"error_message"} = "E-mail digitado já consta em nossa base de dados!" ;
					}
				}
				else{
					$check_login = $this->model->check_login_exists( get_vars("login") ) ;
					if( $check_login ) {
						if(!isset($_SESSION{"error_message"})){
							$_SESSION{"error_message"} = "Login digitado já consta em nossa base de dados!" ;
						}
					} else {
						$code = create_unique_code();
						$this->model->novo_user( get_vars('nome'), get_vars('login'), get_vars('email'), get_vars('password'), $code );
						$msg = '
						<h3>Ativação de acesso ao Visita Santos</h3>
						<p>Para completar seu cadastro você deve acessar o link abaixo:</p>
						<p>Clique no link ou copie e cole no seu navegador: <a href="' . $base_url_site . 'ativar-acesso?token=' .  htmlspecialchars( $code )  . '&email=' . get_vars("email") . '">' . $base_url_site . 'ativar-acesso?token=' .  htmlspecialchars( $code )  . '&email=' . get_vars("email") . '</a></p>' ;
						send_email( 'Contato Visita Santos','contato@lcmconsulting.com.br','Ativar acesso ao Visita Santos', $msg , get_vars("email") ) ;
						$default_message = "<h3>Dados enviados</h3><p>Enviamos um e-mail para que você possa ativar seu cadastro.</p>" ;
					}
				}
			}
		}
		
		$no_footer = true;
		
		$css_files = write_css_header( array('cadastro') );
		
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "cadastro.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;	
		
	}
	
	public function dados_system(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		// se o campo hidden foi enviado redireciono para a HOME 
		if( get_vars("ok") && get_vars("email-send") ){
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
		
		// se clicar no botão voltar
		if( get_vars("back") ) {
			header( "Location: " . $alias) ;
			header("Content-Length: 0") ;
			exit();
		}
		
		// se nao digitou o nome
		if( get_vars("ok") && !get_vars("nome") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo nome é obrigatório!" ;
			}
		}
		
		// se nao digitou o email
		if( get_vars("ok") && !get_vars("email") ){
			if( !isset($_SESSION{"error_message"}) ){
				$_SESSION{"error_message"} = "Campo e-mail é obrigatório!" ;
			}
		}
		
		// se digitou email
		if( get_vars("ok") && get_vars("email") ){
			
			if(!check_email( get_vars("email") )){
				if( !isset($_SESSION{"error_message"}) ){
					$_SESSION{"error_message"} = "E-mail digitado não é válido!" ;
				}
			} else {
				$results = $this->model->check_email_exists( get_vars("email"), $_SESSION{"login_data_site"}{"user_key"} ) ;
				if( $results ){
					if(!isset($_SESSION{"error_message"})){
						$_SESSION{"error_message"} = "E-mail digitado já consta em nossa base de dados!" ;
					}
				}
			}
			
		}
		
		if( get_vars("ok") && !get_vars("login") ) {
			if( !isset($_SESSION{"error_message"}) ) {
				$_SESSION{"error_message"} = "Campo login é obrigatório!" ;
			} 
		}
		
		// se digitou login
		if( get_vars("ok") && get_vars("login") ){
		
			$results = $this->model->check_login_exists( get_vars("login"), $_SESSION{"login_data_site"}{"user_key"} ) ;
			if( $results ){
				if(!isset($_SESSION{"error_message"})){
					$_SESSION{"error_message"} = "Login digitado já consta em nossa base de dados!" ;
				}
			}	
			
		}
		
		// se redefiniu a senha
		if( get_vars("ok") && get_vars("login") && get_vars("nome") && get_vars("email") && !get_vars("email-send") ){
			
			$data = array(
				'nome' => get_vars('nome'),
				'email' => get_vars('email'),
				'login' => get_vars('login'),
				'user' => $_SESSION{"login_data_site"}{"user_key"}
			);
			
			$this->model->update_user( $data );
			
			$_SESSION{"login_data_site"}{"login"} = get_vars('login');
			$_SESSION{"login_data_site"}{"full_name"} = get_vars('nome');
			$_SESSION{"login_data_site"}{"email"} = get_vars('email');
			
			$_SESSION{"info_message"} = 'Dados atualizados com sucesso!';
		}
		
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "meus_dados.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;
	}
	
	public function cadastro_active(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$default_message = '<h3>Cadastro Ativado com sucesso</h3>' ;
		
		if( get_vars("email") && get_vars("token") ){
			$results = $this->model->recover_dados( get_vars("email"), get_vars("token") ) ;
			if( !$results ){
				header( "Location: " . $base_url_site ) ;
				header("Content-Length: 0") ;
				exit();
			}
			
			$this->model->active_user( get_vars("email") );
			
		} else {
			header( "Location: " . $base_url_site ) ;
			header("Content-Length: 0") ;
			exit();
		}
		
		$css_files = write_css_header( array('cadastro') );
		$no_footer = true;
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "ativacao.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;
	}
	
}
?>