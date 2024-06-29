<?php

	class EpisodeComment {

		private $ID;
		private $Author;
		private $Content;
		private $PostDate;
		private $ShowID;



		public function __construct($id) {
			$this->ID = $id;

			$this->getComment($id);
		}


		private function getComment($id) {

			$db = new DatabaseModule();

			$get = $db->Handle->prepare('SELECT * FROM episodecomments WHERE id = :id');
			$get->bindValue(':id', $id, PDO::PARAM_INT);
			$get->execute();

			$data = $get->fetch();

			$get->closeCursor();

			$this->Author    = $data['commentAuthor'];
			$this->Content   = $data['commentContent'];
			$this->PostDate  = betterDate($data['commentDate']);
			$this->ArticleID = $data['showID'];

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
