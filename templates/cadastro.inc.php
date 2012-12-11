<div id="login-main">
	<div class='default-message'>
		<?=$default_message?>
		<br /><br />
	</div>
	<form name="form" id="form" action="<?=$alias?>cadastrar-user" method="post">
		<div class="login">
			<p class="element-hidden"><input type="text" name="email-send" value="" /></p>
			<label>Nome</label> <input id="nome" type="text" name="nome" value="<?=get_vars('nome');?>" class='form-class left'/>
			<br /><br />
			<label>Email</label> <input id="email" type="text" name="email" value="<?=get_vars('email');?>" class='form-class'/>
			<br /><br />
			<label>Login</label> <input id="login" type="text" name="login" value="<?=get_vars('login');?>" class='form-class'/>
			<br /><br />
			<label>Senha</label> <input id="login" type="password" name="password" value="<?=get_vars('password');?>" class='form-class'/>
			<br /><br />
			<?php					
			if( isset( $_SESSION{"error_message"} ) ){
				$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
				echo '<p class="feedback-login">' . $message . '</p>' ;						
				unset( $_SESSION{"error_message"} );
				session_destroy() ;
			}
			?>
			<br /><br />
			<input type="submit" class="btn-voltar" value="_" name="back" />
			<? if( !$default_message ) { ?><input type="submit" class="btn-cadastro" value="_" name="ok" /> <? } ?>
			<input type="hidden" name="target_redirect" value="<?=htmlspecialchars(get_vars("target_redirect"));?>" />
			<br class='clean' />
		</div>
	</form>
</div>
