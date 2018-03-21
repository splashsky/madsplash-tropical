<?php
	define('SAFE', true);
	
	$LockedPages = array();
	
	include("Pieces/header.htm");
	
	if (!empty($_GET['a'])) {
		$page = "main";
		
		$TmpPage = basename($_GET['a']);
		
		// If it's not a disallowed path, and if the file exists, update $page
		if (!in_array($TmpPage, $LockedPages) && file_exists("Pieces/{$TmpPage}.htm")) {
			$page = $TmpPage;
		}
	} else {
		$page = "main";
	}
	
	if($page == "home") {
		include("Pieces/slider.htm");
	}
	
	// Include $page
	include("Pieces/$page.htm");
	
	include("Pieces/footer.htm");
?>