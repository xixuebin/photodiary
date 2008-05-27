<?php

	include "common/objects.php";
	
	$shotID = $_GET['shotID'];
	
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config_data[$FLD['config']['title']]?> photoDiary</title>

<!-- Made by Webgriffe® | multimedia -->
<!-- Webgriffe is @ http://www.webgriffe.com/ -->
<!-- Webgriffe contact: info@webgriffe.com -->

<LINK REL="SHORTCUT ICON" HREF="http://www.webgriffe.com/favicon.ico">
<meta name="copyright" content="Webgriffe&reg; | multimedia">
<meta name="keywords" content="photoDiary, photography, fotografia, webgriffe, blog, photo, photoblog, weblog, pubblicazione, publish, diary, daily, foto, album, diario, fotografico, commenti, comments, gallery, galleria, portfolio, showcase, mostra">
<meta name="description" content="Il tuo diario fotografico online. Your photo diary online ">
<meta name="author" content="Webgriffe&reg; | multimedia - www.webgriffe.com">
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	padding:0;
}
-->
</style>
</head>
<body bgcolor="#666666">
<script language="javascript">
AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','100%','height','100%','src','swf/device','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','swf/device', 'scale', 'noscale', 'salign', 'lt', 'flashVars', '&shotID=<?php echo $shotID ?>' );
</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" align="middle">
	<param name="movie" value="swf/device.swf" />
	<param name="flashVars" value="&shotID=<?php echo $shotID ?>" />
	<param name="quality" value="high" />
	<param name="scale" value="noscale" />
	<param name="salign" value="lt" />
	<embed src="swf/device.swf" quality="high" scale="noscale" flashVars="&shotID=<?php echo $shotID ?>" salign="lt" width="100%" height="100%" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object></noscript>
</body>
</html>
<?php $db->db_close() ?>