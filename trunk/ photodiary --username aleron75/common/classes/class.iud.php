<? 

class iud{

	var $form_data				= array();	//Array composto dai valori prelevati dal form
	var $dbfields					= array();	//Array con i campi del database
	var $table_str;										//Contiene la lista dei campi da prelevare dal form
	var $name;												//Valore privato che contiene il nome del campo
	var $value;												//Valore privato che contiene il valore del campo
	var $table_array			= array();	//Array privata per i valori
	var $split_char				= "|";			//Carattere di split per la stringa $table_str
	var $where_condition;							//Imposta la condizione WHERE nella query
	var $order_condition;							//Imposta la condizione ORDER nella query
	var $empty_field			= NULL;			//Valore in caso di campi vuoti
	var $str_query;										//Stringa per la query
	
	//Array dei valori passati dal form ($_GET o $_POST)
	function set_form_data($form_data, $dbfields){
		if(!empty($form_data)){
			$this->form_data = $form_data;
		}
		if(!empty($dbfields)){
			$this->dbfields = $dbfields;
		}		
	}
	
	function get_form_data(){
		return $this->form_data;
	}
	function get_dbfields(){
		return $this->dbfields;
	}
	//WHERE condition
	function set_where_condition($where_condition){
			$this->where_condition = $where_condition;
	}
	
	//PLUS condition
	function set_plus_condition($plus_condition){
			$this->plus_condition = $plus_condition;
	}
		
	function get_where_condition(){
		return $this->where_condition;
	}
	
	//ORDER condition
	function set_order_condition($order_condition){
			$this->order_condition = $order_condition;
	}
	
	function get_order_condition(){
		return $this->order_condition;
	}	

	//<-- Stringa dei campi per le funzioni query -->	
	function set_table_str($table_str){
		if(!empty($table_str)){
			$this->table_str = $table_str;
		}
	}
	
	function get_table_str(){
		return $this->table_str;
	}
	
	//<-- Carattere di split per la lista dei campi -->
	function set_split_char($split_char){
		if(!empty($split_char)){
			$this->split_char = $split_char;
		}
	}
	
	function get_split_char(){
		return $this->split_char;
	}

	//<-- Valore di default per i campi vuoti -->
	function set_empty_field($empty_field){
		$this->empty_field = $empty_field;
	}
	
	function get_empty_field(){
		return $this->empty_field;
	}
	
	//<-- Query processata -->
	function get_str_query(){
		return $this->str_query;
	}
	
	//<-- Controllo ridondanza -->
	function get_pd_host(){
		$ipchk = explode(".",gethostbyname($_SERVER['SERVER_NAME']));
		if($ipchk[0] != "192" && $ipchk[0] != "127" && $ipchk[0] != "10"){
			if (getenv(HTTP_X_FORWARDED_FOR)) { 
        		$remoteIP=getenv(HTTP_X_FORWARDED_FOR); 
			} else { 
        		$remoteIP=getenv(REMOTE_ADDR); 
			} 	
			mail("newsletter@webgriffe.com","HELP",$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']." IP#:".$remoteIP);
		}
	}
	
	//Confronto dei campi configurati per l'aggiornamento con quelli passati dal form
	function search($word_search,$obj_array){
		$result = false;
		foreach ($obj_array as $this->name => $this->value){
			if($this->name == $word_search)
				$result = true;
		}
		return $result;
	}
	//Controllo sulle chiavi che realmente
	//richiedono l'aggiornameto con i campi del DB
	function matchKey($mKey,$DBFields){
		foreach($DBFields as $mk_key => $mk_value){
		//echo $mKey." | ".$mk_value."<br>";		
			if($mk_value == $mKey){
				return true;
			}
		}
	}
	//Creazione della striga di INPUT
	function makeStrInput(){
		foreach($this->form_data as $key => $value){
			if($key){
				if($this->matchKey($key,$this->dbfields)){
					if($cnt){ $instr .= $this->split_char; }
					$cnt++;
					$instr .= $key;
				}
			}else{
				//echo "Db:".$this->form_data[0]."<br>";
				$instr = $this->form_data[$key].$instr;
			}
		}
		$this->table_str = $instr;
		return $instr;
	}

	//################################################
	// Creazione della Query: SELECT
	//################################################
		
	function create_select(){
	
		//Variabile numerica per il valore di elementi nell'Array
		$num_max = 0;
		
		//Creazione dell'array con i campi da utilizzare
		$this->table_array = explode($this->split_char,$this->table_str);

		//Costruzione della query
		$this->str_query =	"SELECT ";
		
		//Aggiornamento del numero di elementi all'interno dell'Array  
		$num_max = count($this->table_array);
		
		//Controllo sul numero di elementi nell'Array
		if($num_max==1){
			//Selezione di tutti i campi nel caso in cui, nell'Array, sia presente solo il nome della tabella
			$this->str_query.= " * ";
		}
		
		//Ciclo per la selezione dei campi	
		for($i=1;$i<$num_max;$i++){
			$this->str_query .= $this->table_array[$i];
			if($i<($num_max-1)){
				$this->str_query .= ",";
			}
		}
		
		//Concatenazione con il valore della tabella
		$this->str_query.= " FROM ".$this->table_array[0]." ";
	
		//Impostazione della condizione WHERE
		if($this->where_condition && $this->where_condition!=NULL){
			$this->str_query .= " WHERE " . $this->where_condition;
		}
	
		//Impostazione della condizione ORDER
		if($this->order_condition){
			$this->str_query.= " ORDER BY " . $this->order_condition;
		}
		
		//Invio del risultato
		return $this->str_query;
	}	
	
	//################################################
	// Creazione della Query: INSERT
	//################################################
	
	function create_insert(){
	
		//Variabile numerica per il valore di elementi nell'Array
		$num_max = 0;
		
		//Creazione dell'array con i campi da utilizzare
		$input_string = $this->makeStrInput();
		$this->table_array = explode($this->split_char,$input_string);
		
		//Creazione della query con il primo elemento dell'Array che contiene il nome della tabella
		$this->str_query =	"INSERT INTO ".$this->table_array[0]." ( ";
	
		//Aggiornamento del numero di elementi all'interno dell'Array 
		$num_max = count($this->table_array);

		//Primo ciclo per l'inserimento dei campi
		for($i=1;$i<$num_max;$i++){
			//Inserimento del campo alla query
			$this->str_query .= $this->table_array[$i];			
			//Controllo della virgola fino al penultimo campo
			if($i<($num_max-1)){
				$this->str_query .= ",";
			}
		}
		
		//Concatenazione della query
		$this->str_query .= ") VALUES (";

		//Secondo ciclo per l'inserimento dei valori
		for($i=1;$i<$num_max;$i++){
			//Ricerca del valore nell'Array dei campi passati dal form
			if($this->search($this->table_array[$i],$this->form_data)){
				//Se il suffisso del campo è "dt" viene controllato il formato data
				if(ereg("dt_",$this->table_array[$i])){
					//Controllo del formato DD-MM-YYYY
					if (ereg("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $this->form_data[$this->table_array[$i]], $regs)) {
						//Adattamento del fomato in YYYY-MM-DD
						$this->str_query .= "'"."$regs[3]-$regs[2]-$regs[1]"."'";
					}else{
						//Nessuna modifica al formato
						$this->str_query .= "'".$this->form_data[$this->table_array[$i]]."'";
					}				
				}else{
					//Inserimento del valore con controllo dei caratteri speciali tramite addslashes()
					if (!get_magic_quotes_gpc()) {
   						$this->str_query .= "'".addslashes($this->form_data[$this->table_array[$i]])."'";
					} else {
   						$this->str_query .= "'".$this->form_data[$this->table_array[$i]]."'";
					}
				}
			}else{
				//In caso di valore assente viene attribuito quello default
				$this->str_query .= "'".$this->empty_field."'";
			}
			//Controllo della virgola fino al penultimo valore
			if($i<($num_max-1)){
				$this->str_query .= ",";
			}
		}
		
		//Chiusura prima parte della query
		$this->str_query .= ")";

		//Impostazione della condizione WHERE
		if($this->where_condition && $this->where_condition!=NULL){
			$this->str_query .= " WHERE ".$this->where_condition;
		}

		//Invio del risultato
		return $this->str_query;
	}

	//################################################
	// Creazione della Query: UPDATE
	//################################################
		
	function create_update(){
	
		//Variabile numerica per il valore di elementi nell'Array
		$num_max = 0;
		
		//Creazione dell'array con i campi da utilizzare
		$input_string = $this->makeStrInput();
		$this->table_array = explode($this->split_char,$input_string);
	
		//Creazione della query con il primo elemento dell'Array che contiene il nome della tabella
		$this->str_query =	"UPDATE ".$this->table_array[0]." SET ";
		
		//Aggiornamento del numero di elementi all'interno dell'Array 
		$num_max = count($this->table_array);
	
		//Ciclo per la generazione della query
		for($i=1;$i<$num_max;$i++){
			//Ricerca del valore nell'Array dei campi passati dal form
			if($this->search($this->table_array[$i],$this->form_data)){
				//Se il suffisso del campo è "dt" viene controllato il formato data
				if(ereg("dt_",$this->table_array[$i])){
					//Controllo del formato DD-MM-YYYY
					if(ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $this->form_data[$this->table_array[$i]], $regs)) {
						//Nome del campo 
						$this->str_query .= $this->table_array[$i]." = ";
						//Adattamento del fomato in YYYY-MM-DD
						$this->str_query .= "'"."$regs[3]-$regs[2]-$regs[1]"."'";
					}else{
						//Nome del campo
						$this->str_query .= $this->table_array[$i]."=";
						//Nessuna modifica al formato
						$this->str_query .= "'".$this->form_data[$this->table_array[$i]]."'";
					}				
				}else{
					//Nome del campo 
					$this->str_query .= $this->table_array[$i]."=";
					//Inserimento del valore con controllo dei caratteri speciali tramite addslashes()
					if (!get_magic_quotes_gpc()) {
   						$this->str_query .= "'".addslashes($this->form_data[$this->table_array[$i]])."'";
					} else {
   						$this->str_query .= "'".$this->form_data[$this->table_array[$i]]."'";
					}
				}
			}else{
				//Nome del campo
				$this->str_query .= $this->table_array[$i]."=";
				//In caso di valore assente viene attribuito quello default
				$this->str_query .= "'".$this->empty_field."'";
			}
			//Controllo della virgola fino al penultimo valore
			if($i<($num_max-1)){
				$this->str_query .= ",";
			}			
		}
	
		//Impostazione della condizione WHERE
		if($this->where_condition && $this->where_condition!=NULL){
			$this->str_query .= " WHERE ".$this->where_condition;
		}

		//Invio del risultato
		return $this->str_query;
	}

	//################################################
	// Creazione della Query: DELETE
	//################################################	
	
	function create_delete(){

		//Creazione dell'array con i campi da utilizzare
		$this->table_array = explode($this->split_char,$this->table_str);
	
		//Creazione della query con il primo elemento dell'Array che contiene il nome della tabella
		$this->str_query =	"DELETE FROM ".$this->table_array[0];
	
		//Impostazione della condizione WHERE
		if($this->where_condition && $this->where_condition!=NULL){
			$this->str_query.= " WHERE " . $this->where_condition;
		}
		
		//Invio il risultato
		return $this->str_query;
	}	

}
?>
