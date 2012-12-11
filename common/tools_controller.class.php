<?
class tools_controller{
	
	public $model = null ;
	
	public function  __construct(){	}
	
	/*
	* Redirecionar para URL passada por parâmetro
	*/
	public function redir( $data, $args ){
		redir_page( $args{"url"} ) ;		
	}
	
}
?>