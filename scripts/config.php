<?php

if (basename($_SERVER["PHP_SELF"]) == "config.php") {
    die("Acesso negado.");
}

error_reporting(0) ;

//conexão banco de dados	
$db_server	= "184.173.251.50" ;
$db_user	= "remoteadmin" ;
$db_pass	= "1cm3#wert$" ;
$db_name	= "visita_santos" ;

//variáveis site
$base_url_site = "http://" . $_SERVER["SERVER_NAME"] . "/visita/" ;
$base_url_adm = "http://" . $_SERVER["SERVER_NAME"] . "/visita/admin/" ;
$base_website_root = $_SERVER['DOCUMENT_ROOT'] . "/visita/" ;
$alias = "/visita/" ;

//variáveis diretórios padrões	
$common_directory = $base_website_root . "common/" ;
$template_directory = $base_website_root . "templates/" ;
$furniture_directory = $alias . "furniture/" ;

//Informação do sistema
$website_name = "Visita Santos" ;
$website_description = "" ;

// mail info
$mail_server = "mail.lcmconsulting.com.br" ;
$mail_website = "contato@lcmconsulting.com.br" ;
$mail_pass_server = "c0nt@t0" ;

// variáveis padrões
define( "ADM_LABEL", "Portal" ) ;
define( "ROOT_WEBSITE", $base_website_root ) ;
define( "OWNER_SYSTEM", "Grupo" ) ;
define( "EXPIRATION_TIME", 30 ) ; // em minutos

//padrões de imagens
define( "IMAGE_DEFAULT_FORMAT" , "jpg" ) ;
define( "IMAGE_LIMIT_SIZE", 1000 * 1024 ) ; //500 kb em bytes
define( "FILE_LIMIT_SIZE", 25000 * 1024 ) ; //500 kb em bytes

//secure keys
$secury_key		= "86e2fa7775afab01a7fa91b817fe4866" ;
$secury_key2	= "VisitaSantos asdadadad876a5d76a5d$#534asdadasd" ;

//página não encontrada
$page_not_found = "http://" . $_SERVER["SERVER_NAME"] . "/visita/page-not-found.html" ;

//Keys do Facebook
define('FACEBOOK_APP_ID', '465228906820496');
define('FACEBOOK_SECRET', 'acc7d76370c7710976f974f5b4698a00');

?>