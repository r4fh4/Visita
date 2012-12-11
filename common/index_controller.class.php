<?
class index_controller{
	
	var $authenticated = false ;
	public $model = null ;
	
	public function  __construct(){	}
	
	public function index( $data = null ){
	
		// carregar variaveis globais
		require( ROOT_WEBSITE . "scripts/load_globals.php" ) ;
		
		$authenticated = false ;
		$authentication = new cadastro_controller ;
		$this->authenticated = $authentication->authenticate( $uri ) ;
		
		$css_files = write_css_header( array( "index" ) ) ;
		$js_files = write_js_header( array( "index" ) ) ;
		include( $template_directory . "header.inc.php" ) ;
		include( $template_directory . "index.inc.php" ) ;
		include( $template_directory . "footer.inc.php" ) ;
	}	
	
}
?>