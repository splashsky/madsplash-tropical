<?php
	define('SAFE', true);
	
	$LockedPages = array();
	
	include("Pieces/header.htm");
	
	if (!empty($_GET['page'])) {
		$page = "home";
		
		$TmpPage = basename($_GET['page']);
		
		// If it's not a disallowed path, and if the file exists, update $page
		if (!in_array($TmpPage, $LockedPages) && file_exists("Pieces/{$TmpPage}.htm")) {
			$page = $TmpPage;
		}
	} else {
		$page = "home";
	}
	
	if($page == "home") {
		include("Pieces/slider.htm");
	}
	
	// Include $page
	include("Pieces/$page.htm");
	
	include("Pieces/footer.htm");
?>