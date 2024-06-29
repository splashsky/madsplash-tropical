<?php
	/*
		--- The Display Module
		--- This module is for the general listing and displaying of things.
		--- This module was crafted by Skylear.
		--- Copyright (c) Mad Splash, 2014, all rights reserved.
	*/

	class DisplayModule {

		private $BlogCovers        = '/assets/images/Covers/BlogPosts/';
		private $ProjectThumbnails = '/assets/images/Thumbs/';

		private $ListedArticle;
		private $Article4Reading;
		private $FeaturedArticle;

		private $ProjectThumbnail;

		private $CommentBox;
		private $CommentForm;


		/* --- Constructor - creates the module's instance. --- */
		public function __construct() {
            /*
			$this->ListedArticle    = GetTemplate('articles/listedarticle');
			$this->Article4Reading  = GetTemplate('articles/articlebody');
			$this->FeaturedArticle  = GetTemplate('articles/featured');

			$this->ProjectThumbnail = GetTemplate('projects/thumbnail');

			$this->CommentBox       = GetTemplate('comments/commentbox');
			$this->CommentForm      = GetTemplate('comments/commentform');
            */
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* --- Module Functions - the meat and purpose of the module. --- */
		public function Articles($limit) {

			$db = new DatabaseModule();

			$articles = $db->getData('ms_articles', 'id', '', 'LIMIT ' . $limit, 'ORDER BY articleDate DESC');

			if($db->countRows('ms_articles', '') > 0) {

				foreach($articles as $articleID) {

					$article = new Article($articleID['id']);
					$author  = new User($article->Author);

					echo ParseTemplate($this->ListedArticle, array('t' => magicClean($article->Title), 'l' => "blog.php?do=read&article=" . $article->ID, 'd' => BBCode(magicClean($article->Description)), 'co' => $this->BlogCovers . $article->Cover, 'u' => $author->Username, 'pd' => $article->PostDate, 'c' => $article->Comments));

				}

			} else {

				echo '<span style="font-size: 26px;">Hmm. Strangely enough, we don\'t have any articles!</span>';
			}

		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* Display Articles - display a slider-like list of projects. */
		public function Projects($type) {

			$db = new DatabaseModule();

			$projects = $db->getData('ms_projects', 'id', 'WHERE type="' . $type . '"', '', 'ORDER BY id DESC');

			if(count($projects) > 0) {

				foreach($projects as $aProject) {

					$project = new Project($aProject['id']);
					$nospace = str_replace(' ', '', $project->Title);

					$img = $this->ProjectThumbnails . $type . '/' . $nospace . 'Thumb.png';

					echo ParseTemplate($this->ProjectThumbnail, array('t' => $project->Title, 'ns' => $nospace, 'img' => $img));

				}

			} else {

				echo "<h3>It seems we have no " . strtolower($type)  . "s.</h3>";

			}

		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* Display Featured - display an assorted set of featured content in the sidebar. */
		public function sideFeatured($what) {
			$db = new DatabaseModule;

			// prepare SQL statements
			$getArticle = $db->Handle->prepare('SELECT id FROM ms_articles WHERE featured = "true" ORDER BY articleDate DESC LIMIT 1');

			switch($what) {
				case "Article":
					// get the article
					$getArticle->execute();
					$article = $getArticle->fetch();

					// create new article object
					$featured = new Article($article['id']);

					// display the article
					echo ParseTemplate($this->FeaturedArticle, array('id' => $featured->ID, 'c' => $this->BlogCovers . $featured->Cover, 't' => $featured->Title));
			}
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* Display Front Page Articles - specially formatted for the front page */
		public function frontPageArticles() {
			$db = new DatabaseModule();

			$getArticles = $db->Handle->prepare('SELECT id FROM ms_articles ORDER BY articleDate DESC LIMIT 5');
			$getArticles->execute();
			$articles = $getArticles->fetchAll();

			$first = true;

			foreach($articles as $articleID) {
				$article = new Article($articleID['id']);

				$Link = "blog/blog.php?do=read&article=" . $article->ID;

				if($article->Comments < 10) {
					$cBox = "<div class=\"cBox\"> <span style=\"position: relative; left: 3px;\">". $article->Comments . "</span> </div>";
				} else {
					$cBox = "<div class=\"cBox\"> <span>". $article->Comments . "</span> </div>";
				}

				if($first) {
					echo <<<FIRST
						<a class="latestArticle" href="{$Link}">
							<img src="/assets/images/Covers/BlogPosts/{$article->Cover}.png" alt="{$article->Title}" title="{$article->Title}" />

							{$cBox}

							<div class="headline">
								{$article->Title}
							</div>
						</a>
FIRST;

					$first = false;
				} else {
					echo <<<ARTICLE
						<a class="article" href="{$Link}">
							<img src="/assets/images/Covers/BlogPosts/{$article->Cover}.png" />

							{$cBox}

							<div class="headline">{$article->Title}</div>
						</a>
ARTICLE;
				}
			}
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* Display an article for reading - when a user wants to read an article, we give it to them in this format. */
		public function articleForReading($id) {

			$article = new Article($id);
			$author  = new User($article->Author);

			echo ParseTemplate($this->Article4Reading, array('title' => $article->Title, 'date' => $article->PostDate, 'author' => $author->Username, 'cover' => $this->BlogCovers . $article->Cover, 'content' => BBCode(magicClean($article->Content))));

			/* ----------------------------------- */
			/* -------- Article Comments --------- */

			echo "<a id=\"comments\">&nbsp;</a>";

			if($article->Comments == 1) { $oneOrMore = $article->Comments . " Comment"; } else { $oneOrMore = $article->Comments . " Comments"; }

			echo '<section id="articleComments" style="margin-bottom: 24px;"> <h2>' . $oneOrMore . '</h2>';

			if($article->Comments == 0) {

				echo '<p style="padding: 4px 8px;">There aren\'t any comments to read.</p>';

			} else {

				$db = new DatabaseModule();

				$aCommentsList = $db->Handle->prepare('SELECT * FROM ms_articlecomments WHERE articleID = :id');
				$aCommentsList->bindValue(':id', $id, PDO::PARAM_INT);
				$aCommentsList->execute();

				$inList = $aCommentsList->fetchAll();

				foreach($inList as $ID) {

					$comment = new ArticleComment($ID['id']);
					$poster  = new User($comment->Author);

					echo ParseTemplate($this->CommentBox, array('a' => $poster->Avatar, 'u' => $poster->Username, 'c' => BBCode(magicClean($comment->Content)), 'd' => $comment->PostDate));

				}

			}

			if(!empty($_COOKIE['UserCookie'])) { echo ParseTemplate($this->CommentForm, array('aid' => $_GET['article'])); }

			echo '</section>';

		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		/* Display the special Projects category nav - with a list of all current types of projects. */
		public function categoryNav() {
			$types = array('Game', 'Book', 'Show');

			if(!empty($_GET['type'])) {
				$active = $_GET['type'];
			} else {
				$active = '';
			}

			echo '<div id="categoryNav"> <p>Choose a category</p>';

			foreach($types as $type) {
				if(strtolower($type) == $active) {
					$class = 'class="active"';
				} else {
					$class = '';
				}

				echo '<a href="projects.php?a=main&type=' . strtolower($type) . '" ' . $class . '>' . $type . 's</a>';
			}

			echo '</div>';
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		public function daPromos() {
			if(!empty($_COOKIE['UserCookie'])) {
				echo '<p style="padding: 4px 8px;">Aww... we don\'t have any promos right now...</p>';
			} else {
				echo '<div class="registerButtonBIG">
					<div style="position: relative; top: 20px; padding-left: 6px;">
						<h2>Register Here</h2>
						<p style="padding-left: 8px; padding-right: 4px;">and get perks like a weekly newsletter, access to the forums, and free monies!</p>
					</div>
				</div>';
			}
		}
	}
?>
