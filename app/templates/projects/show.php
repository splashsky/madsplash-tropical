<?php

$template = <<<TMP
<script>
	document.getElementsByTagName('title')[0].innerHTML = "{{{t}}} | Mad Splash!";
</script>

<div style="width: 960px; margin: 0px auto; margin-bottom: 20px;">
	<iframe style="box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.5);" src="{{{l}}}" width="960" height="388" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>
</div>

<section id="body">
	<div style="width: 100%; margin-bottom: 4px; height: 1px;">&nbsp;</div>
	
	<section id="leftColumn" style="padding: 4px 12px;">
		
		<section style="border-bottom: 2px solid rgba(0, 0, 0, 0.1); padding-bottom: 8px;">
			
			<div class="left" style="width: 18%;">
				<img src="{{{thumb}}}" style="width: 100px;" />
			</div>
			
			<div class="right" style="width: 82%;">
				<a href="#" style="font: 24px Impact, Arial, Geneva, sans-serif;">{{{t}}}</a><br />
				
				<p>
					{{{d}}}
				</p>
			</div>
			
			<div class="clear"> </div>
			
		</section>
		
		<section style="padding-top: 16px; padding-bottom: 18px; border-bottom: 2px solid rgba(0, 0, 0, 0.1);">
			
			<h1>Other Episodes</h1>
			<ul style="margin-left: 28px; list-style: none;">
				<li><a href="#">Episode 1</a></li>
				<li><a href="#">Episode 2</a></li>
				<li><a href="#">Episode 3</a></li>
			</ul>
			
			
		</section>
		
		<!--<a id="comments">&nbsp;</a>
		<section>
			<h2 style="font-size: 24px;">{{{ccount}}}</h2>
			
			{{{comments}}}
			
			{{{form}}}
		</section>-->
		
	</section>
	
	
	
	<section id="rightColumn2" style="margin-top: 8px; padding: 48px 0px;">
		
	</section>
	
	<div class="clear"> </div>
</section>
TMP;

?>