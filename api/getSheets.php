<?php
	header('Content-Type: application/json');

	$groupID = $_POST['groupID'];
	$subject = $_POST['subject'];

	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$stmt = $db->prepare("SELECT * FROM files WHERE groupID=:groupID AND subject=:subject AND active=:active");
	$stmt->execute(array(':groupID' => $groupID, ':subject' => $subject, ':active' => 1));

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	foreach ($resultsArray as $result) {
 		$getUser = $db->prepare("SELECT * FROM `users` WHERE userID=:userID");
		$getUser->execute(array(':userID' => $result['userID']));

		$resultsArray2 = $getUser->fetchAll(PDO::FETCH_ASSOC);
		$result2 = $resultsArray2[0];

		$groupArray = array("title" => $result['title'], "fileID" => $result['fileID'], "uploaded" => $result['date'], "ext" => $result['ext'], "test_date"=> $result['testDate'], "dl_count" => $result['dl'], "description" => $result['description'], "author" => $result2['name'], "author_username" => $result2['username'], "author_email" => $result2['email']);

		$finalArray[] = $groupArray;
	}

	echo json_encode($finalArray, true);
?>
