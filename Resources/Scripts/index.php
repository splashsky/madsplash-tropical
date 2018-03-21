<?php
	if(!defined('SAFE')) {
		$page = <<<CANTTOUCH
					<html>
						<head>
						
						</head>
						
						<body style="padding:0px; margin:0px; background-color: #888; padding-top: 18px;">
							<center><img style="max-height: 600px;" src="../Images/General/CantTouchThis.png" /></center>
						</body>
					</html>
CANTTOUCH;

		die($page); 
	}
?>