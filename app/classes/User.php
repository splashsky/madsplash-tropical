<?php

	class User {
		/* -- User info variables; used for the functions here -- */
		private $Email;
		private $Title;
		private $UserID;
		private $Avatar;
		private $Gender;
		private $Badges;
		private $AboutMe;
		private $WhatsUp;
		private $Username;
		private $BirthDay;
		private $JoinDate;
		private $PostCount;
		private $UserTitle;
		private $Reputation;
		private $isVerified;
		private $MemberLevel;

		/* User Database Handle */
		private $DB = null;

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		public function __construct($id) {
			// Open database connection
			$DM = new DatabaseModule();
			$DM->createUserHandle();
			$this->DB = $DM->userHandle;


			$this->UserID = $id;

			$this->getUser($id);
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		private function getUser($id) {
			$db = $this->DB;

			// Get username and ID from the database
			$getUser = $db->prepare('SELECT * FROM ms_users WHERE id = :id');
			$getUser->bindValue(':id', $id, PDO::PARAM_INT); // bind $id to the placeholder
			$getUser->execute();

			$User = $getUser->fetch(); // get the results from the query

			$getUser->closeCursor(); // close the SELECT query from continuing its search

			// Populate the variable(s)
			$this->Username = $User['username'];

			$this->Title       = $User['title'];
			$this->Email       = $User['email'];
			$this->Gender      = $User['gender'];
			$this->Badges      = $User['badges'];
			$this->AboutMe     = $User['blurb'];
			$this->WhatsUp     = $User['status'];
			$this->BirthDay    = $User['bday'];
			$this->JoinDate    = $User['joindate'];
			$this->PostCount   = $User['posts'];
			$this->Avatar      = $User['avatar'];
			$this->Reputation  = $User['reputation'];
			$this->MemberLevel = $User['mlevel'];
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

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
