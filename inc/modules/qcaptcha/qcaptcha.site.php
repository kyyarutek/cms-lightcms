<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Main func
	function qcaptcha() {
		global $db, $qcid, $qcquestion;
		$idsload = NULL;
		foreach($db->select('qcaptcha') as $record) {
			$idsload .= ''.$record['id'].',';
		}
		$idsload .= 'end-qcaptcha-array';
		$idsarray = explode(",", str_replace(',end-qcaptcha-array', "", $idsload));
		$qcid = $idsarray[array_rand($idsarray)];
		if(isset($qcid) && is_numeric($qcid)) {
			if($query = $db->select('qcaptcha', array('id'=>$qcid))){
				$record = $query[0];
				$qcquestion = $record['question'];
			}
		}
	}

?>