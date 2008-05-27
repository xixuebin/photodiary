<?php

class db{

	//Variabili di sessione
	var $db_host 						= "";		//Host del database
	var $db_user 						= "";		//Nome utente per la connessione al database
	var $db_pass 						= "";		//Password per la connessione al database
	var $db_name 						= ""; 	//Nome del dello schema
	var $db_errn 						= 0;		//Numero dell'errore
	var $db_errs 						= "";		//Descrizione dell'errore
	var $db_link 						= -1;		//Link al database interna alla classe e non pubblica
	var $query_num_rows			= -1;		//Valore intero delle righe restituite da una query 
	var $sys_error_log			= 1;		//Visualizza gli errori di PHP		
	
	//################################################
	// Funzioni per l'accesso al database (read-write)
	//################################################
	
	//Funzioni per l'host
	function set_db_host($db_host){
		$this->db_host=$db_host;
	}
	
	function get_db_host(){
		return $this->db_host;
	}
	
	//Funzioni per l'utente
	function set_db_user($db_user){
		$this->db_user = $db_user;
	}

	function get_db_user(){
		return $this->db_user;
	}
	
	//Funzioni per la password
	function set_db_pass($db_pass){
		$this->db_pass = $db_pass;
	}

	//Invio della password criptata
	function get_db_pass(){
		for($i=1;$i<=strlen($this->db_pass);$i++){
			$newpass .= "*";			
		}
		return $newpass;
	}

	//Funzioni per lo schema del database 
	function set_db_name($db_name){
		$this->db_name = $db_name;
	}

	function get_db_name(){
		return $this->db_name;
	}
	
	//Funzioni per la visualizzazione degli errori di default (settati in php.ini)
	function set_sys_error_log($sys_error_log){
		$this->sys_error_log = $sys_error_log;
	}

	function get_sys_error_log(){
		return $this->sys_error_log;
	}
	
	//#################################################	
	//Funzioni per la gestione degli errori (read-only)
	//#################################################
	
	function get_db_errn(){
		//Restituisce il numero di errore 
		return $this->db_errn;
	}	
	
	function get_db_errs(){
		//Restituisce la descrizione dell'errore
		return $this->db_errs;
	}	
	
	function get_db_link(){
		//Restituisce il link al database
		return $this->db_link;
	}
	
	function get_query_num_rows(){
		//Restituisce il numero di righe del processo eseguito
		return $this->query_num_rows;
	}
	
	//################################################
	// Connessione al Database
	//################################################	
		
	//Apertura della connessione	
	function db_connect(){
		//Inizializzazione del collegamento al DB
		//controllo della visualizzazione errori
		if($this->sys_error_log){
			$this->db_link = mysql_connect($this->db_host,$this->db_user,$this->db_pass);
		}else{
			$this->db_link = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
		}
		//Controllo sul collegamento allo schema e, in caso di errore, restituzione dei 2 valori di errore
		if(!$this->db_link){
			//Gestione errori sulla connessione
			$this->db_errs = "Connesione fallita per: " . mysql_error();
			$this->db_errn = mysql_errno();
			return $this->db_link; // -1
		}else if(!mysql_select_db($this->db_name,$this->db_link)){
			//Gestione errori sulla selezione dello schema
			$this->db_errs = "Selezione dello schema fallita per: " . mysql_error();
			$this->db_errn = mysql_errno();
			return $this->db_link; // -1
		}else{
			//Controllo completato e invio del valore di connessione
			return $this->db_link;
		}
	}
	
	//Chiusura della connessione
	function db_close(){
		if($this->sys_error_log){
			$db_link_close = mysql_close($this->db_link);
		}else{
			$db_link_close = @mysql_close($this->db_link);
		}
		if($db_link_close){
			return true;
		}else{
			$this->db_errs = "Chiusura del database fallita per: ".mysql_error();
			$this->db_errn = mysql_errno();
			return false;
		}
	}	

	//################################################
	// Esecuzione della query
	//################################################		
	
	function db_execute($query){
		//Esecuzione della query 
		if($this->sys_error_log){
			$result = mysql_query($query,$this->db_link);
		}else{
			$result = @mysql_query($query,$this->db_link);
		}
		if($result){
			//Numero di righe processate durante l'operazione
			if(ereg("SELECT",$query)){
				//Processo SELECT
				$this->query_num_rows = mysql_num_rows($result); 
			}else{
				//Tutti gli altri processi
				$this->query_num_rows = mysql_affected_rows(); 
			}
			return $result;
		}else{
			//Gestione errori sull'esecuzione della query
			$this->db_errs = "Esecuzione della query fallita per : " . mysql_error();
			$this->db_errn = mysql_errno();
			return $result;
		}
	}
	
}
?>
