<?php
	
	$act = $_GET['act'];
	$background = "wide";
	$conf_state = 0;
	
	session_start();
	
	if($act=="logout"){ //LOGOUT
		session_destroy();
		header("Location:index.php"); 
		exit;
	}
	
	include "../common/objects.php";
	
	// UPDATE CONFIG INFORMATION
	if($act=="doconfig" && $_SESSION[$SESSION_ADMIN]){
		$arrIn = $_POST;
		$arrIn[0] = $TBL['config']."|";
		$arrIn[$FLD['config']['lng']] = $_POST["menulanguage"];
		$iud->set_form_data($arrIn,$FLD['config']);
		$iud->set_where_condition($FLD['config']['id']." = ".$arrIn[$FLD['config']['id']]);
		$db->db_execute($iud->create_update());
		$conf_state = 1;
		$act = "config";
	}
	
	// GET CONFIG INFORMATION
	$iud->set_table_str($TBL['config']);
	$iud->set_where_condition(NULL);
	$iud->set_order_condition($FLD['config']['id']." DESC");
	$result_data = $db->db_execute($iud->create_select());
	$config_data = mysql_fetch_array($result_data);
	
	
	
	if($act== "login" && $_POST['user'] && $_POST['pass'] && $_POST['login']){ //LOGIN
		$iud->set_table_str($TBL['config']);
		$iud->set_where_condition($FLD['config']['username']." = '".$_POST['user']."' AND ".$FLD['config']['password']." = '".$_POST['pass']."' AND ".$FLD['config']['id']." = ".$config_data[$FLD['config']['id']] );
		$iud->set_order_condition(NULL);
		$result_data = $db->db_execute($iud->create_select());
		session_register($SESSION_ADMIN);
		if(mysql_num_rows($result_data)>0){
			$data = mysql_fetch_array($result_data);
			$_SESSION[$SESSION_ADMIN] =  genKey(10);
			$act="";
		} else{
			$_SESSION[$SESSION_ADMIN] = "";
		}
	}
	
	$LNG = $config_data[$FLD['config']['lng']];
	if(!LNG){
		$LNG = "ITA";
	}
	include "../common/language_".$LNG.".php";

	
	if(!$_SESSION[$SESSION_ADMIN]){
		$background = "wide";
	} else {
		$background = "";
	}
	
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config_data[$FLD['config']['title']]?> photoDiary</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript" src="js/calendar.js" type="text/javascript"></script>
<script language="javaScript" src="js/overlib_mini.js" type="text/javascript"></script>
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
		<td background="images/bg<?php echo $background ?>.jpg">
		<table width="100%" border="0" cellspacing="25" cellpadding="0">
			<tr>
				<td width="70%" valign="top" class="TXTtitle"><p><?php echo $config_data[$FLD['config']['title']]?> photoDiary&copy;</p>
					
<?php
	if(!$_SESSION[$SESSION_ADMIN]){
		$background = "wide";

?>					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric"><?php echo $LNG_ADMIN_TXT1 ?></td>
						</tr>
						<tr>
							<td height="140" align="center" class="TXTgeneric">
								<table border="0" cellpadding="0" cellspacing="5">
							<form name="arearis" action="index.php?act=login" method="post">
								<tr>
									<td class="TXTform">Username:</td>
									<td class="TXTform">Password:</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><input name="user" type="text" class="TXTgeneric" id="user"></td>
									<td><input name="pass" type="password" class="TXTgeneric" id="pass"></td>
									<td><input name="login" type="submit" class="TXTgeneric" id="login" value="Log-in &raquo;"></td>
								</tr>
								<tr>
									<td colspan="3" class="TXTgeneric"><a href="index.php?act=forgotpwd"><?php echo $LNG_ADMIN_TXT1_1 ?></a></td>
									</tr>
							</form>
							</table></td>
						</tr>
					</table>
<?php 	
	} else {
		if(!$act){
			$act="archive";
		}
		if($act=="archive"){
?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric"><b><?php echo $LNG_ADMIN_TXT2 ?></b><br><?php echo $LNG_ADMIN_TXT2_1 ?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="TXTgeneric">
<?php
			$iud->set_table_str($TBL['posts']);
			$iud->set_where_condition(NULL);
			$iud->set_order_condition($FLD['posts']['date']." DESC, ".$FLD['posts']['id']." DESC");
			$result_data = $db->db_execute($iud->create_select());
			if(mysql_num_rows($result_data)==0){
				echo $LNG_ADMIN_EMPTY;
			} else {
				while($data = mysql_fetch_array($result_data)){
					// THUMB MANAGER
					if(extension_loaded('gd')){
						$path = "thumb.php?file_path=../shots/".$data[$FLD['posts']['id']].".jpg&destw=80&desth=80";
						$img_param = "";
					} else {
						$img_size= getimagesize("../shots/".$data[$FLD['posts']['id']].".jpg");
						if($img_size[0]>=$img_size[1]){ // horizontal image
							$img_param = "width='80'";
						} else { // vertical image
							$img_param = "height='80'";
						}
						$path = "../shots/".$data[$FLD['posts']['id']].".jpg";
					}
					
?>	
			<table width="90%"  border="0" cellspacing="0" cellpadding="6">
				<tr>
					<td width="80" align="center" valign="top" class="color0"><a href="index.php?act=edit&id=<?php echo $data[$FLD['posts']['id']]?>"><img src="<?php echo $path ?>" alt="<?php echo $LNG_ALT_EDIT ?>" <?php echo $img_param ?> border="0"></a></td>
					<?php
					if($data[$FLD['posts']['visible']]==1){
						$listStyle = "TXTlist";
					} else {
						$listStyle = "TXTlistDisabled";
					}
					?>
					<td valign="top" class="color0 <?php echo$listStyle?>"><?php echo dateFormat($data[$FLD['posts']['date']]) ?><br><a href="index.php?act=edit&id=<?php echo $data[$FLD['posts']['id']]?>"><?php echo trim_post($data[$FLD['posts']['text']]) ?></a></td>
					<td width="1" valign="top">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="1"><a href="index.php?act=comments&id=<?php echo $data[$FLD['posts']['id']]?>"><img src="images/button_comments.gif" alt="<?php echo $LNG_ALT_COMMENTS ?>" width="19" height="18" border="0"></a></td>
								<td width="10">&nbsp;</td>
								<td width="1"><a href="index.php?act=edit&id=<?php echo $data[$FLD['posts']['id']]?>"><img src="images/button_edit.gif" alt="<?php echo $LNG_ALT_EDIT ?>" width="19" height="18" border="0"></a></td>
								<td width="10">&nbsp;</td>
								<td width="1"><a href="index.php?act=delete&id=<?php echo $data[$FLD['posts']['id']]?>"><img src="images/button_delete.gif" alt="<?php echo $LNG_ALT_DELETE ?>" width="19" height="18" border="0"></a></td>
								<td width="10">&nbsp;</td>
								<td width="1"><img src="images/online_<?php echo$data[$FLD['posts']['visible']] ?>.gif" border="0"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="10"></td>
					<td height="10"></td>
					<td height="10"></td>
				</tr>
			</table>
<?php		
				}
			}	
		
?>							</td>
						</tr>
					</table>
<?php
		}
		if($act=="edit" || $act=="new"){
			$id = $_GET['id'];
?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric">
								<?php
									if($act=="new"){
								?>
										<b><?php echo $LNG_ADMIN_TXT3a ?></b><br><?php echo $LNG_ADMIN_TXT3a_1 ?>
								<?php
									} else {
								?>
										<b><?php echo $LNG_ADMIN_TXT3b ?></b><br><?php echo $LNG_ADMIN_TXT3b_1 ?>
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="TXTgeneric">
<?php
			if($id){
				$iud->set_table_str($TBL['posts']);
				$iud->set_where_condition($FLD['posts']['id']." = ".$id);
				$iud->set_order_condition(NULL);
				$result_data = $db->db_execute($iud->create_select());
				$data = mysql_fetch_array($result_data);
			}
		
			if($data[$FLD['posts']['visible']]==1){
	  			$cb_online = "checked";
	  		} else {
	  			$cb_online = "";
	  		}
				
?>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<table width="90%" border="0" cellspacing="8" cellpadding="0">
<form name="postdata" enctype="multipart/form-data" action="index.php?&act=update" method="POST">
<input name="<?php echo $FLD['posts']['id'] ?>" type="hidden" id="<?php echo  $FLD['posts']['id'] ?>" value = "<?php echo  $data[$FLD['posts']['id']] ?>">
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD1 ?></td>
		<td><table  border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><input name="<?php echo $FLD['posts']['date'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['posts']['date'] ?>" value="<?php echo dateFormat($data[$FLD['posts']['date']]) ?>" size="22" readonly="yes"></td>
				<td width="5">&nbsp;</td>
				<td><a href="javascript:void(0)" onClick="show_calendar('postdata.<?php echo $FLD['posts']['date'] ?>','<?php echo intval(date(m)-1) ?>','','<?php echo $LNG_DATE_FORMAT ?>')"><img src="images/ico_calendar.gif" alt="<?php echo $LNG_ADMIN_CALENDAR ?>" width="18" height="18" border="0"></a></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td valign="top" class="TXTform"><br><?php echo $LNG_ADMIN_FIELD2 ?></td>
		<td valign="top">
			<?php if($id){?>
		<table width="100%%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="218"><table border="0" cellpadding="0" cellspacing="1" class="color2">
					<tr>
						<td><table border="0" cellpadding="0" cellspacing="8" class="color1">
								<tr>
								<?php
									if(extension_loaded('gd')){
										$path = "thumb.php?file_path=../shots/".$data[$FLD['posts']['id']].".jpg&destw=200&desth=1000";
									} else {
										$path = "../shots/".$data[$FLD['posts']['id']].".jpg"; 
									}
								
								?>
								
									<td><a href="../shots/<?php echo $data[$FLD['posts']['id']] ?>.jpg" target="_blank" ><img src="<?php echo $path ?>" alt="<?php echo $LNG_ALT_IMGSIZE ?>" border="0" width="200"></a></td>
								</tr>

						</table></td>
					</tr>
				</table></td>
				<td width="15">&nbsp;</td>
				<td valign="top" class="TXTgeneric"><br><?php echo $LNG_ADMIN_IMGNOTE ?></td>
			</tr>
		</table>
			<?php } ?>
			<table width="100%%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="12"></td>
				</tr>
				<tr>
					<td class="TXTgeneric"><input name="uplfile" type="file" class="TXTgeneric" id="uplfile" size="20" >
					<?php if(!$id){ echo "<br><br>".$LNG_ADMIN_IMGNOTE; } ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td valign="top" class="TXTform"><br><?php echo $LNG_ADMIN_FIELD3 ?></td>
		<td><textarea name="<?php echo $FLD['posts']['text'] ?>" cols="40" rows="10" class="TXTgeneric" id="<?php echo $FLD['posts']['text'] ?>"><?php echo $data[$FLD['posts']['text']] ?></textarea></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD4 ?></td>
		<td><input name="<?php echo $FLD['posts']['visible'] ?>" type="checkbox" id="<?php echo $FLD['posts']['visible'] ?>" value="1" <?php echo $cb_online ?>></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="TXTform"><input name="update" type="submit" class="TXTgeneric" id="update" value="<?php echo $LNG_ADMIN_UPDATE?>"></td>
		</tr>
</form>
</table>
</td>
						</tr>
					</table>
<?php
		}
	}
	
	if($act=="comments"){
		$id = $_GET['id'];
?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric">
								<?php
									if($id){
										echo "<b>".$LNG_ADMIN_TXT4."</b><br>".$LNG_ADMIN_TXT4_1;
									} else { // ARCHIVE
										echo "<b>".$LNG_ADMIN_TXT4."</b><br>".$LNG_ADMIN_TXT4_2;
									}
								?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="TXTgeneric">
<?php
			$iud->set_table_str($TBL['comments']);
			if($id){ // ID POST RELATED
				$iud->set_where_condition($FLD['comments']['id_ref']." = ".$id);
			} else { // ARCHIVE
				$iud->set_where_condition(NULL);
			}
			$iud->set_order_condition($FLD['comments']['date']." DESC, ".$FLD['comments']['id']." DESC");
			$result_data = $db->db_execute($iud->create_select());
			if(mysql_num_rows($result_data)==0){
				echo $LNG_ADMIN_EMPTY;
			} else {
				while($data = mysql_fetch_array($result_data)){
?>	
			<table width="90%"  border="0" cellspacing="0" cellpadding="6">
				<tr>
					<td valign="top" class="color0 TXTgeneric">
						<span class="TXTlist"><?php echo dateFormat($data[$FLD['comments']['date']]) ?></span><br>
						<strong><?php echo $data[$FLD['comments']['name']] ?></strong><br>
						<?php echo $data[$FLD['comments']['text']] ?>
					</td>
					<td width="1" valign="top">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="10">&nbsp;</td>
								<td width="1" valign="top">
								<?php if ($data[$FLD['comments']['email']]){ ?>
									<a href="mailto:<?php echo $data[$FLD['comments']['email']]?>"><img src="images/button_email1.gif" alt="<?php echo $LNG_ALT_EMAIL ?>" width="19" height="18" border="0"></a>
								<?php } else { ?>
									<img src="images/button_email0.gif" alt="<?php echo $LNG_ALT_EMAIL ?>" width="19" height="18" border="0">
								<?php } ?>
								</td>
								<td width="10">&nbsp;</td>
								<td width="1" valign="top">
								<?php if($data[$FLD['comments']['url']]){ ?>
									<a href="http://<?php echo $data[$FLD['comments']['url']]?>" target="_blank"><img src="images/button_web1.gif" alt="<?php echo $LNG_ALT_WEBSITE ?>" width="19" height="18" border="0"></a>
								<?php } else { ?>	
									<img src="images/button_web0.gif" alt="<?php echo $LNG_ALT_WEBSITE ?>" width="19" height="18" border="0">
								<?php } ?>								</td>
								<td width="10">&nbsp;</td>
								<td width="1" valign="top">
									<a href="index.php?act=delete&idcomm=<?php echo $data[$FLD['comments']['id']]?>"><img src="images/button_delete.gif" alt="<?php echo $LNG_ALT_DELETE ?>" width="19" height="18" border="0"></a></td>
								</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="10"></td>
					<td height="10"></td>
				</tr>
			</table>
<?php		
				}
			}	
		
?>							</td>
						</tr>
					</table>
<?php
		}
	
	if($act=="update"){ //UPDATE POST
		$imgError = 0;
		$arrIn = $_POST;
		$arrIn[0] = $TBL['posts']."|";
		$id = $arrIn[$FLD['posts']['id']];
		
		if($arrIn[$FLD['posts']['visible']]){
			$arrIn[$FLD['posts']['visible']] = 1;
		} else {
			$arrIn[$FLD['posts']['visible']] = 0;
		}
		
		if(!$arrIn[$FLD['posts']['date']]){
			$arrIn[$FLD['posts']['date']] = date('Y-m-d');
		}
		
		if($id){
			//Update
			$iud->set_form_data($arrIn,$FLD['posts']);
			$iud->set_where_condition($FLD['posts']['id']."=".$id);
			$db->db_execute($iud->create_update());
		} else {
			//Insert
			$iud->set_form_data($arrIn,$FLD['posts']);
			$iud->set_where_condition(NULL);
			$db->db_execute($iud->create_insert());
		}
		
		// IMAGE UPLOAD
		if(!$id){ // new post
			$temp_id = mysql_insert_id();
		} else {  // edited post
			$temp_id = $id;
		}
		$uplfile = $_FILES['uplfile']['tmp_name'];
		if ($uplfile){
			if ($_FILES['uplfile']['type'] == "image/jpg" || $_FILES['uplfile']['type'] == "image/jpeg" || $_FILES['uplfile']['type'] == "image/pjpeg"){
				/* GD LIBRARIES
				$src_img = imagecreatefromjpeg($uplfile);
        		$origw=imagesx($src_img);
        		$origh=imagesy($src_img);
				if($origw/$origh>700/450){
					$new_w = 700;
					$new_h = floor($new_w*$origh/$origw);
				} else {
					$new_h = 450;
					$new_w = floor($new_h*$origw/$origh);
				}
				$dst_img = imagecreatetruecolor($new_w,$new_h);
				imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,$origw,$origh);
				imagejpeg($dst_img, "../shots/".$temp_id.".jpg" );
				*/
				if(copy($uplfile, "../shots/".$temp_id.".jpg")){
					unlink($uplfile);
				} else {
					$imgError = 1;
				}
			} else {
				$imgError = 2;
			}
		}
		// END IMAGE UPLOAD
		
		if($imgError){
			echo "<span class='TXTgeneric'>".$LNG_ADMIN_IMGERROR[$imgError]."</span>";
		} else {
			if($id){
				echo "<span class='TXTgeneric'>".$LNG_ADMIN_UPD_SUCCESS."</span>";
			} else {
				echo "<span class='TXTgeneric'>".$LNG_ADMIN_INS_SUCCESS."</span>";
			}
		}
	}
	
	if($act=="delete"){ 
		$id = $_GET['id'];
		$idcomm = $_GET['idcomm'];
		if($id){ //DELETE POST AND HIS COMMENTS
			$iud->set_table_str($TBL['posts']);
			$iud->set_where_condition($FLD['posts']['id']."=".$id);
			$db->db_execute($iud->create_delete());
			$iud->set_table_str($TBL['comments']);
			$iud->set_where_condition($FLD['comments']['id_ref']."=".$id);
			$db->db_execute($iud->create_delete());
			echo "<span class='TXTgeneric'>".$LNG_ADMIN_DELETE."</span>";
		}
		if($idcomm){ //DELETE COMMENT
			$iud->set_table_str($TBL['comments']);
			$iud->set_where_condition($FLD['comments']['id']."=".$idcomm);
			$db->db_execute($iud->create_delete());
			echo "<span class='TXTgeneric'>".$LNG_ADMIN_DELETE."</span>";
		}
	}
	
	if($act=="config"){ // UPDATE CONFIGURATION
?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric">
								<b><?php echo $LNG_ADMIN_TXT5 ?></b><br><?php echo $LNG_ADMIN_TXT5_1 ?>							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="TXTgeneric"><?php
	if($conf_state){
		echo $LNG_ADMIN_UPD_SUCCESS."<br><br>";
	}
?>
<table width="90%" border="0" cellspacing="8" cellpadding="0">
<form name="configdata" action="index.php?act=doconfig" method="POST">
<input name="<?php echo $FLD['config']['id'] ?>" type="hidden" id="<?php echo  $FLD['config']['id'] ?>" value = "<?php echo  $config_data[$FLD['config']['id']]; ?>">
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD5 ?></td>
		<td><input name="<?php echo $FLD['config']['title'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['title'] ?>" value="<?php echo $config_data[$FLD['config']['title']] ?>" size="40" maxlength="255"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD6 ?></td>
		<td><input name="<?php echo $FLD['config']['email'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['email'] ?>" value="<?php echo $config_data[$FLD['config']['email']] ?>" size="40" maxlength="128"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD7 ?></td>
		<td><select name="menulanguage" class="TXTgeneric">
			<?php 
					$selENG = $selITA = "";
					if($LNG=="ENG"){ $selENG = "selected"; }
					if($LNG=="ITA"){ $selITA = "selected"; }
			?>
			<option value="ENG" <?php echo $selENG ?>>English</option>
			<option value="ITA" <?php echo $selITA ?>>Italiano</option>
		</select></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD8 ?></td>
		<td><input name="<?php echo $FLD['config']['username'] ?>" type="text" class="TXTgeneric" id="<?php echo $FLD['config']['username'] ?>" value="<?php echo $config_data[$FLD['config']['username']] ?>" size="20" maxlength="128"></td>
	</tr>
	<tr>
		<td class="TXTform"><?php echo $LNG_ADMIN_FIELD9 ?></td>
		<td><input name="<?php echo $FLD['config']['password'] ?>" type="password" class="TXTgeneric" id="<?php echo $FLD['config']['password'] ?>" value="<?php echo $config_data[$FLD['config']['password']] ?>" size="20" maxlength="128"></td>
	</tr>
	<tr>
		<td align="center" class="TXTform">&nbsp;</td>
		<td class="TXTform"><a href="index.php?act=forgotpwd"><?php echo $LNG_ADMIN_TXT1_1 ?></a></td>
	</tr>
	<tr>
		<td height="50" colspan="2" align="center" class="TXTform"><input name="update" type="submit" class="TXTgeneric" id="update" value="<?php echo $LNG_ADMIN_UPDATE?>"></td>
		</tr>
</form>
</table></td>
						</tr>
					</table>
<?php
	}

	if($act=="forgotpwd"){ // FORGOT PASSWORD
		$to = $config_data[$FLD['config']['email']];
		$subject = $LNG_ADMIN_FORGOTSUBJECT;
		$body = $LNG_ADMIN_FORGOTBODY;
		$body .= "<br><br>USERNAME: ".$config_data[$FLD['config']['username']];
		$body .= "<br>PASSWORD: ".$config_data[$FLD['config']['password']];

		$header .= "MIME-Version: 1.0\r\n"; 
  		$header .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
  		$header .= "From: *webgriffe photoDiary <info@webgriffe.com>\r\n";
		
		mail($to,$subject,$body,$header);
?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="TXTgeneric">
								<b><?php echo $LNG_ADMIN_TXT6 ?></b><br><?php echo $LNG_ADMIN_TXT6_1.$to ?>			</td>
						</tr>
					</table>
<?php
	}
?>	
	
					
					</td>
<?php 
	//SIDEBAR
	if($_SESSION[$SESSION_ADMIN]){

?>
				<td width="30%" align="center" valign="top"><table width="80%"  border="0" cellspacing="0" cellpadding="0">
					<?php
						
							$mnuclass1 = $mnuclass2 = "color0";
							${"mnuclass".$sez} = "color1";
					?>
					<tr>
						<td class="menuPadding <?php echo $mnuclass1?>" onClick="location.href='index.php?act=new'" onMouseOver="this.className='menuPadding color1'; this.style.cursor='hand';" onMouseOut="this.className='menuPadding <?php echo $mnuclass1?>';"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="28" valign="top"><img src="images/icon_add.gif" width="28" height="24"></td>
									<td class="TXTmenuTitle"><?php echo $MENU_TITLE1?></td>
								</tr>
						</table></td>
					</tr>
					<tr>
						<td class="menuPadding <?php echo $mnuclass12?>" onClick="location.href='index.php?act=archive'" onMouseOver="this.className='menuPadding color1'; this.style.cursor='hand';" onMouseOut="this.className='menuPadding <?php echo $mnuclass2?>';"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="28" valign="top"><img src="images/icon_archive.gif" width="28" height="24"></td>
									<td class="TXTmenuTitle"><?php echo $MENU_TITLE2?></td>
								</tr>
						</table></td>
					</tr>
					<tr>
						<td class="menuPadding <?php echo $mnuclass12?>" onClick="location.href='index.php?act=comments'" onMouseOver="this.className='menuPadding color1'; this.style.cursor='hand';" onMouseOut="this.className='menuPadding <?php echo $mnuclass2?>';"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="28" valign="top"><img src="images/ico_comments.gif" width="28" height="24"></td>
									<td class="TXTmenuTitle"><?php echo $MENU_TITLE5 ?></td>
								</tr>
						</table></td>
					</tr>
					<tr>
						<td class="menuPadding" onClick="location.href='index.php?act=config'" onMouseOver="this.className='menuPadding color1'; this.style.cursor='hand';" onMouseOut="this.className='menuPadding color0';"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="28" valign="top"><img src="images/icon_manage.gif" width="28" height="24"></td>
									<td class="TXTmenuTitle"><?php echo $MENU_TITLE3?></td>
								</tr>
						</table></td>
					</tr>
					<tr>
						<td class="menuPadding" onClick="location.href='index.php?act=logout'" onMouseOver="this.className='menuPadding color1'; this.style.cursor='hand';" onMouseOut="this.className='menuPadding color0';"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="28" valign="top"><img src="images/icon_logout.gif" width="28" height="24"></td>
									<td class="TXTmenuTitle"><?php echo $MENU_TITLE4 ?></td>
								</tr>
						</table></td>
					</tr>
				</table></td>
<?php
	}
?>
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
<?php $db->db_close(); ?>