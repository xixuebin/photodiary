<?

	//Convert date format
	function dateFormat($date){
		if(ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date, $regs)){
			$newDate = $regs[3]."-".$regs[2]."-".$regs[1];
		}
		if(ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $date, $regs)){
			$newDate = $regs[3]."-".$regs[2]."-".$regs[1];
		}
		return $newDate;
	}
	
	function write_date($in_date){
		global $MONTH;
		list($dt_day,$dt_month,$dt_year) = explode("-", $in_date);
		$out_date = $dt_day." ".$MONTH[intval($dt_month)]." ".$dt_year;
		return $out_date;
	}
	
	
	function existBadWords($str){
		$BADWORDS = "sex|poker|health|drug|pharmacy|href|viagra|phentermine|http";
		if(preg_match('/\b('.$BADWORDS.')\b/i',$str)){
 			$check = true;
		} else {
			$check = false;
		}
		return $check;
	}

	function trim_post($text) {
		if ($text!="" ) {
			$text = strip_tags($text);
			$text_length = 20;
			$words = explode(" ", $text, $text_length + 1);
			if (count($words) > $text_length) {
				array_pop($words);
				array_push($words, '[...]');
				$text = implode(" ", $words);
			}
			return $text;
		}
	}
	
	function genKey($len){
	 	$key = ''; //intialize to be blank 
	 	for($i=0;$i<$len;$i++) { 
		 	switch(rand(1,3)){ 
			 	case 1: $key.=chr(rand(48,57));  break; //0-9 
			 	case 2: $key.=chr(rand(65,90));  break; //A-Z 
			 	case 3: $key.=chr(rand(97,122)); break; //a-z 
		 	} 
	 	} 
	 	return $key; 
	}
?>