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
		--- The Community Module
		--- This module is for the general listing and displaying of things.
		--- This module was crafted by Skylear. : )
		--- Copyright (c) Mad Splash, 2014, all rights reserved.
	*/

	class CommunityModule {
		/* --- Variables - data the module needs to work with. --- */
		private $cookieName = "UserCookie";
		private $db         = null; // user handle
		private $Handle     = null;

		/* --- Constructor - creates the module's instance. --- */
		public function __construct() {
			// Instantiate the Database Module
			$DM = new DatabaseModule();
			$DM->createUserHandle();

			// Assign the db handle
			$this->db     = $DM->userHandle;
			$this->Handle = $DM->Handle;
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		public function registerUser() {
			// Initialize necessary things.
				session_start();         // this'll be used for error handling
				$ErrorArray = array();   // for a list of errors
				$db         = $this->db; // easier DB handle

			// Prepare any database queries.
				$checkAvailable   = $db->prepare('SELECT username, email FROM ms_users WHERE username = :username');
				$registerUser     = $db->prepare('
					INSERT INTO ms_users SET
					username   = :un,
					email      = :e,
					gender     = :g,
					country    = :c,
					bday       = :bd,
					password   = :pw,
					salt       = :s,
					verifycode = :vc,
					joindate   = CURDATE()
				');

			// Sanitize and check the username.
				if(!empty($_POST['username'])) {
					if(preg_match('![^a-z0-9_ ]!i', $_POST['username'])) { $ErrorArray[] = "2"; }

					$checkAvailable->execute(array(':username' => $_POST['username']));
					$userCheck = $checkAvailable->fetch();

					if($userCheck['username'] == $_POST['username']) { $ErrorArray[] = "3"; }

					if(strlen($_POST['username']) > 25) { $ErrorArray[] = "3"; }
				} else {
					$ErrorArray[] = "1";
				}

			// Sanitize and check the email address.
				if(!empty($_POST['email'])) {
					// if(!checkEmail($_POST['email'])) { $ErrorArray[] = "6"; }

					if($userCheck['email'] == $_POST['email']) { $ErrorArray[] = "7"; }
				} else {
					$ErrorArray[] = "5";
				}

			// Sanitize and hash passwords.
				if(!empty($_POST['password']) && !empty($_POST['confirmpass'])) {
					if($_POST['password'] !== $_POST['confirmpass']) { $ErrorArray[] = "10"; }

					$salt = generateSalt(53);

					$hashedPass = hashPass($_POST['password'], $salt, $_POST['username']);
				} else {
					if(empty($_POST['password']))    { $ErrorArray[] = "8"; }
					if(empty($_POST['confirmpass'])) { $ErrorArray[] = "9"; }
				}

			// Finish off registration. First check for any errors!
				if(count($ErrorArray) == 0) {
					$code      = md5(mt_rand(0, 2147483647)) . md5(mt_rand(0, 2147483647));
					$birthDate = date("Y-m-d", mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']));

					$registerUser->execute(array(
						':un' => $_POST['username'],
						':e'  => $_POST['email'],
						':g'  => $_POST['sex'],
						':c'  => $_POST['country'],
						':bd' => $birthDate,
						':pw' => $hashedPass,
						':s'  => $salt,
						':vc' => $code
					));

					$EU = str_replace(" ", "+", $_POST['username']);

					sendMail("Verify your Mad Splash account!", array("u" => $_POST['username'], "vc" => $code, 'eu' => $EU), $_POST['email'], "verification");

					header('Location: http://localhost:8888/community/index.php?page=registered');
				} else {
					$ErrorArray[] = "11";
					$_SESSION['error'] = $ErrorArray;

					header('Location: http://localhost:8888/community/index.php?page=register');
					exit;
				}
		}

		/* ------------------------------------------------------------------------------------------------------- */
		/* ------------------------------------------------------------------------------------------------------- */

		public function loginUser() {
			session_start();
			$db         = $this->db;
			$ErrorArray = array();
			$login_okay = false;

			$userQuery = $db->prepare("SELECT id, username, password, salt, mlevel, verifycode FROM ms_users WHERE LOWER(username) = :username");

			if(!empty($_POST['username']) && !empty($_POST['password'])) {

				$userQuery->execute(array(':username' => strtolower($_POST['username'])));


				if($userQuery->rowCount() > 0) {
					$theUser = $userQuery->fetch();

					$check_password = hashPass($_POST['password'], $theUser['salt'], $_POST['username']);

					if($check_password == $theUser['password']) {
						$login_okay = true;
					} else {
						$ErrorArray[] = "12";
					}
				} else {
					$ErrorArray[] = "11";
				}

				if($login_okay) {
					unset($theUser['password']);
					unset($theUser['salt']);

					if(isset($_POST["rememberMe"])) {
						$TimeTillSelfDestruct = time() + 31536000; $rememberMe = 1;
					} else {
						$TimeTillSelfDestruct = 0; $rememberMe = 0;
					}

					$cookie = $theUser["id"] . " " . $theUser['username'] . " " . md5($theUser["verifycode"]);
					setcookie("UserCookie", $cookie, $TimeTillSelfDestruct, "/", "", 0);

					header('Location: http://localhost:8888');
					exit;
				} else {
					$_SESSION['error'] = $ErrorArray;

					header('Location: http://localhost:8888/community/index.php?page=login');
					exit;
				}
			} else {
				$ErrorArray[] = "13";
				$_SESSION['error'] = $ErrorArray;

				header('Location: http://localhost:8888/community/index.php?page=login');
				exit;
			}
		}

		/* ------------------------------------------------------------------------------------------------------- */
		/* ------------------------------------------------------------------------------------------------------- */

		public function logoutUser($id) {
			if(!empty($_COOKIE[$this->cookieName])) {
				$user = explode(" ", $_COOKIE[$this->cookieName]);

				if($user[0] == $id) {
					setcookie($this->cookieName, "", time()-100000, "/", "", 0);
				} else {
					header("Location: http://localhost:8888");
					exit;
				}
			}

			header("Location: http://localhost:8888");
			exit;
		}

		/* ------------------------------------------------------------------------------------------------------- */
		/* ------------------------------------------------------------------------------------------------------- */

		public function VerifyUser($VC, $Username) {
			$db = $this->db;

			$Verify = $db->prepare('UPDATE ms_users SET mlevel = 3 WHERE username = :u');
			$Verify->bindValue(':u', $Username, PDO::PARAM_INT);

			$GetUser = $db->prepare('SELECT username, mlevel FROM ms_users WHERE verifycode = :vc');
			$GetUser->bindValue(':vc', $VC, PDO::PARAM_STR);
			$GetUser->execute();

			if($GetUser->rowCount() == 1) {
				$DaUser = $GetUser->fetch();

				if($DaUser['username'] == $Username) {
					if($DaUser['mlevel'] <= 2 ) {
						$Verify->execute();

						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		public function postAComment($artID) {
			$handle = $this->Handle;
			$author = explode(" ", $_COOKIE[$this->cookieName]);

			$upCCount    = $handle->prepare('UPDATE ms_articles SET articleComments = articleComments + 1 WHERE id = :artID');
			$postComment = $handle->prepare('INSERT INTO ms_articlecomments SET commentAuthor = :aid, commentContent = :content, commentDate = NOW(), articleID = :artid');


			$postComment->execute(
				array(
					':aid'     => $author[0],
					':content' => $_POST['theComment'],
					':artid'   => $artID
				)
			);
			$upCCount->execute(array(':artID' => $artID));

			header('Location: http://localhost:8888/blog/blog.php?do=read&article=' . $artID . '#comments');
		}

		/* ------------------------------------------------------------------------------------------------------- */
		/* ------------------------------------------------------------------------------------------------------- */

		public function episodeComment($epID) {
			$handle = $this->Handle;
			$author = explode(" ", $_COOKIE[$this->cookieName]);

			$upCCount    = $handle->prepare('UPDATE episodes SET comments = comments + 1 WHERE id = :epID');
			$postComment = $handle->prepare('INSERT INTO episodecomments SET commentAuthor = :aid, commentContent = :content, commentDate = NOW(), showID = :epid');


			$postComment->execute(
				array(
					':aid'     => $author[0],
					':content' => $_POST['theComment'],
					':epid'    => $epID
				)
			);
			$upCCount->execute(array(':epID' => $epID));

			header('Location: http://localhost:8888/projects/show.php?show=' . $_GET['show'] . '&episode=' . $epID . '#comments');
		}

/* ------------------------------------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------------------------------- */

		public function sendEmail() {

		}
	}
?>
