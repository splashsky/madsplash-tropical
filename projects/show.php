<?php

	define('SAFE', true);
	
	include("Pieces/header.htm");
	
	
	
	$CommentForm = GetTemplate('comments/episodeform');
	
	if(!empty($_GET['show'])) { $showid = $_GET['show']; } else { $showid = 1; }
	
	if(!empty($_GET['episode'])) { $epnum = $_GET['episode']; } else { $epnum = 1; }
	
	$episode = new Show($showid);
	$epdata  = $episode->EpisodeArray[$epnum - 1];
	
	
	if($epdata['comments'] == 1) { $oneOrMore = $epdata['comments'] . " Comment"; } else { $oneOrMore = $epdata['comments'] . " Comments"; }
	
	if($epdata['comments'] == 0) {
		
		$epComments = '<p style="padding: 4px 8px;">No comments? Be the first to comment on this video!</p>';
		
	} else {
		
		$epComments = $episode->GetEpisodeComments($_GET['episode']);
		
	}
	
	if(!empty($_COOKIE['MadSplashUser'])) { $form = ParseTemplate($CommentForm, array('epid' => $_GET['episode'], 'id' => $_GET['show'])); } else { $form = ''; }
	
	
	
	$data = array(
		't'        => $epdata['title'],
		'l'        => $epdata['embed'],
		'd'        => $epdata['description'],
		'thumb'    => $episode->Thumbnail,
		'comments' => $epComments,
		'ccount'   => $oneOrMore,
		'form'     => $form
	);
	
	
	include("Pieces/Templates/show.php");
	
	foreach($data as $a => $b) {
		
	    $template = str_replace("{{{" . $a . "}}}", $b, $template);
	    
	}
	
	echo $template;
	
	
	
	include("Pieces/footer.htm");
	
?>