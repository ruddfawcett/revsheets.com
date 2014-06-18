<?php
	header('Content-Type: application/json');

	$groupID = $_POST['groupID'];

	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$stmt = $db->prepare("SELECT * FROM subjects WHERE groupID=:groupID ORDER BY name");
	$stmt->execute(array(':groupID' => $groupID));

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	foreach ($resultsArray as $result) {
		$getGroup = $db->prepare("SELECT * FROM `files` WHERE groupID=:groupID AND subject=:subject AND active=:active");
		$getGroup->execute(array(':groupID' => $result['groupID'], ':subject' => $result['name'], ':active' => 1));

		$sheetCount = $getGroup->rowCount();

		$groupArray = array("subjectName" => $result['name'], "groupID" => $result['groupID'], "sheetCount" => $sheetCount);

		$finalArray[] = $groupArray;
	}

	echo json_encode($finalArray, true);
?>
