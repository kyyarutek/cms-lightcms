<?php

		//Make sure the file isn't accessed directly
		defined('IN_LCMS') or exit('Access denied!');

		//Replace pattern by function
		$core->replace('{{qcexample}}', qcexample());

		//Your functions --------------------------------------
		function qcexample() {
			global $db, $qcid, $qcquestion;
			$test = null;
			
			//Wywołanie funkcji qCAPTCHA
			qcaptcha();
			
			if(isset($_POST['check'])) {
				//Wczytywanie prawidłowej odpowiedzi
				if($query = $db->select('qcaptcha', array('id'=>$_SESSION['qcid']))){
					$record = $query[0];
					$qcanswer = $record['answer'];
				}
				//Sprawdzanie, czy w formularzu wszystko zostało poprawnie wypełnione
				if($_POST['qcanswer'] == $qcanswer && !empty($_POST['field'])) {
					$test .= 'Its well!<br>'.$_POST['field'].'';
				} else {
					$test .= '<ul>';
						if(empty($_POST['field'])) $test .= '<li>Wymagane pole nie zostało wypełnione.</il>';
						if($_POST['qcanswer'] !== $qcanswer) $test .= '<li>Zła odpowiedź na pytanie.</il>';
					$test .= '</ul>';
				}
			
			}
			//Formularz
			$test .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			$test .= '<label>Pole</label><input type="text" name="field" value="" />';
			//Pola odpowiadające za qCAPTCHA
			$test .= '<label>Pytanie</label><textarea disabled="disabled">'.$qcquestion.'</textarea>';
			$test .= '<label>Odpowiedź</label><input type="text" name="qcanswer" value="" />';
			//Koniec formularza
			$test .= '<button type="submit" name="check">Sprawdź</button>';
			$test .= '</form>';
			//Zamiana ID pytania
			$_SESSION['qcid'] = $qcid;
			
			return $test;
		}

?>
