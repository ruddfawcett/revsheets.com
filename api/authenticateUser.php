<?php
	header('Content-Type: application/json');

	$username = $_POST['username'];
	$password = $_POST['password'];

	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$stmt = $db->prepare('SELECT * FROM users WHERE username=:username AND password=:password');
	$stmt->execute(array(':username' => $username,':password' => $password));
	$rowCount = $stmt->rowCount();

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	if ($rowCount == 1) {
		$userID = $resultsArray[0]['userID'];
		$username = $resultsArray[0]['username'];
		$name = explode(" ", $resultsArray[0]['name']);
		$first_name = $name[0];
		$last_name = $name[1];
		$email = $resultsArray[0]['email'];
		$last_login = $resultsArray[0]['last_login'];
		$active = $resultsArray[0]['active'];

		$groupQuery = $db->prepare('SELECT * FROM groupMembers WHERE userID=:userID');
		$groupQuery->execute(array(':userID' => $userID));
		$groupArray = $groupQuery->fetchAll(PDO::FETCH_ASSOC);

		$finalArray['result'] = true;
		$alert = array('title' => 'Success', 'body' => 'You were successfully logged in.');
		$finalArray['alert'] = $alert;

		$finalArray['userInfo'] = array(
									'username' => $username,
									'first_name' => $first_name,
									'last_name' => $last_name,
									'email' => $email,
									'userID' => $userID,
									'last_login' => $last_login,
									'active' => $active);

		foreach ($groupArray as $group) {
			$groupName = $group['groupName'];
			$groupID = $group['groupID'];
			$admin = $group['admin'];

			$fileQuery = $db->prepare('SELECT * FROM files WHERE userID=:userID AND groupID=:groupID');
			$fileQuery->execute(array(':userID' => $userID, ':groupID' => $groupID));
			$fileArray = $fileQuery->fetchAll(PDO::FETCH_ASSOC);

			$files = array();

			foreach ($fileArray as $file) {
				$title = stripslashes($file['title']);
				$fileID = $file['fileID'];
				$groupID = $file['groupID'];
				$fileState = $file['active'];

				$eachFile = array(
								'file_title' => $title,
								'fileID' => $fileID,
								'groupID' => $groupID,
								'active' => $fileState);

				$files[] = $eachFile;
			}
			$eachGroup = array(
							'group_name' => $groupName,
							'groupID' => $groupID,
							'admin' => $admin,
							'files' => $files);

			$finalArray['groups'][] = $eachGroup;
		}
	}
	else {
		$alert = array('title' => 'Unauthorized User', 'body' => 'We were not able to find you in our database!  Please check your username and password.');

		$finalArray['error'] = true;
		$finalArray['alert'] = $alert;
	}

	$return = json_encode($finalArray,true);

	echo $return;

	exit();
?>
