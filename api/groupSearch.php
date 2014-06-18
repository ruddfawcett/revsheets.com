<?php
	header('Content-Type: application/json');

	$search = trim($_POST['query']);
	$groupID = $_POST['groupID'];

	$db = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'username', 'password');

	$terms = explode(" ", $search);

	$query = "SELECT * FROM files WHERE groupID='$groupID' AND active=1 AND";

	foreach ($terms as $term) {
		$i++;
		if($i == 1) {
			$query .= " dump LIKE '%$term%' ";
		}
		else {
			$query .= "OR dump LIKE '%$term%' ";
		}
	}

	//echo $query;

	$stmt = $db->prepare($query);
	$stmt->execute();

	$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$finalArray = array();

	foreach ($resultsArray as $result) {
 		$getUser = $db->prepare("SELECT * FROM `users` WHERE userID=:userID");
		$getUser->execute(array(':userID' => $result['userID']));

		$resultsArray2 = $getUser->fetchAll(PDO::FETCH_ASSOC);
		$result2 = $resultsArray2[0];

		$groupArray = array("groupID" => $result['groupID'], "sheetSubject" => $result['subject'], "title" => $result['title'], "fileID" => $result['fileID'], "uploaded" => $result['date'], "ext" => $result['ext'], "test_date"=> $result['testDate'], "dl_count" => $result['dl'], "description" => $result['description'], "author" => $result2['name'], "author_username" => $result2['username'], "author_email" => $result2['email']);

		$finalArray[] = $groupArray;
	}

	echo json_encode($finalArray, true);
?>
