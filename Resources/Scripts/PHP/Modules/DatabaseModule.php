<?php
	if(!defined('SAFE')) {
		$page = <<<CANTTOUCH
					<html>
						<head>

						</head>

						<body style="padding:0px; margin:0px; background-color: #888; padding-top: 18px;">
							<center><img style="max-height: 600px;" src="../../../Images/General/CantTouchThis.png" /></center>
						</body>
					</html>
CANTTOUCH;

		die($page);
	}

	/*
		--- The Database Module
		--- This module is for the general CRUD methods.
		--- This module was crafted by Skylear. : )
		--- Copyright (c) Mad Splash, 2014, all rights reserved.
	*/

	class DatabaseModule {
		/* --- Variables - data the module needs to work with. --- */
		private $Handle     = null;
		private $userHandle = null;
		private $FHandle    = null;

		/* --- Constructor - creates the module's instance. --- */
		public function __construct() {
			$DBUsername = 'root';
			$DBPassword = 'root';
			$DBName     = 'database';

			try {
				$DBHandle = new PDO('mysql: host=localhost; dbname=' . $DBName, $DBUsername, $DBPassword);
			} catch(PDOException $ex) {
				die("Oops, we failed to the connect to the database. The error: " . $ex->getMessage() . ".");
			}

			$DBHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$DBHandle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$this->Handle = $DBHandle;
		}

		public function createUserHandle() {
			$DBUsername = 'root';
			$DBPassword = 'root';
			$DBName     = 'database';

			try {
				$DBHandle = new PDO('mysql: host=localhost; dbname=' . $DBName, $DBUsername, $DBPassword);
			} catch(PDOException $ex) {
				die("Oops, we failed to the connect to the database. The error: " . $ex->getMessage() . ".");
			}

			$DBHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$DBHandle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$this->userHandle = $DBHandle;
		}

		public function createFHandle() {
			$DBUsername = 'root';
			$DBPassword = 'root';
			$DBName     = 'database';

			try {
				$DBHandle = new PDO('mysql: host=localhost; dbname=' . $DBName, $DBUsername, $DBPassword);
			} catch(PDOException $ex) {
				die("Oops, we failed to the connect to the database. The error: " . $ex->getMessage() . ".");
			}

			$DBHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$DBHandle->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$this->FHandle = $DBHandle;
		}

		public function __get($what) {
			if(property_exists($this, $what)) {
				return $this->{$what};
			} else {
				return null;
			}
		}

		/* --- Module Functions - the meat and purpose of the module. --- */
		/* Create Table - for creating a table when need be.
		* @param string $name - the name of the table to be created.
		* @param string $columns - a long string containing the columns to be made.
		*/
		public function createTable($name, $columns) {
			// No need for creating tables for the time being.
		}

		/* Select Data - used for getting data from the database.
		* @return array $selectedRos - an array containing the data.
		*/
		public function getData($from, $retrieve, $condition, $limit, $orderby) {
			$Handle = $this->Handle;

			$query = 'SELECT ' . $retrieve . ' FROM ' . $from . ' ' . $condition . ' ' . $orderby . ' ' . $limit ;

			$selectQuery = $Handle->prepare($query);
			$selectQuery->execute();
			$selectedRows = $selectQuery->fetchAll();

			return $selectedRows;
		}

		public function countRows($which, $condition) {
			$Handle = $this->Handle;

			$query = 'SELECT COUNT(*) FROM ' . $which . ' ' . $condition;
			$count = $Handle->query($query);

			return $count->fetch();
		}
	}
?>
