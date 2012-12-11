<?
class entidade_controller{
	
	public $model = null ;
	
	public function  __construct(){
		session_start() ;
		$this->model = new entidade ;
	}
	
	public function index(){
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$authentication->authenticate( $uri ) ;
		
		$pontos = $this->model->get_ponto_turistico();
		
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "ponto_turistico_index.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		$connection->disconnect() ;		
	}
	
	public function entidade_system( $data ){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		if( get_vars("back") ) {
			header( "Location: " . $base_url_site . "pontos-turisticos" ) ;
			exit();
		}
		
		$ponto =  $this->model->get_ponto_turistico( $data{"id_ponto"} )  ;
		if( $ponto ){
			$title = normalize_text( $ponto[0]{"nm_ponto_turistico"} ,true ) ;
			$short_url =  $base_url_site . "pontos-turisticos/" . $data{"id_ponto"} . "-" . $title ;
			if( $data{"slug"} ){
				if( $title != $data{"slug"} ){
					header( "Location: " . $base_url_site  . "pontos-turisticos/" . $data{"id_ponto"} . "-" . $title ) ;
					exit();
				}
			}
			
			if( get_vars("destino") ){
				header( "Location: " . $base_url_site  . "destino/" . $data{"id_ponto"} . "-" . $title ) ;
				exit();
			}
			
			//recuperar imagens do ponto turistico
			$imagens = $this->model->get_imagens( $data{"id_ponto"} );
			
			//recuperar comentários do ponto turistico
			$comentarios = $this->model->get_comentarios( $data{"id_ponto"} );
			
			$complement_title = htmlspecialchars( $ponto[0]{"nm_ponto_turistico"} ) ;
			$meta_description = htmlspecialchars( $ponto[0]{"nm_ponto_turistico"} ) ;
			$css_files = write_css_header( array( "entidade" ) ) ;
			$js_files = write_js_header( array( "entidade" ) ) ;
			
			include( $template_directory . "header.inc.php" ) ;
			include( $template_directory . "entidade.inc.php" ) ;
			include( $template_directory . "footer.inc.php" ) ;
			
		}
		else{
			header( "Location: " . $base_url_site . "pontos-turisticos" ) ;
			exit();
		}
	}
	
	public function destino_choose(){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		if( get_vars("back") ) {
			header( "Location: " . $base_url_site ) ;
			exit();
		}
		
		if( get_vars("destino") ) {
			if( get_vars("escolha") ) {
				header( "Location: " . $base_url_site . "destino/" . get_vars("escolha") ) ;
				exit();
			}
		}
		
		$pontos =  $this->model->get_ponto_turistico()  ;
		$css_files = write_css_header( array( "entidade" ) ) ;
			
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "destino_choose.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;
	}
	
	public function destino_system( $data ){
		
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		if( get_vars("back") ) {
			header( "Location: " . $base_url_site . "destino" ) ;
			exit();
		}
		
		$ponto =  $this->model->get_ponto_turistico( $data{"id_ponto"} )  ;
		if( $ponto ){
			$title = normalize_text( $ponto[0]{"nm_ponto_turistico"} ,true ) ;
			$short_url =  $base_url_site . "pontos-turisticos/" . $data{"id_ponto"} . "-" . $title ;
			if( $data{"slug"} ){
				if( $title != $data{"slug"} ){
					header( "Location: " . $base_url_site  . "pontos-turisticos/" . $data{"id_ponto"} . "-" . $title ) ;
					exit();
				}
			}
			
			if( get_vars("destino") ){
				header( "Location: " . $base_url_site  . "destino/" . $data{"id_ponto"} . "-" . $title ) ;
				exit();
			}
			
			$complement_title = htmlspecialchars( "Meu Destino - ".$ponto[0]{"nm_ponto_turistico"} ) ;
			$meta_description = htmlspecialchars( $ponto[0]{"nm_ponto_turistico"} ) ;
			$css_files = write_css_header( array( "marks" ) ) ;
			$js_files = write_js_header( array( "marks" ) ) ;
			$google_api = true;
			
			include( $template_directory . "header.inc.php" ) ;
			include( $template_directory . "marks.inc.php" ) ;
			include( $template_directory . "footer.inc.php" ) ;
			
		}
		else{
			header( "Location: " . $base_url_site . "destino" ) ;
			exit();
		}
	}
	
	public function rota_system() {
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		if( !get_vars('ponto') || !get_vars('destino') || !get_vars('lat') || !get_vars('lng') || !get_vars('onibus') ) {
			header( "Location: " . $base_url_site );
		}
		
		$complement_title = htmlspecialchars( "Meu Destino - ".get_vars('ponto') ) ;
		$meta_description = htmlspecialchars( get_vars('ponto') ) ;
		$css_files = write_css_header( array( "rota" ) ) ;
		$js_files = write_js_header( array( "rota" ) ) ;
		$google_api = true;
				
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "rota.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;		
		
	}
	
}
?>