<?php

$FILE_PATH = $_GET['file_path'];
$destw = $_GET['destw'];
$desth = $_GET['desth'];

$jpeg_quality = 80;

if(!empty($FILE_PATH) && is_file($FILE_PATH)) {
	header("Content-type: image/jpeg");
	ob_start();
	$src_img = imagecreatefromjpeg($FILE_PATH);
	$origw=imagesx($src_img);
	$origh=imagesy($src_img);
    
	if($origw/$origh>=$destw/$desth){
		$THUMB_W = $destw;
		$THUMB_H = floor($destw*$origh/$origw);
	} else {
		$THUMB_H = $desth;
		$THUMB_W = floor($desth*$origw/$origh);
	}
	
	$dst_img = imagecreatetruecolor($THUMB_W,$THUMB_H);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$THUMB_W,$THUMB_H,$origw,$origh);
	
	imagejpeg($dst_img, "", $jpeg_quality);	
	$size = ob_get_length(); 
	header("Content-Length: $size");
	ob_end_flush();
}
?>