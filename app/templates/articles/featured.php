<?php 
$template = <<<TMP
	<div class="featured">
		<div class="miniCover">
			<img class="miniCover" src="{{{c}}}.png" />
		</div>
		
		
		<a href="http://localhost:8888/blog/blog.php?do=read&article={{{id}}}" style="font-weight: bold; font-size: 18px">
			{{{t}}}
		</a>
		
		<br />
		
		<div class="clear"> </div>
	</div>
TMP;
?>