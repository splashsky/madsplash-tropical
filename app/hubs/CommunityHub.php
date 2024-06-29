<?php
	/*
		--- The Community Hub
		--- This hub is purposed for managing user interactions with the website, and uses the Community Module for actions.
		--- This hub was crafted by Skylear. : )
		--- Copyright (c) Mad Splash, 2014, all rights reserved.
	*/
	
	define('SAFE', true);
	
	require('../Library.php');
	
	if(!empty($_GET['action'])) {
		
		
		if(!empty($_GET['user'])) {
			$user = new User($_GET['user']);
		}
		
		$CM   = new CommunityModule();
		
		
		
		switch($_GET['action']) {
			case "register":
				$CM->registerUser();
				break;
				
			case "login":
				$CM->loginUser();
				break;
				
			case "logout":
				$CM->logoutUser($user->UserID);
				break;
				
			case "postAComment":
				$CM->postAComment($_GET['artID']);
				break;
				
			case "episodeComment":
				$CM->episodeComment($_GET['epID']);
				break;
				
			default:
				header('Location: http://localhost:8888/');
				break;
		}
		
		
		
	} else {
		header('Location: http://localhost:8888/');
		exit;
	}
?>