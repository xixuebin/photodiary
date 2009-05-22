<?php

	include "common/objects.php";
	
	// SKIP BEFORE CONFIG.PHP EDITING
	if(!$DB_CONNECTED){
?>
	<script language="javascript">
		document.location.href="admin/install.php";
	</script>
<?php
	}
	
	// CONFIG INFORMATION
	$iud->set_table_str($TBL['config']);
	$iud->set_where_condition(NULL);
	$iud->set_order_condition($FLD['config']['id']." DESC");
	$result_data = $db->db_execute($iud->create_select());
	if(!$result_data){
?>
	<script language="javascript">
		document.location.href="admin/install.php";
	</script>
<?php		
	} else {
		$config_data = mysql_fetch_array($result_data);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo $config_data[$FLD['config']['title']]?> photoDiary</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <!-- Made by Webgriffe | multimedia -->
        <!-- Webgriffe is @ http://www.webgriffe.com/ -->
        <!-- Webgriffe contact: info@webgriffe.com -->
        
        <meta content="" />
        <meta name="keywords" content="" />

        <script type="text/javascript" src="js/swfobject.js"></script>
        <script type="text/javascript" src="js/swfaddress.js"></script>
		<script type="text/javascript">
			var flashvars = {};
			var params = {};
			params.scale = "noscale";
			params.bgcolor = "#222222";
			params.allowfullscreen = "true";
			var attributes = {};
			attributes.id = "flashcontent";
			swfobject.embedSWF("swf/device.swf", "flashcontent", "100%", "100%", "9.0.45", "swf/expressInstall.swf", flashvars, params, attributes);
		</script>
		<style type="text/css">
            html {
                height: 100%;
                overflow: hidden;
            }
            
            #flashcontent {
                height: 100%;
                font-family:Geneva, Arial, Helvetica, sans-serif;
                font-size:12px;
                color:#CCCCCC;
            }
        
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #222222;
            }
        </style>
	</head>
	<body>
		<div id="flashcontent">
			<h1>Please install Flash Player</h1>
			<p>Adobe Flash Player is required to view this site. Click on the following button to install.<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
		</div>
     </body>
</html>
<?php $db->db_close() ?>