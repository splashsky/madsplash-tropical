<?php  
$template = <<<TMP
	<div id="articleComment">
		<div class="left">
			<img src="../Resources/Images/Avatars/{{{a}}}" alt="{{{u}}}" title="{{{u}}}" />
			<a href="#">{{{u}}}</a>
		</div>
		
		<div class="right" style="position: relative; height: 100%; display: block;">
			<p style="padding: 8px 8px 8px 0px;">
				{{{c}}}
			</p>
		</div>
		
		<div class="clear"> </div>
		
		<span class="footer"> Posted on {{{d}}}</span>
		
		<div class="clear"> </div>
	</div>
TMP;
?>