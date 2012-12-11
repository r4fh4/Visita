<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?=$website_name . (isset($complement_title) ? " - " . $complement_title : "" )?></title>
		<?if( isset($meta_description) ){?>
		<meta name="description" content="<?=$meta_description?>" />
		<?}?>		
		<link href="<?=$furniture_directory;?>css/global.css" type="text/css" rel="stylesheet" />
		<link href="<?=$furniture_directory;?>css/ThickBox.css" type="text/css" media="screen" rel="stylesheet" />
		<link href="<?=$furniture_directory;?>css/jquery.lightbox-0.5.css" type="text/css" media="screen" rel="stylesheet" />
		<?=( $css_files ? $css_files : "" )?>
		<script language="javascript" type="text/javascript" src="<?=$furniture_directory;?>js/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="<?=$furniture_directory;?>js/tickbox.js"></script>
		<script language="javascript" type="text/javascript" src="<?=$furniture_directory;?>js/jquery.lightbox-0.5.js"></script>
		<script language="javascript" type="text/javascript" src="<?=$furniture_directory;?>js/global.js"></script>
		<?=( $google_api ? "<script language='javascript' src='http://maps.google.com/maps/api/js?key=AIzaSyBLIVTittcOAbl5V0DZPmwPAKitNw7Tg74&sensor=false'></script>" : "" );?>
		<?=( $js_files ? $js_files : "" );?>
	</head>
	<body>
		<div id="header">
			<a href="<?=$alias;?>">
				<img src='<?=$furniture_directory;?>images/logo.png' >
			</a>
		</div>
		<div id="main">