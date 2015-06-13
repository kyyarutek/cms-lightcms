<?php

	defined('IN_LCMS') or exit('Access denied!');

	$core->replace('{{blocks}}', blocks());
	$core->append(blocks_head(), 'head');

	function blocks() {
		global $core, $db;
		$result = NULL;
				
		$query = $db->select('blocks', array('active' => 1));
				
		$result .= '<div class="sideblock">';
		
		foreach($query as $record) {
			$result .= '<div class="sidebar"><h1>'.$record['title'].'</h1><p>'.$record['content'].'</p></div>';
		}
				
		$result .= '</div>';
		
		return $result;
	}
	
	function blocks_head() {
		$head .= '<style type="text/css">
		.sideblock { float:left; width:260px; }
		</style>';
				
		return $head;
	}

?>
