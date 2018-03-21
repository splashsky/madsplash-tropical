<?php
	define('SAFE', true);
	
	$LockedPages = array();
	
	
	
	if(!empty($_GET['code']) && !empty($_GET['username'])) {
		include("Pieces/header.htm");
		
		include("Pieces/Community/verify.htm");
		
		include("Pieces/footer.htm");
	} else {
		header('Location: http://localhost:8888/index.php');
	}
?>