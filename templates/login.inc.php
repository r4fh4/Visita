<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#login").focus(function(){
		var _this = $(this);
		if(_this.val() == 'Login')
			_this.val('');
	}).blur(function(){
		var _this = $(this);
		if(_this.val() == '')
			_this.val('Login');
	});
	
	$("#password").focus(function(){
		var _this = $(this);
		if(_this.val() == 'Senha'){
			_this.val('');
		}
	}).blur(function(){
		var _this = $(this);
		if(_this.val() == '')
			_this.val('Senha');
	});
	
});
</script>
<div id="login-main">
	<form name="form" id="form" action="<?=$alias?>authenticate" method="post">
		<div class="login">
			<p class="element-hidden"><input type="text" name="email-send" value="" /></p>
			<input id="login" type="text" name="login" value="Login" />
			<br /><br />
			<input id="password" type="password" name="password" value="Senha" />
			<br /><br />
			<?php					
			if( isset( $_SESSION{"error_message"} ) ){
				$message = trim( htmlspecialchars( (isset($_SESSION{"error_message"}) ? $_SESSION{"error_message"} : null ) ) ) ;
				echo '<p class="feedback-login">' . $message . '</p>' ;						
				unset( $_SESSION{"error_message"} );
				session_destroy() ;
			}
			?>
			<input type="submit" class='btn-submit' value="" />
			<input type="hidden" name="target_redirect" value="<?=htmlspecialchars(get_vars("target_redirect"));?>" />
			<input type='hidden' name='facebook-login' id='facebook-login' value='0' />
			<input type='hidden' name='facebook-name' id='facebook-name' value='' />
			<br /><br />
			<p class='forgot'><a href='<?=$alias;?>redefinir-acesso'>Esqueceu a senha?</a></p>
			<div id='alternative-login'>
				<a href='<?=$alias;?>cadastro/'><input type="button" class="btn-cadastro" name="cadastrar" value="" /></a>
				<!--<div class="fb-login-button" data-width="200" data-max-rows="1" size="large" style="width: 90px; height: 50px"></div>
				<div id="fb-root"></div>
				<script>
				  // Additional JS functions here
				  window.fbAsyncInit = function() {
					FB.init({
					  appId      : '<?/*=FACEBOOK_APP_ID;*/?>', // App ID
					  channelUrl : '//www.lcmconsulting.com.br/visita/login.php', // Channel File
					  status     : true, // check login status
					  cookie     : true, // enable cookies to allow the server to access the session
					  xfbml      : true  // parse XFBML
					});

					FB.getLoginStatus(function(response) {
					if (response.status === 'connected') {
							FB.api('/me', function(response) {
							  $('#facebook-login').val(1);
							  $('#facebook-name').val(response.name);
							  $('#login').val(response.email);
							});
						} else if (response.status === 'not_authorized') {
							alert('Aplicação não autorizada pelo usuário');
						} else {
							FB.Event.subscribe('auth.login', function() {
								FB.api('/me', function(response) {
								  $('#facebook-login').val(1);
								  $('#facebook-name').val(response.name);
								  $('#login').val(response.email);
								  $('#form').submit();
								});
							});
						}
						$('div.fb-login-button').click();
					});

				  };

				  // Load the SDK Asynchronously
				  (function(d){
					 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
					 if (d.getElementById(id)) {return;}
					 js = d.createElement('script'); js.id = id; js.async = true;
					 js.src = "//connect.facebook.net/pt_BR/all.js";
					 ref.parentNode.insertBefore(js, ref);
				   }(document));
				</script>				
			</div> -->
			<br class='clean' />
		</div>
	</form>
</div>
