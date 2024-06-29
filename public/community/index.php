<?php
	define('SAFE', true);
	
	$LockedPages = array();
	
	include("Pieces/header.htm");
	
	if (!empty($_GET['page'])) {
		$page = "index";
		
		$TmpPage = basename($_GET['page']);
		
		// If it's not a disallowed path, and if the file exists, update $page
		if (!in_array($TmpPage, $LockedPages) && file_exists("Pieces/Community/{$TmpPage}.htm")) {
			$page = $TmpPage;
		}
	} else {
		$page = "index";
	}
	
	// Include $page
	include("Pieces/Community/$page.htm");
	
	include("Pieces/footer.htm");
?>