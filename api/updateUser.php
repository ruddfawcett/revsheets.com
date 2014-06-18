<?php
	header('Content-Type: application/json');

	$userID = $_POST['userID'];
	$firstName = $_POST['first_name'];
	$lastName = $_POST['last_name'];
	$userEmail = $_POST['email'];

	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$stmt = $db->prepare('SELECT * FROM users WHERE userID=:userID');
	$stmt->execute(array(':userID' => $userID));
	$rowCount = $stmt->rowCount();

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	if ($rowCount == 1) {
		$name = ucfirst(strtolower($firstName))." ".ucfirst(strtolower($lastName));

		$stmt = $db->prepare("UPDATE users SET name=?,email=? WHERE userID=?");
		$stmt->execute(array($name, $userEmail,$userID));

		$affected_rows = $stmt->rowCount();

		if ($affected_rows == 1) {
			$finalArray['result'] = true;
		}
		else if ($affected_rows == 0) {
			//$alert = array('title' => 'Unauthorized User', 'body' => 'We were not able to find you in our database!  Please check your username and password.');

			$finalArray['result'] = true;
		}
		else {
			$alert = array('title' => 'Error updating your account!', 'body' => 'We were not able to find you in our database!  Please check your username and password.');

			$finalArray['error'] = true;
			$finalArray['alert'] = $alert;
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
