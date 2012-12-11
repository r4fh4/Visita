<?php
if (basename($_SERVER["PHP_SELF"]) == "init.php") {
    die("Acesso negado.");
}

// arquivos padrões
require_once( "config.php" ) ;

// arquivos comuns
require_once( $common_directory . "dispatcher.class.php" ) ;
require_once( $common_directory . "environment.class.php" ) ;
require_once( $common_directory . "request.class.php" ) ;

require_once( $common_directory . "connection.class.php" ) ;
require_once( $common_directory . "functions.php" ) ;
require_once( $common_directory . "cadastro.class.php" ) ;
require_once( $common_directory . "entidade.class.php" ) ;
require_once( $common_directory . "class.smtp.php" ) ;
require_once( $common_directory . "phpmailer.class.php" ) ;

//controllers
require_once( $common_directory . "cadastro_controller.class.php" ) ;
require_once( $common_directory . "index_controller.class.php" ) ;
require_once( $common_directory . "tools_controller.class.php" ) ;
require_once( $common_directory . "entidade_controller.class.php" ) ;

$connection = new connection( $db_server, $db_user, $db_pass, $db_name ) ;

?>