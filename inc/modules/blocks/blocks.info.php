<?php

	defined('IN_LCMS') or exit('Access denied!');

	function blocks_info() {
		return array(
			'name'	=>	'blocks',
			'description'	=>	'Zarządzanie blokami na stronie',
			'author'	=>	'sebag23',
			'version'	=>	'0.1',
			'add2nav'	=>	TRUE
		);
	}

	function blocks_install() {
		global $db;
		$fields = array(array('name'=>'id','auto_increment'=>true),array('name'=>'title'),array('name'=>'content'),array('name'=>'active'));
		$tablename = 'blocks';
		if (!$db->_table_exists('db', $tablename)){
			if($db->create_table($tablename,$fields)){
				$newRecord = array(NULL,'Testowy blok','Treść testowego bloku','1');
				$db->insert($tablename, $newRecord);
			}
		}
	}

	function blocks_uninstall() {
		global $db;
		$db->drop_table('blocks');
	}
	
?>
