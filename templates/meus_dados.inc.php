<div id="login-main">
	<form name="form" id="form" action="<?=$alias?>meus-dados-enviar" method="post">
		<div class="login">
			<p class="element-hidden"><input type="text" name="email-send" value="" /></p>
			<?php					
			if( isset( $_SESSION{"error_message"} ) ){
				$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
				echo '<p class="feedback-form-fail">' . $message . '</p><br />' ;						
				unset( $_SESSION{"error_message"} );
			}
			
			if( isset( $_SESSION{"info_message"} ) ) {
				$message = trim( htmlspecialchars( (isset($_SESSION{"info_message"}) ? $_SESSION{"info_message"} : null ) ) ) ;
				echo '<p class="feedback-form">' . $message . '</p><br />' ;
				unset( $_SESSION{"info_message"} );
			}
			?>
			<label>Nome</label> <input id="nome" type="text" name="nome" value="<?=$_SESSION{"login_data_site"}{"full_name"};?>" class='form-class left'/>
			<br /><br />
			<label>Email</label> <input id="email" type="text" name="email" value="<?=$_SESSION{"login_data_site"}{"email"};?>" class='form-class'/>
			<br /><br />
			<label>Login</label> <input id="login" type="text" name="login" value="<?=$_SESSION{"login_data_site"}{"login"};?>" class='form-class'/>
			<br /><br />
			<input type="submit" class="btn-voltar" name="back" value="back" />
			<input type="submit" class="btn-atualizar" name='ok' value="ok" />
			<br class='clean' /><br />
		</div>
	</form>
</div>
