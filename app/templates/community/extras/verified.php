<?php
$extra = <<<TMP
	<h1 class="H1-2" style="text-align: center;">
		Congratulations, {{{u}}}!<br />
		You're bona fide verified.
	</h1>

	<img src="/assets/images/General/SkyDrawn.png" style="float: right; position: absolute; right: 50px; bottom: 0px;" />
	<img src="/assets/images/General/Batty1.png" style="float: left; position: absolute; left: 30px; top: 50px;" />
	<img src="/assets/images/General/Car2.png" style="float: left; position: absolute; left: 80px; bottom: 20px; transform: rotate(24deg);
	-ms-transform: rotate(24deg);
	-webkit-transform: rotate(24deg);" />

	<p style="width: 50%; display: block; margin: 0px auto; text-align: center;">
		You're officially a verified member of the Mad Splash community. Not only have you gained access to all our awesome, but you've also recieved a shiny new forum badge in recognition of your accomplishment!

		<br />
		<br />

		For sake of convenience, you can log in <b>right here</b>.
	</p>


	<form action="../Resources/Scripts/PHP/Hubs/CommunityHub.php?action=login" method="post" style="padding-left: 12px; display: block; margin: 24px auto; width: 50%;">

		<label for="username">Username</label> <input type="text" name="username" style="width: 100%;" value="{{{u}}}">
		<label for="password">Password</label> <input type="password" name="password" style="width: 100%;">
		<br />

		<input class="checkbox" type="checkbox" name="rememberMe" value="rememberMe"> <label for="rememberMe">Remember Me</label> <br />

		<br /><br />

		<input class="blueButton" type="submit" name="loginsubmit" value="LOGIN">

		<div class="clear"> </div>
	</form>
TMP;
?>
