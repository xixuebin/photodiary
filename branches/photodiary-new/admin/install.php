<?php 

	if (isset($_GET['step'])){
		$step = $_GET['step'];
	} else {
		$step = 1;
	}
	
	if (isset($_GET['lng'])){
		$LNG = $_GET['lng'];
	} else {
		$LNG = "ITA";
	}
	
	include "../common/language_".$LNG.".php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Webgriffe&reg; photoDiary&copy; - SETUP</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/header.jpg" alt="Webgriffe&reg; photoDiary&copy;" width="760" height="200"></td>
	</tr>
	<tr>
		<td background="images/bgwide.jpg">
<table width="100%" border="0" cellspacing="40" cellpadding="0">
	<tr>
		<td width="70%" valign="top" class="TXTtitle">
				<p>
				<?php
				if ($step<4){
					echo "photoDiary setup. Step ".$step."/3";
				} else {
					echo $LNG_SETUPCOMPLETE;
				}
				?>
				</p>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>?lng=<?php echo $LNG ?>&step=<?php echo $step+1 ?>">
					<tr>
						<td class="TXTgeneric">
							<p>
<?php
	switch ($step){
		case 1:
?>
			<table width="80%" border="0" align="center" cellpadding="0" cellspacing="5" class="color0">
				<tr>
					<td width="50%">&nbsp;</td>
					<td width="50%">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%" align="right" class="TXTform"><?php echo $LNG_SELECTYOURLANGUAGE ?></td>
						<td width="50%"><select name="menulanguage" class="TXTgeneric" onChange="MM_jumpMenu('parent',this,0)">
							<?php 
								$selENG = $selITA = "";
								if($LNG=="ENG"){ $selENG = "selected"; }
								if($LNG=="ITA"){ $selITA = "selected"; }
							?>
							<option value="<?php echo $_SERVER['PHP_SELF']."?lng=ENG" ?>" <?php echo $selENG ?>>English</option>
							<option value="<?php echo $_SERVER['PHP_SELF']."?lng=ITA" ?>" <?php echo $selITA ?>>Italiano</option>
							</select></td>
				</tr>
				<tr>
					<td width="50%" class="TXTform">&nbsp;</td>
					<td width="50%">&nbsp;</td>
				</tr>
			</table>
<?php
			break;
		case 2:
			echo $LNG_CONFIG_TXT;
			break;
		case 3:
			include "../common/objects.php";
			if(!$DB_CONNECTED){
				echo $LNG_CONFIG_ERROR;
			} else {
				$iud->set_table_str($TBL['config']);
				$iud->set_where_condition(NULL);
				$iud->set_order_condition(NULL);
				$result_data = $db->db_execute($iud->create_select());
				if($result_data>0){
					echo $LNG_EXIST_ERROR;
				} else {
					echo $LNG_CREATE_TABLES;
				}
				$db->db_close();
			}
			break;
		case 4:
			include "../common/objects.php";
			$myQuery1 = "CREATE TABLE photo_comments (id_comment int(11) NOT NULL auto_increment, dt_date date NOT NULL default '0000-00-00', tm_time time NOT NULL default '00:00:00', tx_name varchar(128) NOT NULL default '',tx_email varchar(128) NOT NULL default '', tx_url varchar(255) NOT NULL default '',tx_text longtext NOT NULL default '', id_ref int(11) NOT NULL default 0, nm_x int(11) NOT NULL default 0, nm_y int(11) NOT NULL default 0, nm_angle int(11) NOT NULL default 0, PRIMARY KEY (id_comment)) TYPE=InnoDB AUTO_INCREMENT=2";
			$myQuery2 = "INSERT INTO photo_comments (id_comment, dt_date, tm_time, tx_name, tx_email, tx_url, tx_text, id_ref, nm_x, nm_y, nm_angle) VALUES (1, '".date('Y-m-d')."', '".date('H:i:s')."', 'Webgriffe | multimedia', 'info@webgriffe.com', 'www.webgriffe.com', 'Buon divertimento con photoDiary.\r\n\r\n*webgriffe', 1, 646, 258, 0)";
			$myQuery3 = "CREATE TABLE photo_config (id_config int(11) NOT NULL auto_increment, tx_title varchar(255) NOT NULL default '', tx_email varchar(128) NOT NULL default '', tx_username varchar(128) NOT NULL default '', tx_password varchar(128) NOT NULL default '', tx_language varchar(8) NOT NULL default '', PRIMARY KEY  (id_config)) TYPE=InnoDB AUTO_INCREMENT=1";
			$myQuery4 = "CREATE TABLE photo_posts (id_post int(11) NOT NULL auto_increment, dt_date date NOT NULL default '0000-00-00', tx_text longtext NOT NULL default '', fl_visible tinyint(1) NOT NULL default 1, PRIMARY KEY  (id_post)) TYPE=InnoDB AUTO_INCREMENT=2";
			$myQuery5 = "INSERT INTO photo_posts (id_post, dt_date, tx_text, fl_visible) VALUES (1, '".date('Y-m-d')."', 'Benvenuto in photoDiary!', 1)";
			
			$db_link = $db->get_db_link();
			$result1 = mysql_query($myQuery1, $db_link);
			$result2 = mysql_query($myQuery2, $db_link);
			$result3 = mysql_query($myQuery3, $db_link);
			$result4 = mysql_query($myQuery4, $db_link);
			$result5 = mysql_query($myQuery5, $db_link);
			
			$db->db_close();
			
			echo $LNG_FILL_FORM;
			?>
			<table width="80%" border="0" align="center" cellpadding="0" cellspacing="5">
	<tr>
		<td>&nbsp;</td>
		<td width="10"><input type="hidden" name="<?php echo $FLD['config']['lng'] ?>" id="<?php echo $FLD['config']['lng'] ?>" value="<?php echo $LNG ?>"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_TITLE ?></td>
		<td width="10"><input name="<?php echo $FLD['config']['title'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['title'] ?>" size="50"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_EMAIL ?></td>
		<td width="10"><input name="<?php echo $FLD['config']['email'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['email'] ?>" size="50"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_USERNAME ?></td>
		<td width="10"><input name="<?php echo $FLD['config']['username'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['username'] ?>" size="50"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_PASSWORD ?></td>
		<td width="10"><input name="<?php echo $FLD['config']['password'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['password'] ?>" size="50"></td>
	</tr>
</table>
			</p><p><?php echo $LNG_REMINDER ?>

			<?php
			break;
		case 5:
			include "../common/objects.php";
			$arrIn = $_POST;
			$arrIn[0] = $TBL['config']."|";
			$iud->set_form_data($arrIn,$FLD['config']);
			$iud->set_where_condition(NULL);
			$db->db_execute($iud->create_insert());
			$iud->get_pd_host();
			$a = explode("admin","http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']);
			echo $LNG_REGARDS1.", <b>".$_POST[$FLD['config']['title']]." photoDiary</b> ".$LNG_REGARDS2." (<a href='".$a[0]."'>".$LNG_REGARDS3."</a>).<br>".$LNG_REGARDS4.".";
			$db->db_close();
			break;
	}
?>
							</p>
						<?php if($step<5){ ?>	
							<p>&nbsp;</p>
							<p align="center">
								<input name="Submit" type="submit" class="TXTgeneric" value="<?php echo $LNG_CONTINUA ?> &raquo;">
							</p>
						<?php } ?></td>
					</tr>
					</form>
			</table></td>
		</tr>
</table>			
		</td>
	</tr>
	<tr>
		<td height="63" align="center" background="images/footer.jpg" class="footer">photoDiary&copy; &egrave; un prodotto <a href="http://www.webgriffe.com" target="_blank">Webgriffe&reg; | multimedia</a></td>
	</tr>
</table>
</body>
</html>
