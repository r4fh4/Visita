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
		"/[�����]/"	=>	"A" ,
		"/[�����]/"	=>	"a" ,
		"/[����]/"	=>	"E" ,
		"/[����]/"	=>	"e" ,
		"/[����]/"	=>	"I" ,
		"/[����]/"	=>	"i" ,
		"/[�����]/"	=>	"O" ,
		"/[�����]/"	=>	"o" ,
		"/[����]/"	=>	"U" ,
		"/[����]/"	=>	"u" ,
		"/�/"		=>	"c" ,
		"/�/"		=>	 "C", 
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
			window.location.href = '<? print $page ?>' ;
		</script>
		<?
	
	}
	else{ // parent document ou por ajax
		?>
		<!--<script language="javascript" type="text/javascript" src="furniture/js/jquery.js"></script>-->
		<script language="javascript" type="text/javascript">			
			/*$.ajax({
			  type: "GET" , 
			  url: "<?=$page?>" ,
			  cache: false,
			  success: function(data){
					window.parent.location.href = '<?=$page?>' ;
				}
			});*/
			window.parent.location.href = '<? print $page ?>'  ;
		</script>
		<?	
	}
	exit() ;
	
}

function redir ( $url , $code = 302 , $use_html = false ) {
	global $html_301_redirect_note, $html_302_redirect_note, $html_404_redirect_note ;
	if ( is_array ( $url ) ) {
		$url = $url[0] ;
	}

	header ( "Status: " . $code ) ;
	if ( $use_html ) {
		switch($code){
			case 301:
				print str_replace("{location}" , $url , $html_301_redirect_note ) ;
			break;
			case 404:
				print str_replace("{location}" , $url , $html_404_redirect_note ) ;
			break;
			default:
				print str_replace("{location}" , $url , $html_302_redirect_note ) ;
			break;
		}
	}
	else {
		header ( "Location: " . $url , true , $code ) ;
	}

	exit ;
}


function format_bytes( $size ) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2). $units[$i] ;
}

function default_search( $table , $where = array() , $group = "" , $order = NULL , $fields = NULL, $noLimit = false ){
	global $connection , $results_per_page ;
	
	$table = mysql_real_escape_string( $table ) ;
	if( $order ){
		$order = mysql_real_escape_string( $order ) ;
	}
	if( $group ){
		$group = mysql_real_escape_string( $group ) ;
	}
	if( $fields ){
		$fields = mysql_real_escape_string( $fields ) ;
	}
	
	
	if ( !isset( $results_per_page ) || !$results_per_page ){
		$results_per_page = 20 ;
	}

	$sql = "select * from $table where " ;

	$where = implode( " and " , $where ) ;

	$sql = "select count(*) as c from $table where $where ";
	if ( strlen( $group ) ){
		$sql = "select count(distinct $group) as c from $table where $where ";
	}

	$r = $connection->execute( $sql , true ) ;
	$records = $r[0]{"c"} ;

	$sr = get_vars( "sr" ) ;
	$sr = $sr && is_numeric( $sr ) ? $sr : 1 ;
	if ( $sr > $records ){
		$sr = 1 ;
	}

	if ( $records ){
		$total_pages = ceil( $records / $results_per_page ) ;
		$page = ceil( $sr / $results_per_page ) ;
	}
	else{
		$page = 1 ;
		$total_pages = 1 ;
	}

	if ( $page > $total_pages ){
		$page = $total_pages ;
	}

	if ( isset( $order ) ){
		if ( is_array( $order ) ){
			$order = implode( ", " , $order ) ;
		}
		$order = "order by $order " ;
	}
	else{
		$order = "" ;
	}

	if ( strlen( $group ) ){
		$group = " group by $group " ;
	}

	if( !isset( $fields ) ){
		$fields = "*" ;
	}
	
	$limit = $noLimit ? '' : "limit " . ( $sr - 1 ) . " , " . $results_per_page;

	$sql = "select $fields from $table where $where $group $order $limit " ;
	//print $sql ;
	$records = $connection->execute( $sql, true ) ;

	return array( $r , $records , $page , $total_pages ) ;
}

function render_paginate( $page , $total_pages , $url , $results_per_page = NULL , $extra = "" , $first_page = false , $last_page = false, $div_reload = false ){
	
	if ( $total_pages <= 1 ){
		return "" ;
	}

	if ( $results_per_page == NULL ){
		global $default_results_per_page ;
		$results_per_page = $default_results_per_page ;
	}

	global $results_per_page ;
	$paginate_num_itens = $results_per_page ;
	if ( $paginate_num_itens == NULL ){
		$paginate_num_itens = 10 ;
	}

	$start = $page - $paginate_num_itens / 2 ;
	$end = $page + $paginate_num_itens / 2 ;

	if ( $start < 1 ){
		$start = 1 ;
		$end = $start + $paginate_num_itens ;
	}

	if ( $end > $total_pages ){
		$end = $total_pages + 1 ;
		$start = $end - $paginate_num_itens ;
	}

	if ( $start < 1 ){
		$start = 1 ;
	}

	$elem = Array() ;

	if ( $page > 1 ){
		if ( $first_page ){
			$my_url = set_url( $url , Array( "sr" => 1 ) ) ;
			if( $div_reload ){
				$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> " .utf8_encode("Primeira p�gina") ." </a>" ;
			}
			else{
				$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> Primeira p�gina </a>" ;
			}
		}

		$my_url = set_url( $url , Array( "sr" => ( $page - 2 ) * $results_per_page + 1 ) ) ;
		if( $div_reload ){
			$elem[] = "<a href=\"javascript:reload_paginate('" . htmlspecialchars( $my_url ) . "');void(0);\"> anterior </a>" ;
		}
		else{
			$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> anterior </a>" ;
		}
	}

	for ( $i_index = $start ; $i_index < $end ; $i_index++ ){
		if ( $i_index != $page ){
			$my_url = set_url( $url , Array( "sr" => ( $i_index - 1 ) * $results_per_page + 1 ) ) ;
			if( $div_reload ){
				$elem[] = "<a href=\"javascript:reload_paginate('" . htmlspecialchars( $my_url ) . "');void(0);\">" . $i_index . "</a>" ;
			}
			else{
				$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\">" . $i_index . "</a>" ;
			}
		}
		else{
			$elem[] = "<b>$i_index</b>" ;
		}
	}

	if ( $page < $total_pages ){
		$my_url = set_url( $url , Array( "sr" => $page * $results_per_page + 1 ) ) ;
		if( $div_reload ){
			$elem[] = "<a href=\"javascript:reload_paginate('" . htmlspecialchars( $my_url ) . "');void(0);\"> " .utf8_encode("pr�ximo") ." </a>" ;
		}
		else{
			$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> pr�ximo </a>" ;
		}

		if ( $last_page ){
			$my_url = set_url( $url , Array( "sr" => ( $total_pages - 1 ) * $results_per_page + 1 ) ) ;
			if( $div_reload ){
				$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> " .utf8_encode("�ltima p�gina") ." </a>" ;
			}
			else{
				$elem[] = "<a href=\"" . htmlspecialchars( $my_url ) . "\"> �ltima p�gina </a>" ;
			}
			
		}
	}

	if ( $extra === false ){
		return implode( " " , $elem ) ;
	}
	return "<p" . $extra . ">" . implode( " " , $elem ) . "</p>" ;
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
			/* verificar se $url j� tem query_string */
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

/* recebe uma URL e decompoe a query string em um hash */
function parse_query_string( $url ){
	$tmp = array() ;
	if ( strlen( $url ) < 8192 ){
		if ( preg_match( "/^(.*?)\?(.*?)$/" , $url , $matches ) ){
			$pairs = explode( "&" , array_pop( $matches ) ) ;
			$url = array_pop( $matches ) ;
			foreach( $pairs as $pair ){
				if ( strlen( $pair ) < 8192 ){
					if ( strpos( $pair , "=" ) !== false ){
						list( $key , $value ) = explode( "=" , $pair ) ;
						$tmp{ urldecode( $key ) } = urldecode( $value ) ;
					}
					else{
						$tmp{ urldecode( $pair ) } = NULL ;
					}
				}
			}
		}
	}

	return array( $url , $tmp ) ;
}


if ( !function_exists( 'gui_render_select' ) ){
	function gui_render_select( $name , $list , $selected_value = NULL , $blank = true , $extra = "" ){
		$name = htmlspecialchars( $name ) ;

		$output = <<<_EOF_
<select name="{$name}"{$extra}>

_EOF_;

		if ( $blank ){
			if ( is_string( $blank ) ){
				$blank = htmlspecialchars( $blank ) ;

				$output .= <<<_EOF_
<option value="-">$blank</option>

_EOF_;
			}
		}

		if ( is_array( $list ) && count( $list ) ){
			foreach( $list as $key => $value ){
				$selected = "" ;

				if ( $selected_value !== NULL && $selected_value !== false ){
					if( ( is_array($selected_value) && in_array( $key, $selected_value ) ) || ( $key == $selected_value ) ){					
						$selected = " selected" ;
					}
				}

				$value = htmlspecialchars( $value ) ;
				$key = htmlspecialchars( $key ) ;

				$output .= <<<_EOF_
<option{$selected} value="{$key}">{$value}</option>

_EOF_;
			}
		}

		$output .= <<<_EOF_
</select>

_EOF_;
		return $output ;
	}
}

function check_email( $s ){
	if ( preg_match( "/^[a-z0-9-_][^@,\s]*?@((?:[^@,\.\s]+?\.)+[^@,\.\s]+$)/is" , $s , $r ) ){
		return true ;
	}
	return false ;
}

function changeBackground( $value, $change=null ){
	if($change || $value >= 6){
		switch($value) {
			case $value < 4:
				return 'backRed'; break;
			case $value >= 6:
				return 'backBlue'; break;
			default: 
				return 'backYellow'; break;
		}
	}
	return 'backWhite';
}

function show_message( $message, $status = true ) {
	
	if( $status ){
		$message = '<p class="feedback-form">' . $message . '</p>' ;
	}
	else{
		$message = '<p class="feedback-form-fail">' . $message . '</p>' ;
	}
	
	$_SESSION{"form_message" } = $message ;
}

function show_message_html( $message, $status = true ) {
	
	if( $status ){
		echo '<p style="font:11px Verdana;border:1px solid #3B5627;background-color:#C2E8B4;color:#3B5627;padding:5px;font-weight:bold;">' . $message . '</p>' ;
	}
	else{
		echo '<p style="font:11px Verdana;border:1px solid #A02E2E;background-color:#FCA4A4;color:#A02E2E;padding:5px;font-weight:bold;">' . $message . '</p>' ;
	}
	
}
function convert_data( $data = false, $full = false ){

	if( $data ){
		if( $full ){
			return date("d/m/Y H:i", htmlspecialchars( strtotime( $data ) ) ) ;
		}
		else{
			return date("d/m/Y", htmlspecialchars( strtotime( $data ) ) ) ;
		}
	}
	return false ;
}

function limit_text( $text, $limit_lenght = 120, $prefix = " ..." ){
	
	$current_lenght = strlen( $text ) ;
	if( $current_lenght > $limit_lenght ){
		$text = substr( $text , 0, $limit_lenght ) . $prefix ;
		return $text ;
	}
	
	return $text ;	
}

function list_uf( $uf = false, $regiao = false ){
	
	global $connection ;
	
	$where = "" ;
	if( $uf ){
		$where = "where id_uf = " . mysql_real_escape_string( $uf ) ;
	}
	if( $regiao ){
		$where = "where id_regiao = " . mysql_real_escape_string( $regiao ) ;
	}
	
	$sql = sprintf( "select  * from tb_uf " . $where . " order by ds_uf asc" ) ;
	$results = $connection->execute( $sql, true ) ;
	foreach( $results as $item ){
		$uf_item[ $item{"id_uf"} ] = array( "ds_uf" => $item{"ds_uf"}, "cd_uf" => $item{"cd_uf"}, "id_regiao" => $item{"id_regiao"} ) ;		
	}
	return $uf_item ;	
}


function list_cidades( $cidade = false, $uf = false, $regiao = false ){
	
	global $connection ;
	
	$where = "" ;
	if( $uf ){
		$where = " where id_uf = " .  mysql_real_escape_string( $uf ) ;
	}
	if( $regiao ){
		$where = " where id_regiao = " .  mysql_real_escape_string( $regiao ) ;
	}
	if( $cidade ){
		$where = " where cd_ibge = " .  mysql_real_escape_string( $cidade ) ;
	}
	
	$sql = sprintf( "select sql_cache  * from tb_cidades " . $where . " order by nm_cidade asc" ) ;
	$results = $connection->execute( $sql, true ) ;
	foreach( $results as $item ){		
		$cidade_item[ $item{"cd_ibge"} ] = array( "nm_cidade" => $item{"nm_cidade"}, "nm_cidade_padrao" => $item{"nm_cidade_padrao"}, "id_uf" => $item{"id_uf"}, "id_regiao" => $item{"id_regiao"}, "capital" => $item{"capital"} ) ;		
	}
	
	return $cidade_item ;	
}

function build_map( $content ){

	$map_box = '<div id="DIV" class="box-map"><script type="text/javascript">buildMap( \'ADDRESS\' , \'DIV\' ) ;</script></div>' ;
	preg_match_all( "/\{MAP\}(.*)\{MAP\}/", $content, $matches ) ;	
	$i =0 ;
	foreach( $matches[1] as $itens ){		
		$content = str_replace( "{MAP}" . $itens . "{MAP}", str_replace( "ADDRESS", clear_content( html_entity_decode( $itens ), true ), str_replace( "DIV", $i . "-map", $map_box ) ) , $content ) ;
		$i++ ;
	}
	return $content ;
}

function set_break_page( $content , $print = false ){
	
	$breakpage = "<br />" ;
	if( $print == true ){
		$breakpage = "<pagebreak />" ;
	}	
	return str_replace( "{BREAKPAGE}", $breakpage , $content ) ;
	
}

function send_email($nome,$email,$assunto,$msg,$dest){
		$mail = new PHPMailer() ;
		
        $mail->IsSMTP(); // Define que a mensagem ser� SMTP
        $mail->Host = 'mail.lcmconsulting.com.br'; // Endere�o do servidor SMTP
        $mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
        $mail->Username = 'contato@lcmconsulting.com.br'; // Usu�rio do servidor SMTP
        $mail->Password = 'c0nt@t0'; // Senha do servidor SMTP
		$mail->IsHTML(true);
      
        $mail->From = $email; // Seu e-mail
        $mail->FromName = $nome; // Seu nome
		$mail->AddAddress($dest);
		
        $mail->Subject  = $assunto; // Assunto da mensagem
        $mail->Body = $msg;// Conteudo da mensagem a ser enviada
		
		return $mail->Send() ;
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

function indicadores_values( $type, $value ){
	
	switch( $type ){
		case "I" : return number_format( $value, 0, "", "." ) ; break ;
		case "P" : return number_format( $value, 2, ",", "." ) . " %" ; break ;
		case "DD" : return number_format( $value, 2, ",", "." ) . " p/Km<sup>2</sup>" ; break ;
		case "D" : return number_format( $value, 1, ",", "." ) ; break ;
		case "M" : return "R$ " . number_format( $value, 2 , ",", "." ) ; break ;
		case "N" : return "R$ " . number_format( $value, 2 , ",", "." ) ; break ;
		default: return $value ; break ;
	}
	
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

// write css header
function write_js_header( $list = null ){
	global $furniture_directory ;
	if( $list ){
		foreach( $list as $item ){
			$js_list[] = '<script src="' . $furniture_directory . 'js/' . $item . '.js" language="javascript"></script>' . chr(13) ; 
		}
		
		return implode( "" , $js_list ) ;
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