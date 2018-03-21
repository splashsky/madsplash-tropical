<?php
	if(!defined('SAFE')) {
		$page = <<<CANTTOUCH
					<html>
						<head>
						
						</head>
						
						<body style="padding:0px; margin:0px; background-color: #425b5c;">
							<center><img src="../../Images/General/CantTouchThis.png" /></center>
						</body>
					</html>
CANTTOUCH;

		die($page); 
	}
	
	/*
	///
	// Author: Skylear Johnson      Co-Author: None
	// The purpose of the Library is to be a catalogue of general functions, for use throughout the site.
	// This script is copyright (c) 2013, by Mad Splash Studios.
	///
	*/
	
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	
	/* This entire block here is a method to rid POST, GET and COOKIE of unwanted slashes. 
	// I have to give some thanks to Atli from Dream.In.Code for helping me come up with this.
	// However, this should never really be used. If magic_slashes is a problem, it's time to switch servers; ASAP. */ 
	if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
		function undo_magic_quotes_gpc(&$array) {
			foreach($array as &$value) {
				if(is_array($value)) {
				
					undo_magic_quotes_gpc($value);
					
				} else {
	            
					$value = stripslashes($value);
	                
				}
			}
		}
	    
		undo_magic_quotes_gpc($_POST);
		undo_magic_quotes_gpc($_GET);
		undo_magic_quotes_gpc($_COOKIE);
	}
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Includes, so we can use them elsewhere without having to call them each time.
	
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/User.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/Show.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/Article.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/Project.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/ArticleComment.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Classes/EpisodeComment.php");
	
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Modules/DisplayModule.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Modules/DatabaseModule.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/Resources/Scripts/PHP/Modules/CommunityModule.php");
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Misc functions - used for who-knows-what and who-knows-when.
	
	// Used for scripts that require some sort of timing.
	function getMicroTime() {
		list($usec, $sec) = explode(" ", microtime()); 
		return ((float)$usec + (float)$sec); 
	}
	
	function arrayCheck($ArrayToCheck, $CheckAgainst) {
		if(count(array_intersect($ArrayToCheck, $CheckAgainst)) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Pretty functions - used to makes things cleaner and look nicer.
	
	// Change the MySQL date format (YYYY-MM-DD) into something friendlier.
	function betterDate($uglyDate) {
		try {
			$date = new DateTime($uglyDate);
			
			return $date->format("jS M Y, g:i A");
		} catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}
	
	function nicerDate($uglyDate) {
		try {
			$date = new DateTime($uglyDate);
			
			return $date->format("jS M Y - g:i A");
		} catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}
	
	function getAge($date) {
		$birthDay = new DateTime($date);
		$today    = new DateTime();
		
		$age = $today->diff($birthDay);
		return $age->y;
	}
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Aegis functions - cleans data and parses it, as well as hashes and checks other stuff for protection.
	
	// This function serves to prevent tags within HTML getting into things. It's basically a symbol cleaner.
	// Kudos to Atli from Dream.In.Code for showing me htmlentities()!
	function magicClean($text) {
		$text = htmlentities($text, ENT_QUOTES, "UTF-8");
		return $text;
	}
	
	// Hash a password thousands of times using a random salt.
	function hashPass($password, $salt, $username = "failure") {
		for($round = 0; $round < 124363; $round++) {
		   $HashedPass = hash("sha512", $username . $salt . $password);
		}
		
		return $HashedPass;
	}
	
	function generateSalt($max = 15) {
		$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
		$i = 0;
		$salt = "";
		
		while ($i < $max) {
			$salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
			$i++;
		}
		
		return $salt;
	}
	
	// Validate the email address inputted!
	function checkEmail($email) {
		$isValid = true;
		$atIndex = strrpos($email, "@");
	    
		if(is_bool($atIndex) && !$atIndex) {
	        $isValid = false;
		} else {
			$domain    = substr($email, $atIndex + 1);
			$local     = substr($email, 0, $atIndex);
			$localLen  = strlen($local);
			$domainLen = strlen($domain);
			
			if($localLen < 1 || $localLen > 64) {
				$isValid = false;
			} elseif($domainLen < 1 || $domainLen > 255) {
				$isValid = false;
			} elseif($local[0] == '.' || $local[$localLen - 1] == '.') {
				$isValid = false;
			} elseif(preg_match('/\\.\\./', $local)) {
				$isValid = false;
			} elseif(!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				$isValid = false;
			} elseif(preg_match('/\\.\\./', $domain)) {
				$isValid = false;
			} elseif(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
					$isValid = false;
				}
			}
			
			if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
				$isValid = false;
			}
		}
		
		return $isValid;
	}
	
	// Simple BBCode parse function.
	function BBCode($data) {
		$input = array(
			'/(\r?\n)/',
			'/(\r?\n){2,}/',
			'/\[b\](.*?)\[\/b\]/is',
			'/\[i\](.*?)\[\/i\]/is',
			'/\[u\](.*?)\[\/u\]/is',
			'/\[img (.*?)\](.*?)\[\/img\]/is',
			'/\[url\](.*?)\[\/url\]/is',
			'/\[url\=(.*?)\](.*?)\[\/url\]/is',
			'/\[list\]/is',
			'/\[\/list\]/is',
			'/\[item\](.*?)\[\/item\]/is',
			'/ \:\)/is',
			'/ \-\.\-/is',
			'/ \:bomb\:/is',
			'/ \:D/is',
			'/ \:C/is',
			'/ \-\_\-/is',
			'/ o\_\-/is',
			'/ \-\_\o/is',
			'/ o\.\-/is',
			'/ D\:/is',
			'/\[code\](.*?)\[\/code\]/is',
			'/ \:P/is'
		);
	
		$output = array(
			'<br />',
			'<br /><br />',
			'<strong>$1</strong>',
			'<em>$1</em>',
			'<u>$1</u>',
			'<img style="$1" src="$2" />',
			'<a href="$1">$1</a>',
			'<a href="$1">$2</a>',
			'<ul>',
			'</ul>',
			'<li>$1</li>',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Smile.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Blank.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Bomb.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Grin.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/MegaSad.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Blank.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Huh.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Huh.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Huh.gif\' />',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Horror.gif\' />',
			'<pre class="forumCode"><span class="title"><span class="hdr">CODE</span> </span><p style="padding: 5px;">$1</p></pre>',
			'<img class="Emote" src=\'../Resources/Images/Icons/Emotes/Tongue.gif\' />'
		);
	
		$rtrn = preg_replace($input, $output, $data);
	
		return $rtrn;
	}
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Email functions - used to send emails for various reasons
	
	// Send an email to the specified recipient.
	function sendMail($mailSubject, $mailContent, $mailDestinee, $templatename) {
		$mailHeaders  = 'MIME-Version: 1.0' . "\r\n";
		$mailHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$mailHeaders .= 'From: theguys@localhost:8888' . "\r\n";
		
		$filename = $_SERVER['DOCUMENT_ROOT'] . "/Resources/Templates/emails/" . $templatename . ".php";
		include("$filename");
		
		foreach($mailContent as $a => $b) {
		    $template = str_replace("{{{" . $a . "}}}", $b, $template);
		}
		
		mail($mailDestinee, $mailSubject, $template, $mailHeaders);
	}
	
	// ---------------------------------------------------------------------------- //
	// ---------------------------------------------------------------------------- //
	/// Generator functions - used to create things that would take too many lines to constantly repeat
	
	// Create the new and improved text editor.
	function textEditor($Width, $Height, $Name, $Default) {
		echo <<<EDITOR
			<div id="textEdior" style="width: {$Width}; margin: 12px 0px;">
				<ul class="BBCodeButtons" style="float: right; position: relative; right: -1px;">
					<li onclick="addTXT('b', '{$Name}')"><span class="BBCButton" style="font-weight: bold;">B</span></li>
					<li onclick="addTXT('i', '{$Name}')"><span class="BBCButton" style="font-style: italic;">i</span></li>
					<li onclick="addTXT('u', '{$Name}')"><span class="BBCButton" style="text-decoration: underline;">u</span></li>
					<li onclick="addTXT('list', '{$Name}')"><span class="BBCButton">List</span></li>
					<li onclick="addTXT('item', '{$Name}')"><span class="BBCButton">Item</span></li>
					<li onclick="addTXT('img', '{$Name}')"><span class="BBCButton">IMG</span></li>
					<li onclick="addTXT('url', '{$Name}')"><span class="BBCButton">URL</span></li>
				</ul>
				
				<label for="{$Name}" style="color: #888; font-weight: bold; position: relative; top: 6px;">{$Name}</label>
			
				<textarea id="{$Name}" class="message" name="{$Name}" style="width: 100%; max-width: 100%; height: {$Height};">{$Default}</textarea>
			</div>
EDITOR;
	}
	
	// Function to check for errors and display them as needed.
	function displayErrors($leErrors, $errorArray) {
		$Errors = array(
			"<!-- 1  -->You forgot to put in a username!",
			"<!-- 2  -->Sorry, but you can't have special characters in your username.",
			"<!-- 3  -->That username already exists; you have to pick a new one.",
			"<!-- 4  -->Your username is longer than 24 characters!",
			"<!-- 5  -->You didn't give an email address!",
			"<!-- 6  -->The email you gave wasn't valid! Double-check it.",
			"<!-- 7  -->That email is already registered! <a href=\"#\">Did you forget your password?</a>",
			"<!-- 8  -->You DO need to make a password, ya know.",
			"<!-- 9  -->You need to confirm your password here!",
			"<!-- 10 -->The passwords you gave didn't match. Time to double-check.",
			"<!-- 11 -->It seems that username doesn't exist. <a href=\"index.php?page=register\">Want to register?</a>",
			"<!-- 12 -->That password doesn't match the username. <a href=\"iForgot.php?this=password\">Reset your password?</a>",
			"<1-- 13 -->Whoops! You need to give both your username and your password!"
		);
		
		$leErrors = array_intersect($leErrors, $errorArray);
		
		foreach($leErrors as $error) {
			$error = $error - 1;
			echo "<span class=\"error\">" . $Errors[$error] . "</span>";
		}
	}
	
	// Retrieve template from the source.
	function GetTemplate($templatename) {
	    $filename = $_SERVER['DOCUMENT_ROOT'] . "/Resources/Templates/" . $templatename . ".php";
	    include("$filename");
	    
	    return $template;
	}
	
	// Parse all proper content into the template.
	function ParseTemplate($template, $array) {
	    foreach($array as $a => $b) {
	        $template = str_replace("{{{" . $a . "}}}", $b, $template);
	    }
	    
	    return $template;
	}
?>