<?php

	class Project {
		/* -- User info variables; used for the functions here -- */
		private $ID;
		private $Type;
		private $Desc;
		private $Title;
		private $Cover;
		private $LastUpdate;

		/* -- User class constructor -- */
		public function __construct($id) {
			$this->ID = $id;

			$this->getProject($id);
		}

		/* -- Used in the constructor to access the DB and get all the user's info and populate the variables -- */
		private function getProject($id) {
			// Open database connection
			$db = new DatabaseModule();

			// Get user information from the DB
			$getProject = $db->Handle->prepare('SELECT * FROM ms_projects WHERE id = :id');
			$getProject->bindValue(':id', $id, PDO::PARAM_INT); // bind $id to the placeholder
			$getProject->execute();

			$ProjectInfo = $getProject->fetch(); // get the results from the query

			$getProject->closeCursor(); // close the SELECT query from continuing its search

			// Populate the variables
			$this->ID         = $ProjectInfo["id"];
			$this->Type       = $ProjectInfo["type"];
			$this->Desc       = $ProjectInfo["desc"];
			$this->Title      = $ProjectInfo["title"];
			$this->Cover      = $ProjectInfo["cover"];
			$this->lastUpdate = betterDate($ProjectInfo["lastUpdate"]);
		}

		/* -- Returns whatever info needed at the moment -- */
		public function __get($what) {
			if(property_exists($this, $what)) {
				return $this->{$what};
			} else {
				return null;
			}
		}

		/* -- Updates a value in the DB belonging to the user -- */
		public function update($what) {

		}
	}
?>
