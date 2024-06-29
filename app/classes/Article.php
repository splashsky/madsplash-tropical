<?php

	class Article {

		private $ID;
		private $Title;
		private $Cover;
		private $Author;
		private $Content;
		private $PostDate;
		private $Comments;
		private $Description;


		public function __construct($id) {

			$this->ID = $id;

			$this->getArticle($id);

		}


		private function getArticle($id) {

			$db = new DatabaseModule();

			$getArticle = $db->Handle->prepare('SELECT * FROM ms_articles WHERE id = :id');
			$getArticle->bindValue(':id', $id, PDO::PARAM_INT);
			$getArticle->execute();

			$ArticleInfo = $getArticle->fetch();

			$getArticle->closeCursor();


			$this->Title       = $ArticleInfo['articleName'];
			$this->Cover       = $ArticleInfo['articleCover'];
			$this->Author      = $ArticleInfo['articleAuthor'];
			$this->Content     = $ArticleInfo['articleContent'];
			$this->PostDate    = betterDate($ArticleInfo['articleDate']);
			$this->Comments    = $ArticleInfo['articleComments'];
			$this->Description = $ArticleInfo['articleDescription'];

		}


		public function __get($what) {

			if(property_exists($this, $what)) {

				return $this->{$what};

			} else {

				return null;

			}

		}


		public function update($what) {

		}
	}
?>
