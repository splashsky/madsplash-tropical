<?php
	
	define('SAFE', true);
	
	$LockedPages = array();
	
	include("Pieces/header.htm");
	
	if (!empty($_GET['do'])) {
		$do = "list";
		
		$TmpDo = basename($_GET['do']);
		
		// If it's not a disallowed path, and if the file exists, update $do
		if (!in_array($TmpDo, $LockedPages) && file_exists("Pieces/Blog/{$TmpDo}.htm")) {
			$do = $TmpDo;
		}
	} else {
		$do = "list";
	}
	
	// Include $page
	include("Pieces/Blog/$do.htm");
	
	include("Pieces/footer.htm");
	
?>