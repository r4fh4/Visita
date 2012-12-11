<?php
require_once( "scripts/init.php" ) ;

include( $template_directory . "header.inc.php" ) ;

include( $template_directory . "index.inc.php" ) ;

//fechar conexao
$connection->disconnect();

include( $template_directory . "footer.inc.php" ) ;
?>

