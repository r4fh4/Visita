<?php
header("Pragma: no-cache");
header("cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="robots" content="noindex" />
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Pragma" content="no-cache">
	<title><? echo ADM_LABEL ; ?></title>
	
	<link href="furniture/css/global.css" type="text/css" rel="stylesheet" />
	<link href="furniture/css/ThickBox.css" type="text/css" rel="stylesheet" />
	
	<script language="javascript" type="text/javascript" src="furniture/js/jquery.js"></script>	
	<script language="javascript" type="text/javascript" src="furniture/js/tickbox.js"></script>
	<script language="javascript" type="text/javascript">
	$(document).ready(function(){

		$.ajaxSetup({
			cache: false
		});

		
		$('input[name="delete"],input[name="activate"],input[name="desactivate"]').click(function(){
			if(!window.confirm( "Tem certeza que deseja prosseguir com a ação?" )){
				return false ;
			}
		});
		$('#logout').click(function(){
			window.location = "logout.php" ;
		});
		
	});
	</script>
</head>

<body>
	<div id="main">
		<!-- header -->
		<div id="header-adm">
			<p class="system-info"><? echo ADM_LABEL ; ?></p>
				<p class="system-login-info">
				<b>Logado como:</b> <? echo $_SESSION{"login_data"}{"full_name"} ; ?> - <b>Data:</b> <? echo date("d/m/Y H:i") ; ?> 
				<input type="button" class="btn-form" id="logout" name="logout" value="Sair com Segurança" />
				</p>
				<?php					
					$menu	= '<ul>' ;
					$menu	.= '<li ' . ( preg_match( "/(index)/", $_SERVER["REQUEST_URI"] ) ? 'class = "selected"' : "" ) . '><a href="index.php">Home</a></li>' ;
					
					$uri = false;
					$user = new user();
					$modules = $user->build_menu();
					foreach( $modules as $k => $v ){
						$menu	.= '<li ' . ( preg_match( "/(" . normalize_text($v{"nm_menu"}) . ")/", !$uri ? $_SERVER["REQUEST_URI"] : $uri ) ? 'class = "selected"' : "" ) . '><a href="' . normalize_text($v{"nm_menu"}). '.php">' . $v{"nm_menu"} . '</a></li>' ;
					}
					$menu .= '</ul>' ;
					echo $menu;
				?>
		</div>
		
		<!-- main -->
		<div id="main-adm">
		<? if( isset($_SESSION{"form_message" }) && ($_SESSION{"form_message" }!="") ){  print $_SESSION{"form_message" } ;  }  unset($_SESSION{"form_message" }); ?>