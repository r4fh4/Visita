<? session_start() ; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="robots" content="noindex" />
		<title>Administrador Visita Santos - Login</title>
		
		<link href="furniture/css/global.css" type="text/css" rel="stylesheet" />
		
		<script language="javascript" type="text/javascript" src="furniture/js/jquery.js"></script>
		<script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$("#login").focus();
		});
		</script>
	</head>

<body>
	<div id="main-adm">
		<h2 class="page-title">Sistema Administrador do Visita Santos</h2>
		<p>TCC Unisanta</p>
		<div id='box-form'>
			<form name="form" id="form" action="index.php" method="post">
				<fieldset class="login">
					<legend style="width:160px;">Autentica��o necess�ria</legend>
					<br /><br /><br />
					<p>
					Login:<br /><input id="login" type="text" name="login" size="20" /><br /><br />
					Senha:<br /><input id="password" type="password" name="password" size="20" maxlength="20" /><br /><br />
					<input type="submit" name="ok" value="enviar" /> <input type="reset" name="clear" value="limpar" /> 
					</p>
					
						<?php					
						if( isset( $_SESSION{"error_message"} ) ){
							$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
							echo '<p class="feedback-login">' . $message . '</p>' ;						
							unset( $_SESSION{"error_message"} );
							//session_destroy() ;
						}
						?>
					
				</fieldset>
			</form>
		</div>
		<br class='clean' /><br /><br />
		<h2 class="page-title"></h2>
		<div id='login-footer'>
			Visita Santos <?=date('Y');?>
	</div>
</body>
</html>