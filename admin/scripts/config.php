<?php

if (basename($_SERVER["PHP_SELF"]) == "config.php") {
    die("Acesso negado.");
}

//error_reporting(E^ALL) ;

//conex�o banco de dados	
$db_server	= "184.173.251.50" ;
$db_user	= "remoteadmin" ;
$db_pass	= "1cm3#wert$" ;
$db_name	= "visita_santos" ;	 

//vari�veis site
$base_url_site = "http://" . $_SERVER["SERVER_NAME"] . "/visita/" ;
$base_url_adm = "http://" . $_SERVER["SERVER_NAME"] . "/visita/admin/" ;
$base_website_root = $_SERVER['DOCUMENT_ROOT'] . "/visita/" ;
$base_admin_root = $_SERVER['DOCUMENT_ROOT'] . "/visita/admin/" ;
$alias = "/visita/" ;

//vari�veis diret�rios padr�es	
$common_directory = $base_admin_root . "common/" ;
$template_directory = $base_admin_root . "templates/" ;
$furniture_directory = $base_admin_root . "furniture/" ;

//Informa��o do sistema
$website_name = "Visita Santos" ;
$website_description = "" ;

// vari�veis padr�es
define( "ADM_LABEL", "Administrador Visita Santos" ) ;
define( "ROOT_WEBSITE", $base_website_root ) ;
define( "ROOT_ADM", $base_admin_root ) ;
define( "OWNER_SYSTEM", "Grupo" ) ;
define( "EXPIRATION_TIME", 30 ) ; // em minutos

//padr�es de imagens
define( "IMAGE_DEFAULT_FORMAT" , "jpg" ) ;
define( "IMAGE_LIMIT_SIZE", 1000 * 1024 ) ; //500 kb em bytes
define( "FILE_LIMIT_SIZE", 25000 * 1024 ) ; //500 kb em bytes

//padr�es
$results_per_page = 10 ;
$images_directory	= $base_admin_root . "furniture/images/" ;
$images_relative_directory = "../furniture/files/" ;
$files_directory	= $base_admin_root . "furniture/files/" ;

//p�gina n�o encontrada
$page_not_found = "http://" . $_SERVER["SERVER_NAME"] . "/visita/page-not-found.html" ;

?>