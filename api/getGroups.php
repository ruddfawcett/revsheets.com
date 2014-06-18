<?php
	header('Content-Type: application/json');

	$userID = $_POST['userID'];
		
	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$stmt = $db->prepare("SELECT * FROM groupMembers WHERE userID=:userID");
	$stmt->execute(array(':userID' => $userID));

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	foreach ($resultsArray as $result) {
		$getGroup = $db->prepare("SELECT * FROM `groups` WHERE groupID=:groupID");
		$getGroup->execute(array(':groupID' => $result['groupID']));

		$resultsArray2 = $getGroup->fetchAll(PDO::FETCH_ASSOC);

		$groupArray = array("name" => $resultsArray2[0]['name'], "groupID" => $resultsArray2[0]['groupID']);

		$finalArray[] = $groupArray;
	}

	echo json_encode($finalArray, true);
?>
