<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#email").focus(function(){
		var _this = $(this);
		if(_this.val() == 'Email')
			_this.val('');
	}).blur(function(){
		var _this = $(this);
		if(_this.val() == '')
			_this.val('Email');
	});
});
</script>
<h1></h1>
<div id="login-main">
	<?if( $state == "begin" ){?>
	<form name="form" id="form" action="<?=$alias?>redefinir-acesso-enviar" method="post">
		<div class="login">
			<p class="element-hidden"><input type="text" name="email-send" value="" /></p>
			<p>
			<input id="email" type="text" name="email" size="40" maxlength="150" value=""/><br /><br />
			<input type="submit" class="btn-submit" name="ok" value="_" /> 
			</p>
			<?php					
			if( isset( $_SESSION{"error_message"} ) ){
				$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
				echo '<br /><br />';
				echo '<p class="feedback-login">' . $message . '</p>' ;						
				unset( $_SESSION{"error_message"} );
				session_destroy() ;
			}
			?>
		</div>		
	</form>
	<?}
	else if( $state=="change" ){?>
		<form name="form" id="form" action="<?=$alias?>redefinir-acesso-enviar" method="post">
			<div class="login">
				<p class="element-hidden"><input type="text" name="email-send" value="" /></p>
				<input type="hidden" name="email" value="<?=htmlspecialchars(  get_vars("email") )?>" />
				<p>
				<span style='color: #FFF'><b>E-mail do usuário:</b> <?=htmlspecialchars(  get_vars("email") )?></span>
				<br /><br />
				<input id="password" type="password" name="password" size="20" maxlength="20" value=""/>
				<br /><br />
				<input id="re-password" type="password" name="re-password" size="20" maxlength="20" value="" class='form-class' />
				<br /><br />
				<input type="submit" class="btn-submit" name="change" value="_" /> 
				</p>
				<?php					
				if( isset( $_SESSION{"error_message"} ) ){
					$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
					echo '<br /><br />';
					echo '<p class="feedback-login">' . $message . '</p>' ;						
					unset( $_SESSION{"error_message"} );
					session_destroy() ;
				}
				?>
			</div>		
		</form>	
	<?}?>
	<br /><br />
	<div class='default-message'>
		<?=$default_message?>		
	</div>
</div>
