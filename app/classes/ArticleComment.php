<?php

	class ArticleComment {

		private $ID;
		private $Author;
		private $Content;
		private $PostDate;
		private $ArticleID;


		public function __construct($id) {
			$this->ID = $id;

			$this->getArticleComment($id);
		}


		private function getArticleComment($id) {

			$db = new DatabaseModule();

			$getArticle = $db->Handle->prepare('SELECT * FROM ms_articlecomments WHERE id = :id');
			$getArticle->bindValue(':id', $id, PDO::PARAM_INT);
			$getArticle->execute();

			$ArticleInfo = $getArticle->fetch();

			$getArticle->closeCursor();

			$this->Author    = $ArticleInfo['commentAuthor'];
			$this->Content   = $ArticleInfo['commentContent'];
			$this->PostDate  = betterDate($ArticleInfo['commentDate']);
			$this->ArticleID = $ArticleInfo['articleID'];

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
