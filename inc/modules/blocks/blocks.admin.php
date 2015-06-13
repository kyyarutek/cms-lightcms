<?php

	defined('IN_LCMS') or exit('Access denied!');

	function blocks_pages() {
		$pages[] = array(
			'func'  => 'blocks_list',
			'title' => 'Lista bloków'
		);
		$pages[] = array(
			'func'  => 'blocks_add',
			'title' => 'Dodaj nowy blok'
		);
		$pages[] = array(
			'func'  => 'blocks_version',
			'title' => 'Aktualizacje'
		);
		return $pages;
	}
	
	function blocks_list() {
		global $lang, $db, $core;
		$result = NULL;

		if(isset($_GET['q']) && isset($_GET['id'])) {
			$condtion = array('id'=>$_GET['id']);
            $query = $db->select('blocks', $condtion);
            if($query) {
				if($_GET['q']=='edit') {
					if(isset($_POST['save'])) {
						if(!empty($_POST['title']) && !empty($_POST['content'])) { 
							$updateRecord = array($_POST['id'], $_POST['title'], htmlspecialchars_decode(str_replace(PHP_EOL, '\n', stripslashes($_POST['content']))), $_POST['active']);
							if($db->update('blocks', $condtion, $updateRecord)) {
								$core->notify('Blok został zapisany',1);
							}
						}
					} else {
						$condtion = array('id'=>$_GET['id']);
           				$query = $db->select('blocks', $condtion);
						$record = $query[0];
						$result .= blocks_form($record);
					}
				}

				if($_GET['q']=='del') {
					if($db->delete('blocks', $condtion)) {
						$core->notify('Blok został usunięty',1);
					}
				}
			} else $core->notify('Wybrany blok nie istnieje',2);
		}

		$query = $db->select('blocks');
		$result .= '<table> <thead>';
		$result .= '<tr> <td>Nazwa bloku</td> <td>Treść</td>  <td>Opcje</td> </tr>';
		$result .= '</thead> <tbody>';
		function tnij($text,$length,$sufix='...') {
			if(strlen($text) > $length) return substr($text,0,$length).$sufix;
		else return $text;
}
		foreach($query as $record) {
		
			$result .= '<tr> <td>'.$record['title'].'</td> <td>'. tnij($record['content'],80,'...'). '</td> <td><a href="?go=blocks&q=edit&id='.$record['id'].'" class="icon" title="Edytuj">Z</a> <a href="?go=blocks&q=del&id='.$record['id'].'" class="icon" title="Usuń">l</a></td> </tr>';
		}
		$result .= '</tbody> </table>';

		return $result;

	}
	
	function blocks_add() {
		global $lang, $db, $core;
		$result = NULL;

		$result = blocks_form();

		if(isset($_POST['save'])) {
			if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['active'])) {
				$newRecord = array(NULL, $_POST['title'], stripslashes($_POST['content']), $_POST['active']);
				if($db->insert('blocks', $newRecord)) {
					$core->notify('Blok został dodany',1);
				}
			} else {
				$core->notify('Pola nie mogą być puste',2);
			}
		}
		return $result;
	}

	function blocks_form($data = array()) {
	global $core;
	$core->append(blocks_add2head(), 'head');
		$result = '<form name="blocks" method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		$result .= '<label>Nazwa bloku <span>Nazwa wyświetlana na stronie</span></label>';
		$result .= '<input type="text" name="title" value="'.@$data['title'].'" />';
		$result .= '<label>Treść <span>Zawartość bloku</span></label>';
		if($core->getSettings('wysiwyg')) $result .= '<div class="wysiwyg"><textarea name="content">'.htmlspecialchars(str_replace('\n', "\n",@$data['content'])).'</textarea></div>';
		else $result .= '
		<textarea name="content">'.htmlspecialchars(str_replace('\n', "\n",@$data['content'])).'</textarea>';
		$result .= '<div class="inputss"><label>Aktywny <span>Wyświetlić na stronie?</span></label>';
		if($data) {
		$active = $data['active'];
		$result .= '<div class="radio"><input type="radio" name="active" value="1" '.(($active=='1')?'checked':'').'/>tak |
				
				<input type="radio" name="active" value="2" '.(($active=='2')?'checked':'').'/>nie</div><br />';
		}
		else {
		$result .= '<div class="radio"><input type="radio" name="active" value="1" checked />tak |
				
				<input type="radio" name="active" value="2" />nie</div><br />';
		}
		$result .= '</div><button type="submit" name="save">Wyślij</button>';
		if($data) $result .= '<input type="hidden" name="id" value="'.$data['id'].'" />';
        $result .= '</form>';
        return $result;
	}
	
	function blocks_version() {

		$plik = file_get_contents('http://blackdevil.unixstorm.org/sebag23/blocks_module_version.php');

		if ('0.1' == $plik) {
			return 'Twoja wersja to: <span style="color:#5ea636;">0.1</span>.<br />
					Brak dostępnych aktualizacji.<br /><br />
					Autoru modułu: <a href="http://sebag23.pl" title="sebag23">sebag23</a>';
		}
		else {
			return '<span style="color:#A63636;">Twoja wersja to: 0.1</span>.<br />
					Dostępna jest nowa wersja modułu:<span style="color:#5ea636;"> '.$plik.'</span><br />
					Nowa wersja dostępna jest na forum <a href="http://forum.sruu.pl/forum-33.html">Lekkiego</a>.<br /><br />
					Autoru modułu: <a href="http://sebag23.pl" title="sebag23">sebag23</a>';
		}
	}
	
	function blocks_add2head() {
		global $core;
		$head = '<style type="text/css">
			.LCMS form label {
				width: 12%;
			}
			.LCMS form input[type="text"], .LCMS form textarea {
				width: 80%;
			}
			.LCMS form input[type="submit"], .LCMS form button {
				margin-left: 14%;
			}
			.LCMS form textarea {
				height: 164px;
			}
			.LCMS form .wysiwyg {
				float: left;
				width: 69%;
				margin: 0px 0px 20px 10px;
			}
			
			.LCMS form .wysiwyg textarea {
				width: 100% !important;
				overflow: hidden;
				padding: 0px;
				margin: 0px;
				border: 0;
				font-size: 10pt;
			}
			.LCMS form .wysiwyg textarea:focus {
				box-shadow: none;
			}
			.inputss {float: left; width: 500px; }
		</style>';
		if($core->getSettings('wysiwyg')) {
			$head .= '<link rel="stylesheet" type="text/css" href="../inc/jscripts/CLEditor/jquery.cleditor.css" />
			<script type="text/javascript" src="../inc/jscripts/CLEditor/jquery.cleditor.min.js"></script>
			<script type="text/javascript">$(document).ready(function () { $("textarea").cleditor(); });</script>';
		}
		return $head;
	}

?>
