<?php
	
	$SYS_ERROR_REPORT = 1;			
	$DB_EMPTY_FIELD = 0;
	
	$SESSION_ADMIN = "WGPH0T0D1AR1";
	
	include "config.php";			//Parametri prncipali di configurazione
	include "common_db.php";		//Dichiarazione dei campi nel DB
	
	//Funzioni di PHP
	include "functions.php";
	
	//Includo le 2 classi per la gestione del DB
	include "classes/class.db.php";		//Classe per l'esecuzione delle operazioni sul DB	
	include "classes/class.iud.php";	//Classe per la gestione delle query e dei valori in esse contenuti
	
	//Creo l'oggetto $db per la gestione del Database
	$db = new db();
	//Passo l'host
	$db->set_db_host($DB_HOST);
	//Passo l'user 
	$db->set_db_user($DB_USER);
	//Passo la password 
	$db->set_db_pass($DB_PASS);
	//Passo lo schema 
	$db->set_db_name($DB_NAME);
	//Gestione degli errori di default
	$db->set_sys_error_log($SYS_ERROR_REPORT);
	
	//Apro e controllo la connessione al Database
	if($db->db_connect()){
		$DB_CONNECTED = true;
	}

	//Creo l'oggetto $iud per la gestione delle query
	$iud = new iud();
	
	$iud->set_empty_field($DB_EMPTY_FIELD);
	
?>