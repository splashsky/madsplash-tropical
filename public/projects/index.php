<?php
    require '../app/bootstrap.php';

    echo render('header');

	$CommentForm = GetTemplate('comments/episodeform');

    $showid = !empty($_GET['show']) ? $_GET['show'] : 1;
    $epnum  = !empty($_GET['episode']) ? $_GET['episode'] : 1;

	$episode = new Show($showid);
	$epdata  = $episode->EpisodeArray[$epnum - 1];

    $oneOrMore = $epdata['comments'] == 1 ? $epdata['comments'] . " Comment" : $epdata['comments'] . " Comments";

	if ($epdata['comments'] == 0) {
		$epComments = '<p style="padding: 4px 8px;">No comments? Be the first to comment on this video!</p>';
	} else {
		$epComments = $episode->GetEpisodeComments($_GET['episode']);
	}

	if(!empty($_COOKIE['MadSplashUser'])) {
        $form = render('comments/episodeform', ['epid' => $_GET['episode'], 'id' => $_GET['show']]);
    } else {
        $form = '';
    }

    echo render('projects/show', [
		't'        => $epdata['title'],
		'l'        => $epdata['embed'],
		'd'        => $epdata['description'],
		'thumb'    => $episode->Thumbnail,
		'comments' => $epComments,
		'ccount'   => $oneOrMore,
		'form'     => $form
    ]);

	echo render('footer');
