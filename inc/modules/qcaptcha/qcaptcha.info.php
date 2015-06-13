<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');
	
	//Informations about this module
	function qcaptcha_info() {
		return array(
			'name'	=>	'qCAPTCHA',
			'description'	=>	'',
			'author'	=>	'MaTvA',
			'version'	=>	'0.2',
			'add2nav'	=>	FALSE
		);
	}
	
	//Installation
	function qcaptcha_install() {
		global $db;
		$tablename = 'qcaptcha';
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'question'),array('name'=>'answer'));
		if (!$db->_table_exists('db', $tablename)){
		    if($db->create_table($tablename,$fields)){
		        $newRecord = array(NULL,'Podaj liczbę, która jest sumą liczb dwieście czterdzieści pięć i 5','250');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest sumą liczb pięć i 20','25');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest sumą liczb dwanaście i 5','17');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest sumą liczb sześć i 4','10');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest sumą liczb dziesięć i 20','30');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest różnicą liczb sto i 50','50');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest różnicą liczb pięć i 2','3');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest różnicą liczb sześć i 3','3');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest różnicą liczb osiem i 3','5');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj liczbę, która jest różnicą liczb piętnaście i 5','10');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj co trzecią literę ciągu "lekkicms"','ekcs');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj co drugą literę ciągu "lekki"','ek');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj co drugą literę ciągu "qwerty"','wry');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj co drugą literę ciągu "newsy"','es');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Podaj co drugą literę ciągu "quick"','uc');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Jaka litera będzie w środku ciągu "12521"','5');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Jaka litera będzie w środku ciągu "1263p"','6');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Jaka litera będzie w środku ciągu "TrFxn"','F');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Jaka litera będzie w środku ciągu "T7jxn"','j');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Jaka litera będzie w środku ciągu "Tlrxn"','r');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Przepisz ciąg "matva" bez pierwszej i ostatniej litery','atv');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Przepisz ciąg "thanks" bez pierwszej i ostatniej litery','hank');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Poprzedź ciąg "klocek" znakiem "*" (gwiazdką)','*klocek');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Przepisz ciąg "kola" zamieniając WSZYSTKIE litery "k" na literę "c"','cola');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Przepisz ciąg "łindołs" zamieniając WSZYSTKIE litery "ł" na literę "w"','windows');
		        $db->insert($tablename, $newRecord);
		        $newRecord = array(NULL,'Przepisz ciąg "ogno" zamieniając pierwszą literę "o" na literę "w"','wgno');
		        $db->insert($tablename, $newRecord);
		    }
		}
	}
	
	//Uninstallation
	function qcaptcha_uninstall() {
		global $db;
		$db->drop_table('qcaptcha');
	}

?>
