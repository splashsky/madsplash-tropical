<?php
$template = <<<TMP
	<h2 class="articleTitle">{{{title}}}</h2>
	
	<p style="padding-left: 12px; margin-bottom: 2px">posted by <a href="#">{{{author}}}</a> on {{{date}}}.</p>
	
	<img class="articleCover" src="{{{cover}}}.png" alt="{{{title}}}" title="{{{title}}}" />
	
	<div class="articleContent">
		{{{content}}}
	</div>
	
	<div style="height: 12px; background-color: #ddd; margin: 18px 0px; position: relative; right: 8px;">&nbsp;</div>
TMP;
?>