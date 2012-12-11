<?
require_once( "../scripts/init.php" ) ;

// Normalize environment
Environment::disableMagicQuotes () ;

// Get and normalize request
$request = new Request ;
$uri = str_replace( array( "'", '"', '%' ), "", $request->getPathInfo () ) ;
$levels = $request->getLevelsPathInfo () ;

$dispatcher = new Dispatcher ( $uri , $levels ) ;

// http_method , regex_pattern , class , method , [action] , [method_args]	

# regras para tools
$dispatcher->rules ( 'POST' , 'tools/mail/(?<slug>.+)?' , 'tools' , 'mail' ) ;
$dispatcher->rules ( 'GET' , '(tools).*' , 'tools' , 'redir', null, array( "url" => $page_not_found ) ) ;

# autenticações/login
$dispatcher->rules ( 'POST' , '(authenticate)' , 'cadastro' , 'index' ) ;
$dispatcher->rules ( 'GET' , '(login)?' , 'cadastro' , 'login_system' ) ;
$dispatcher->rules ( 'GET' , '(logout)' , 'cadastro' , 'logout_system' ) ;
$dispatcher->rules ( 'GET' , '(redefinir-acesso)?' , 'cadastro' , 'password_remember' ) ;
$dispatcher->rules ( 'POST' , '(redefinir-acesso-enviar)?' , 'cadastro' , 'password_remember' ) ;
$dispatcher->rules ( 'GET' , '(cadastro|cadastro/)', 'cadastro', 'cadastro_system' );
$dispatcher->rules ( 'POST' , '(cadastrar-user)', 'cadastro', 'cadastro_system' );
$dispatcher->rules ( 'GET' , '(ativar-acesso)?' , 'cadastro' , 'cadastro_active' ) ;
$dispatcher->rules ( 'GET' , '(meus-dados)', 'cadastro', 'dados_system' );
$dispatcher->rules ( 'POST' , '(meus-dados-enviar)?', 'cadastro', 'dados_system' );
$dispatcher->rules ( 'GET' , '(pontos-turisticos)', 'entidade', 'index' );
$dispatcher->rules ( 'GET' , 'pontos-turisticos/(?P<id_ponto>[0-9]+)(-?(?<slug>.+))?' , 'entidade' , 'entidade_system' ) ;
$dispatcher->rules ( 'GET' , '(destino)', 'entidade', 'destino_choose' );
$dispatcher->rules ( 'GET' , 'destino/(?P<id_ponto>[0-9]+)(-?(?<slug>.+))?' , 'entidade' , 'destino_system' ) ;
$dispatcher->rules ( 'POST' , 'tracar-rota', 'entidade', 'rota_system' ) ;

if( !$dispatcher->exec() ){
	header( "Location: " . $page_not_found ) ;
}
?>
