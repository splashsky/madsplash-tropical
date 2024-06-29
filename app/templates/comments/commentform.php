<?php  
$template = <<<TMP
	<form action="../Resources/Scripts/PHP/Hubs/CommunityHub.php?action=postAComment&artID={{{aid}}}" method="post" style="padding-left: 12px; border-top: 3px solid #efefef; margin-top: 36px; padding-top: 16px;">
		<h3>Post a comment</h2>
		<textarea name="theComment" style="width: 76%; min-height: 60px; margin-bottom: 8px; float: left;"></textarea>
		
		<input class="blueButton" type="submit" name="postsubmit" value="POST" style="float: right;">
		
		<div class="clear"> </div>
	</form>
TMP;
?>