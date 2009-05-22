<?php

include "../common/objects.php";

$act = $_GET['act'];
$shotID = $_GET['shotID'];


// GET CONFIG INFORMATION
if($act == "config"){
	$iud->set_table_str($TBL['config']);
	$iud->set_where_condition(NULL);
	$iud->set_order_condition($FLD['config']['id']." DESC");
	$result_data = $db->db_execute($iud->create_select());
	$data = mysql_fetch_array($result_data);
	echo "&myTitle=".$data[$FLD['config']['title']]."&myLng=".$data[$FLD['config']['lng']]."&myMail=".$data[$FLD['config']['email']]."&eof=ok";
}


// GET SHOTS LIST
if($act == "list") {
	$iud->set_table_str($TBL['posts']);
	$iud->set_where_condition($FLD['posts']['visible']." = 1");
	$iud->set_order_condition($FLD['posts']['date']);
	$result_data = $db->db_execute($iud->create_select());
	$cont=0;
	while($data = mysql_fetch_array($result_data)){
		echo "&id".$cont."=".$data[$FLD['posts']['id']];
		$cont++;
	}
	echo "&totals=".$cont;
} 


// GET SHOT DETAILS
if($act == "details" && $shotID) {
	if(is_numeric($shotID)){
		$iud->set_table_str($TBL['posts']);
		$iud->set_where_condition($FLD['posts']['id']." = ".$shotID);
		$iud->set_order_condition($FLD['posts']['date']." DESC");
		$result_data = $db->db_execute($iud->create_select());
		$data = mysql_fetch_array($result_data);
		$size = getimagesize("../shots/".$data[$FLD['posts']['id']].".jpg");
		$text = str_replace("\r\n", "<br>", $data[$FLD['posts']['text']]);
		$text = str_replace("strong>", "b>", $text);
		$text = str_replace("%", "%25", $text);
		$text = str_replace("&", "%26", $text);
		echo "&W=".$size[0]."&H=".$size[1]."&DT=".dateFormat($data[$FLD['posts']['date']])."&TXT=".$text;
	}
} 
	

// GET SHOT COMMENTS
if($act == "comments" && $shotID) {
	if(is_numeric($shotID)){
		$iud->set_table_str($TBL['comments']);
		$iud->set_where_condition($FLD['comments']['id_ref']." = ".$shotID);
		$iud->set_order_condition($FLD['comments']['date']);
		$result_data = $db->db_execute($iud->create_select());
		$cont=0;
		while($data = mysql_fetch_array($result_data)){
			$cont++;
			echo "&id".$cont."=".$data[$FLD['comments']['id']];
			echo "&nick".$cont."=".$data[$FLD['comments']['name']];
			echo "&date".$cont."=".dateFormat($data[$FLD['comments']['date']]);
			echo "&time".$cont."=".$data[$FLD['comments']['time']];
			echo "&web".$cont."=".$data[$FLD['comments']['url']];
			echo "&mail".$cont."=".$data[$FLD['comments']['email']];
			echo "&txt".$cont."=".str_replace("&", "%26", $data[$FLD['comments']['text']]);
			echo "&x".$cont."=".$data[$FLD['comments']['x']];
			echo "&y".$cont."=".$data[$FLD['comments']['y']];
			echo "&angle".$cont."=".$data[$FLD['comments']['angle']];
		}
		echo "&totals=".$cont;
	}
}


// UPDATE DB
$dataIn = $_POST;
if($act == "upd" && $dataIn) {
		
		$iud->set_table_str($TBL['config']);
		$iud->set_where_condition(NULL);
		$iud->set_order_condition($FLD['config']['id']." DESC");
		$result_data = $db->db_execute($iud->create_select());
		$config = mysql_fetch_array($result_data);
	
		$url = $dataIn['tx_website'];
		$url = str_replace("http://", "", $url);
		$url = str_replace("HTTP://", "", $url);
		
		$arrIn[0] = $TBL['comments']."|";
		$arrIn[$FLD['comments']['id_ref']] = $dataIn["shotID"];
		$arrIn[$FLD['comments']['date']] = date('Y-m-d');
		$arrIn[$FLD['comments']['time']] = date('H:i:s');
		$arrIn[$FLD['comments']['name']] = $dataIn["tx_nome"];
		$arrIn[$FLD['comments']['email']] = $dataIn["tx_email"];
		$arrIn[$FLD['comments']['url']] = $url;
		//$arrIn[$FLD['comments']['text']] = addslashes($dataIn["tx_comment"]);
		$arrIn[$FLD['comments']['text']] = $dataIn["tx_comment"];
		$arrIn[$FLD['comments']['x']] = $dataIn["x"];
		$arrIn[$FLD['comments']['y']] = $dataIn["y"];
		$arrIn[$FLD['comments']['angle']] = $dataIn["angle"];
		
		$iud->set_form_data($arrIn,$FLD['comments']);
		$iud->set_where_condition(NULL);
		$db->db_execute($iud->create_insert());
		
		//SEND EMAIL
		$to = $config[$FLD['config']['email']];
		$subject = "photoDiary - NUOVO COMMENTO";
		$body = "";
		$body .= "NAME: ".$dataIn["tx_nome"]."<br>";
		$body .= "E-MAIL: <a href='mailto:".$dataIn["tx_email"]."'>".$dataIn["tx_email"]."</a><br>";
		$body .= "WEBSITE: <a href='http://".$url."' target='_blank'>".$url."</a><br>";
		$a = explode("/modules","http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']);
		$body .= "VIEW ONLINE: <a href='".$a[0]."/#".$dataIn["shotID"]."'>CLICK HERE</a><br>";
		//$body .= "COMMENT: ".addslashes($dataIn["tx_comment"]);
		$body .= "COMMENT: ".$dataIn["tx_comment"];
		$data="
<html><head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<title>photoDiary</title>
<body>".$body."</body></html>";

		$header .= "MIME-Version: 1.0\r\n"; 
  		$header .= "Content-type: text/html; charset=UTF-8\r\n"; 
  		$header .= "From: ".$dataIn["tx_nome"]." <".$dataIn["tx_email"].">\r\n";
  		$header .= "Reply-To: ".$dataIn["tx_nome"]." <".$dataIn["tx_email"].">\r\n";
		
		mail($to, $subject, $data, $header);
		
		echo "&res=ok";

}

$db->db_close(); 

?>