<?php
	require('session.php');
	//require('ReviewSheetsClass.php');

	//$ReviewSheets = new ReviewSheets;
	switch ($_POST['type']) {
		case "login":

			if (empty($_POST['username']) || empty($_POST['password'])) {
				echo "<div class='alert alert-error'><strong>Error!</strong> Please enter values for both fields!</div>";
			}
			else {
				$stmt = $db->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
				$stmt->execute(array(':username' => $_POST['username'], ':password' => hash('sha256',$_POST['password']."review")));
				$row_count = $stmt->rowCount();
					if ($row_count == 1) {
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$resultsArray = $results[0];
						$_SESSION['username'] = $resultsArray['username'];
						$_SESSION['userID'] = $resultsArray['userID'];
						$_SESSION['name'] = $resultsArray['name'];
						$_SESSION['email'] = $resultsArray['email'];

						$stmt = $db->prepare("UPDATE users SET last_login=? WHERE username=?");
						$stmt->execute(array(date('F j, Y'), $resultsArray['username']));

						echo "<script type='text/javascript'>window.location.href=window.location.href</script>";
					}
					else {
						echo "<div class='alert alert-error'><strong>Error!</strong> We can't find you in our database, please double check your username and password!</div>";
					}
				}
		break;
		case "signup";
			if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
				echo "<div class='alert alert-error'><strong>Error!</strong> Please enter values for all fields!</div>";
			}
			else {
				if ($_POST['password'] != $_POST['password2']) {
					echo "<div class='alert alert-error'><strong>Error!</strong> Your passwords didn't match!</div>";
				}
				else {
					function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){$str = '';$count = strlen($charset);while ($length--) {$str .= $charset[mt_rand(0, $count-1)];}return $str;}
					$stmt = $db->prepare("SELECT * FROM users WHERE username=:username");
					$stmt->execute(array(':username' => $_POST['username']));
					$row_count = $stmt->rowCount();
					if ($row_count == 0) {
						$rand = randString(13);
						$stmt = $db->prepare("SELECT * FROM users WHERE userID=:userID");
						$stmt->execute(array(':userID' => $rand));
						$row_count = $stmt->rowCount();
						if ($row_count == 0) {
							$stmt = $db->prepare("INSERT INTO users(name,password,userID,email,username,date) VALUES(:name,:password,:userID,:email,:username,:date)");
							$stmt->execute(array(':name'=> ucfirst(strtolower($_POST['firstname']))." ".ucfirst(strtolower($_POST['lastname'])),':password' => hash('sha256',$_POST['password']."review"), ':userID' => $rand, ':email'=>$_POST['email'], ':username'=>str_replace(' ','',$_POST['username']), ':date'  => date('F j, Y')));

							$stmt = $db->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
							$stmt->execute(array(':username' => $_POST['username'], ':password' => hash('sha256',$_POST['password']."review")));
							$row_count = $stmt->rowCount();
							if ($row_count == 1) {
								$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
								$resultsArray = $results[0];
								$_SESSION['username'] = $resultsArray['username'];
								$_SESSION['userID'] = $resultsArray['userID'];
								$_SESSION['name'] = $resultsArray['name'];
								$_SESSION['email'] = $resultsArray['email'];

								$stmt = $db->prepare("UPDATE users SET last_login=? WHERE username=?");
								$stmt->execute(array(date('F j, Y'), $resultsArray['username']));

								echo "<div class='alert alert-success'><strong>Success!</strong> Sweet!  You've set up an account!  Hold on, and we'll log you in.</div><script type='text/javascript'>window.setTimeout(function(){location.reload()},3000);</script>";
							}
						}
						else {
							echo "<div class='alert alert-error'><strong>Whoops!</strong> Something happened at our end.  Can you resubmit the form please?</div>";
						}
					}
					else {
						echo "<div class='alert alert-error'><strong>Error!</strong> That username has already been taken! Please try a new one!</div>";
					}
				}
			}
		break;
		case "newGroup";
			if (empty($_POST['groupName'])) {
				echo "<div class='alert alert-error modalError'><strong>Error!</strong> Please enter a group name!</div>";
			}
			else {
				function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){$str = '';$count = strlen($charset);while ($length--) {$str .= $charset[mt_rand(0, $count-1)];}return $str;}
				$stmt = $db->prepare("SELECT * FROM groups WHERE groupID=:groupID");
				$rand = randString(13);
				$stmt->execute(array(':groupID' => $rand));
				$row_count = $stmt->rowCount();
				if ($row_count == 0) {
						$stmt = $db->prepare("INSERT INTO groups(name,dateCreated,groupID) VALUES(:name,:dateCreated,:groupID)");
						$stmt->execute(array(':name'=> $_POST['groupName'],':dateCreated' => date('F j, Y'), ':groupID' => $rand));

						$stmt = $db->prepare("INSERT INTO groupMembers(username,groupID,groupName,admin,userID) VALUES(:username,:groupID,:groupName,:admin,:userID)");
						$stmt->execute(array(':username'=> $_SESSION['username'],':groupID' => $rand, ':groupName' => $_POST['groupName'], ':admin'=>1, ':userID'=>$_SESSION['userID']));

						$path = "/home/content/72/9996272/html/files/".$rand;
						mkdir($path, 705);

						$stmt = $db->prepare("SELECT * FROM groups WHERE groupID=:groupID");
						$stmt->execute(array(':groupID' => $rand));
						$row_count = $stmt->rowCount();
						if ($row_count == 1) {
							$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$resultsArray = $results[0];
							$groupID = $resultsArray['groupID'];
							echo "<script type='text/javascript'>window.location.href='?groupID=".$groupID."';</script>";
						}
				}
				else {
					echo "<div class='alert alert-error'><strong>Whoops!</strong> Something happened at our end.  Can you resubmit the form please?</div>";
				}
			}
		break;
		case "newSubject";
			if (empty($_POST['subjectName'])) {
				echo "<div class='alert alert-error modalError'><strong>Error!</strong> Please enter a subject!</div>";
			}
			else {
				$stmt = $db->prepare("SELECT * FROM subjects WHERE name=:name AND groupID=:groupID");
				$stmt->execute(array(':name' => $_POST['subjectName'],':groupID' => $_POST['groupID']));
				$row_count = $stmt->rowCount();
				if ($row_count == 0) {
					$stmt = $db->prepare("INSERT INTO subjects(name,groupID) VALUES(:name,:groupID)");
					$stmt->execute(array(':name'=> $_POST['subjectName'],':groupID' => $_POST['groupID']));
					echo "<script type='text/javascript'>window.location.href='?groupID=".$_POST['groupID']."&subject=".$_POST['subjectName']."';</script>";
				}
				else {
					echo "<div class='alert alert-error'><strong>Warning!</strong> You already have a subject with the name ".$_POST['subjectName'].".</div>";
				}
			}
		break;
		case "newMember";
			if (empty($_POST['memberUsername'])) {
				echo "<div class='alert alert-error modalError'><strong>Error!</strong> Please enter a username!</div>";
			}
			else {
				$ifUser = $db->prepare("SELECT * FROM users WHERE username=:username");
				$ifUser->execute(array(':username' => $_POST['memberUsername']));
				$results = $ifUser->fetchAll(PDO::FETCH_ASSOC);
				$resultsArray = $results[0];
				$userID = $resultsArray['userID'];
				$ifUser = $ifUser->rowCount();

				if ($ifUser == 1) {
					$stmt = $db->prepare("SELECT * FROM groupMembers WHERE username=:username AND groupID=:groupID");
					$stmt->execute(array(':username' => $_POST['memberUsername'], ':groupID' => $_POST['groupID']));
					$row_count = $stmt->rowCount();
					if ($row_count == 0) {
						$stmt2 = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
						$stmt2->execute(array(':groupID' => $_POST['groupID']));
						$resultsArray = $stmt2->fetchAll(PDO::FETCH_ASSOC);
						$groupName = $resultsArray[0]['name'];

						$stmt3 = $db->prepare("INSERT INTO groupMembers(username,groupName,groupID,userID) VALUES(:username,:name,:groupID,:userID)");
						$stmt3->execute(array(':username'=> $_POST['memberUsername'],':name' => $groupName,':groupID' => $_POST['groupID'], ':userID'=>$userID));

						echo "<script type='text/javascript'>window.location.href=window.location.href</script>";
					}
					else {
						echo "<div class='alert alert-info'><strong>Already done!</strong> You already have a user with the name ".$_POST['memberUsername']." in your group.</div>";
					}
				}
				else {
					echo "<div class='alert alert-danger'><strong>Sorry!</strong> There is no user with the username ".$_POST['memberUsername'].".  They might not have signed up yet, or you have the wrong username.</div>";
				}
			}
		break;
		case "updateAccount":
			if (empty($_POST['firstname2']) || empty($_POST['lastname2']) || empty($_POST['email2'])) {
				echo "<div class='alert alert-error'><strong>Error!</strong> Please enter values for all fields!</div>";
			}
			else {
				$name = explode(" ", $_SESSION['name']);
				$name = ucfirst(strtolower($_POST['firstname2']))." ".ucfirst(strtolower($_POST['lastname2']));

				$stmt = $db->prepare("UPDATE users SET name=?,email=?,siteTheme=? WHERE userID=?");
				$stmt->execute(array($name, $_POST['email2'], $_POST['siteTheme'],$_SESSION['userID']));

				$affected_rows = $stmt->rowCount();

				if ($affected_rows == 1) {
					$_SESSION['name'] = ucfirst(strtolower($_POST['firstname2']))." ".ucfirst(strtolower($_POST['lastname2']));
					$_SESSION['email'] = $_POST['email2'];

					echo "<div class='alert alert-success'><strong>Success!</strong> Your account has been updated.</div><script type='text/javascript'>window.setTimeout(function(){location.reload()},2000);</script>";
				}
				else if ($affected_rows == 0) {
					echo "<script type='text/javascript'>$('#account').modal('hide');</script>";
				}
				else {
					echo "<div class='alert alert-error'><strong>Error!</strong> There was an error updating your account.</div>";
				}
			}
		break;
		default:
			echo "<div class='alert alert-error modalError'><strong>Error!</strong> Uh oh! You broke me!</div>";
		break;
	}
?>
