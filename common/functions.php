<?php
function print_pre( $data ){	
	echo "<pre>" ;
	print_r( $data ) ;
	echo "</pre>" ;	
}

function clear_content( $word ,$space = false ){
	
	if( $space ){
		$space = " " ;
	}
	else{
		$space = "" ;
	}
	$word = preg_replace( "/['\"=\/\?<>\.#%&;:]/", $space, trim($word) ) ;
	$word = str_replace( " ", $space, $word ) ;
	return $word ;
}

function check_invalid_input( $word ){
	
	if( preg_match( "/['\"=\/\?<>\.#%&;!)(}{]/", $word , $r ) ){		
		return false ;
	}	
	return true ;	
}

function normalize_text( $text, $remove_chars = false ){

	$text = strtolower( $text ) ;

	$list_normalize = array(	
		"/[ÂÀÁÄÃ]/"	=>	"A" ,
		"/[âãàáä]/"	=>	"a" ,
		"/[ÊÈÉË]/"	=>	"E" ,
		"/[êèéë]/"	=>	"e" ,
		"/[ÎÍÌÏ]/"	=>	"I" ,
		"/[îíìï]/"	=>	"i" ,
		"/[ÔÕÒÓÖ]/"	=>	"O" ,
		"/[ôõòóö]/"	=>	"o" ,
		"/[ÛÙÚÜ]/"	=>	"U" ,
		"/[ûúùü]/"	=>	"u" ,
		"/ç/"		=>	"c" ,
		"/Ç/"		=>	 "C", 
		"/ /"		=> "-" ,
	);
	if( $remove_chars ){
		$list_normalize{"/['\"=\/\?<>\.#%&;!)(}{]/"} = "" ;
	}
	return preg_replace(array_keys( $list_normalize ), array_values( $list_normalize), $text );	
	
}

function get_vars( $item = null, $strip_tags = true, $trim = true ){
	
	$params = null ;
	if( $item ) {
		if( $strip_tags ){
			$params = strip_tags( $_POST{$item} ? $_POST{$item} : ( $_GET{$item} ? $_GET{$item} : false ) ) ;
		}
		else{
			$params = $_POST{$item} ? $_POST{$item} : ( $_GET{$item} ? $_GET{$item} : false ) ;
		}
		
		if( $trim ){
			return trim( $params ) ; 
		}
		else{
			return $params ;
		}
	}

}

function redir_page( $page, $parent = false ){
	
	if( !$parent ){
	?>
	<script language="javascript">
		window.location = '<? print $page ?>' ;
	</script>
	<?
	}
	else{
	?>
	<script language="javascript">
		window.parent.location = '<? print $page ?>'  ;
	</script>
	<?	
	}
	exit() ;
	
}


function format_bytes( $size ) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2). $units[$i] ;
}

function set_url( $url , $params = array() ){
	if ( !is_array( $params ) ){
		$params = array() ;
	}

	$tmp = array() ;

	list( $url , $tmp_params ) = parse_query_string( $url ) ;
	$params = array_merge( $tmp_params , $params ) ;

	$i_limit = count( $params ) ;
	if ( $i_limit ){
		reset( $params ) ;
		while( list( $key , $value ) = each( $params ) ){
			if ( isset( $value ) ){
				if ( is_numeric( $value ) ){
					$value = (string)$value ;
				}

				if ( is_string( $value ) ){
					$tmp[] = rawurlencode( $key ) . "=" . rawurlencode( stripslashes( $value ) ) ;
				}

				if ( is_array( $value ) ){
					foreach( $value as $v ){
						$tmp[] = rawurlencode( $key ) . rawurlencode( "[]" ) . "=" . rawurlencode( stripslashes( $v ) ) ;
					}
				}
			}
		}

		if ( count( $tmp ) ){
			/* verificar se $url já tem query_string */
			if ( strpos( $url , "?" ) !== false ){
				$url .= "&" . implode( "&" , $tmp ) ;
			}
			else{
				$url .= "?" . implode( "&" , $tmp ) ;
			}
		}
	}
	return $url ;
}

function check_email( $s ){
	if ( preg_match( "/^[a-z0-9-_][^@,\s]*?@((?:[^@,\.\s]+?\.)+[^@,\.\s]+$)/is" , $s , $r ) ){
		return true ;
	}
	return false ;
}

function rebuilt_path( $directory, $levels ){
		$i = 0 ;
		$levels = $levels - 2 ;
		while( $i< $levels ){
				$path .= "../" ;
			$i++ ;
		}		
		return $path . $directory ;
}

// retorno em minutos 
function diff_datetime( $datetime1 , $datetime2 ){

	$datetime2	= strtotime( $datetime2 ) ;
	$datetime1	= strtotime( $datetime1 ) ;
	return  round( abs( $datetime2 - $datetime1 ) / 60,2 ) ;
	
}

function timeDiff($firstTime,$lastTime)
{

	// convert to unix timestamps
	$firstTime	= strtotime( $firstTime ) ;
	$lastTime	= strtotime( $lastTime ) ;

	// perform subtraction to get the difference (in seconds) between times
	$timeDiff = round(( $lastTime - $firstTime ) / 60) ;

	// return the difference
	return $timeDiff ;
}

// write css header
function write_css_header( $list = null, $media = null ){
	global $furniture_directory ;
	if( $list ){
		foreach( $list as $item ){
			$css_list[] = '<link href="' . $furniture_directory . 'css/' . $item . '.css" type="text/css" rel="stylesheet" media="' . ( $media ? $media : "screen" ) . '" />' . chr(13) ; 
		}
		
		return implode( "" , $css_list ) ;
	}
	
}

function verify_referer_ajax(){

	global $base_url_site ;
	
	$referer_ajax = $_SERVER["HTTP_REFERER"] ;
	if( preg_match( '/^' . ereg_replace ( '/' , '\/' , $base_url_site ) . '/', $referer_ajax, $matches ) ){
		return true ;
	}
	
	return false ;	
}

function send_email($nome, $email, $assunto, $msg, $dest){
		
		global $mail_server, $mail_website, $mail_pass_server ;
		
		$mail = new PHPMailer() ;
		
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = $mail_server; // Endereço do servidor SMTP
        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $mail->Username = $mail_website; // Usuário do servidor SMTP
        $mail->Password = $mail_pass_server; // Senha do servidor SMTP
		$mail->IsHTML(true);
      
        $mail->From = $email; // Seu e-mail
        $mail->FromName = $nome; // Seu nome
		$mail->AddAddress($dest);
		
        $mail->Subject  = $assunto; // Assunto da mensagem
        $mail->Body = $msg;// Conteudo da mensagem a ser enviada
		
		return $mail->Send() ;
}

// write js header
function write_js_header( $list = null ){
	global $furniture_directory ;
	if( $list ){
		foreach( $list as $item ){
			$js_list[] = '<script src="' . $furniture_directory . 'js/' . $item . '.js" language="javascript"></script>' . chr(13) ; 
		}
		
		return implode( "" , $js_list ) ;
	}
	
}

function create_unique_code(){
	$code = '';
	$chr = array('#','$','@','*','(',')','-','+','&','%','!','?','^','~','/','|');
	$key = date('dmYHis');
	$chr = shuffle($chr);
	
	for($i=0;$i<strlen($key)-1;$i++) {
		$code .= dechex(ord($key[$i]) + ord($chr[$i])).chr(rand(104,122));
	}
	
	return $code;
}

?>