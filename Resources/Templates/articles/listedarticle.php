<?php
$template = <<<TMP
	<li>
	<section class="head">
		<h2><a href="{{{l}}}">{{{t}}}</a></h2> 
		<div class="comments">{{{c}}} comments</div>
		
		<div class="clear"> </div>
	</section>
	
	<img class="cover" src="{{{co}}}.png" alt="{{{t}}}" title="{{{t}}}" />
	
	<p>{{{d}}}</p>
	
	<section class="foot">
		<div class="left">
			<a class="more" href="{{{l}}}" style="margin: 4px 0px 0px 4px; font-size: 12px;">Read more &raquo;</a>
		</div>
	
		<div class="right" style="position: relative; top: 10px;">
			posted by <a href="#">{{{u}}}</a> on {{{pd}}}
		</div>
		
		<div class="clear"> </div>
	</section>
</li>
TMP;
?>