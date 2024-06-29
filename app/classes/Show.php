<?php

	class Show {

		private $ID;
		private $Title;
		private $ShowID;
		private $Thumbnail;
		private $Description;
		private $EpisodeArray;

		private $EpisodeComments;

		private $db;

		private $ThumbPath = "http://localhost:8888//assets/images/Thumbs/Show/";



		public function __construct($id) {

			$DBM = new DatabaseModule();
			$this->db = $DBM->Handle;

			$this->ShowID = $id;

			$this->CommentBox  = GetTemplate('comments/commentbox');
			$this->CommentForm = GetTemplate('comments/commentform');

			$this->getData();
			$this->GetEpisodeList();

		}


		private function getData() {

			$get = $this->db->prepare('SELECT * FROM ms_projects WHERE showid = :id');
			$get->bindValue(':id', $this->ShowID, PDO::PARAM_INT); // bind $id to the placeholder
			$get->execute();

			$data = $get->fetch();

			$get->closeCursor();

			$this->ID          = $data["id"];
			$this->Title       = $data["title"];
			$this->Thumbnail   = $this->ThumbPath . $data["thumbnail"];
			$this->Description = $data["desc"];

		}


		public function __get($what) {

			if(property_exists($this, $what)) {

				return $this->{$what};

			} else {

				return null;

			}

		}


		public function GetEpisodeList() {

			$get = $this->db->prepare("SELECT * FROM episodes WHERE `show` = :s ORDER BY id DESC");
			$get->bindValue(':s', $this->ShowID, PDO::PARAM_INT);
			$get->execute();

			$episodes = $get->fetchAll();

			$get->closeCursor();

			$this->EpisodeArray = $episodes;

		}


		public function GetEpisodeComments($id) {

			$get = $this->db->prepare('SELECT * FROM episodecomments WHERE showID = :id');
			$get->bindValue(':id', $id, PDO::PARAM_INT);
			$get->execute();

			$data = $get->fetchAll();

			$list = array();

			foreach($data as $ID) {

				$comment = new EpisodeComment($ID['id']);
				$poster  = new User($comment->Author);

				$list[] = ParseTemplate($this->CommentBox, array('a' => $poster->Avatar, 'u' => $poster->Username, 'c' => BBCode(magicClean($comment->Content)), 'd' => $comment->PostDate));

			}

			return $list;

		}

	}
?>
