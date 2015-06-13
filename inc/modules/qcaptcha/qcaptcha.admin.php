<?php

	//Make sure the file isn't accessed directly
	defined('IN_LCMS') or exit('Access denied!');

	//Load lang file of this module
	require('../'.LANG.'admin/qcaptcha.php');
	
	//Pages of this module
	function qcaptcha_pages() {
		global $lang;
		$pages[] = array(
			'func'  => 'qcaptcha',
			'title' => 'qCAPTCHA'
		);
		$pages[] = array(
			'func'  => 'check_updates',
			'title' => $lang['qcaptcha']['check updates']
		);
		return $pages;
	}

	//Start qcaptcha()
	function qcaptcha() {
		global $core, $db, $lang;
		$result = NULL;
		if(isset($_GET['q']) && $_GET['q'] == 'edit' && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']); 
            $query = $db->select('qcaptcha', $condtion);
            if($query) {
					if(isset($_POST['save'])) {
						if(!empty($_POST['question']) && !empty($_POST['answer'])) {
							$id = $_GET['id'];
							$updateRecord = array($id, $_POST['question'], $_POST['answer']);
							if($db->update('qcaptcha', $condtion, $updateRecord)) $core->notify($lang['qcaptcha']['update success'],1);
							else $core->notify($lang['qcaptcha']['update fail'],2);
						} else $core->notify($lang['qcaptcha']['update fail'],2);
					} 
					$condtion = array('id'=>$_GET['id']);
           			$query = $db->select('qcaptcha', $condtion);
					$record = $query[0];
					foreach($query as $record) {
						$result .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
						$result .= '<label>'.$lang['qcaptcha']['question'].'</label><input type="text" name="question" value="'.$record['question'].'"/>';
						$result .= '<label>'.$lang['qcaptcha']['answer'].'</label><input type="text" name="answer" value="'.$record['answer'].'"/>';
						$result .= '<button type="submit" name="save">'.$lang['qcaptcha']['save'].'</button>';
						$result .= '</form>';
					}
			} else $result .= $lang['qcaptcha']['news doesnt exist'];
		} else {
			/*--- DELETE SECTION -------------------*/
			if(isset($_GET['q']) && $_GET['q']=='del' && isset($_GET['id'])) {
				$condtion = array('id'=>$_GET['id']); 
				$query = $db->select('qcaptcha', $condtion);
				if($query) {
					if($db->delete('qcaptcha', $condtion)) $core->notify($lang['qcaptcha']['delete success'],1);
					else $core->notify($lang['qcaptcha']['delete fail'],1);
				} else $core->notify($lang['qcaptcha']['news doesnt exist'],2);
			}
			if(isset($_POST['add'])) {
				if(!empty($_POST['question']) && !empty($_POST['answer'])) {
					$newRecord = array(NULL, $_POST['question'], $_POST['answer']);
					if($db->insert('qcaptcha', $newRecord));
					$core->notify($lang['qcaptcha']['add success'],1);
				} else $core->notify($lang['qcaptcha']['add fail'],2);
			}
			//Select table from DB
			$query = $db->select('qcaptcha');
			$result .= '<table><thead>';
			$result .= '<tr><td>'.$lang['qcaptcha']['question'].'</td><td>'.$lang['qcaptcha']['answer'].'</td><td width="52px">'.$lang['qcaptcha']['actions'].'</td></tr>';
			$result .= '</thead><tbody>';
			//Get the records
			sort($query); //Sort
			foreach($query as $record) {
				$result .= '<tr><td>'.$record['question'].'</td><td>'.$record['answer'].'</td><td><a href="?go=qcaptcha&action=captcha&q=edit&id='.$record['id'].'"><span class="icon">Z</span></a> <a href="?go=qcaptcha&action=captcha&q=del&id='.$record['id'].'" onclick="return confirm(\''.$lang['qcaptcha']['delete confirm'].'\')" class="icon">l</a></td></tr>';
			}
			$result .= '<form method="post" name="addform" action="'.$_SERVER['REQUEST_URI'].'"><tr><td><input type="text" name="question" value=""/></td><td><input type="text" name="answer" value=""/></td><td><input type="hidden" name="add"/><a href="#" onclick="document.addform.submit();"><span class="icon">M</span></a></td></form>';
			$result .= '</tbody></table>';
		}
		return $result;
	}
	//End qcaptcha()
	
	//Start check_updates()
	function check_updates() {
		global $lang;
		$result = NULL;
		//loading updates
		$check_load = file_get_contents("http://lekkicms.pl/update.php?module=qcaptcha&ver=0.2");
		//checking updates
		if(isset($check_load) && is_numeric($check_load)) {
			if($check_load == "0") $result = $lang['qcaptcha']['update no'];
			if($check_load == "1") $result = $lang['qcaptcha']['update yes'];
		} else {
			$result = $lang['qcaptcha']['update not loaded'];
		}
		return $result;
	}
	//End check_updates()

?>
