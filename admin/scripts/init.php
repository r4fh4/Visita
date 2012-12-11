<?php
if (basename($_SERVER["PHP_SELF"]) == "init.php") {
    die("Acesso negado.");
}

// arquivos padrões
require_once( "config.php" ) ;

// arquivos comuns
require_once( $common_directory . "connection.class.php" ) ;
require_once( $common_directory . "authentication.class.php" ) ;
require_once( $common_directory . "functions.php" );
require_once( $common_directory . "geral.class.php" );
require_once( $common_directory . "user.class.php" );

// arquivos da aplicação
$user_info = null ;
$connection = new connection( $db_server, $db_user, $db_pass, $db_name ) ;

if( $connection ){
	
	$authentication = new authentication ;
	$authentication->execute_authentication() ;

}

?>