<?php 
$template = <<<TMP
	<html>
		<head>
			<style>
				html { background-color: #cacbca; }
				body { width: 800px; margin: 0px auto; background-color: #cacbca; }
				
				div#head { width: 100%; height: 200px; background: #4aa1ef url('http://localhost:8888/Resources/Images/Backgrounds/EmailHead.jpg'); margin-bottom: -48px; box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2); }
				div#body { width: 82%; min-height: 70px; margin: 0px auto; margin-bottom: 20px; background-color: #fffffe; padding-bottom: 16px; }
				
				h1 { color: #666; font: bold 28px Arial, Helvetica, Geneva, sans-serif; padding: 8px 0px 0px 12px; height: 20px; }
				p { width: 90%; padding-bottom: 17px; font-size: 16px; color: #444; line-height: 20px; display: block; margin: 0px auto; }
				
				img.logo { width: 450px; transform: rotate(-1deg); -ms-transform: rotate(-1deg); -webkit-transform: rotate(-1deg); display: block; position: relative; top: 20px; left: 18px; }
			</style>
		</head>
		
		
		<body>
		
			<div id="head">
				<img class="logo" src="http://localhost:8888/Resources/Images/Logos/NewLogo.png" />
			</div>
			
						
												
			<div id="body">
				<h1>Hey there, {{{u}}}!</h1>
				
				<p>
					Thanks for signing up on Mad Splash! With this account, you'll have free access to all our content. Well, except the stuff that costs moolah. All you have to do now is just verify your account!
					
					<br />
					<br />
					
					<a href="http://localhost:8888/community/verify.php?code={{{vc}}}&username={{{u}}}">Click here to verify your account!
				</p>
			</div>
			
		</body>
	</html>
TMP;
?>