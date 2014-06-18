<?php
	require ("session.php");

	if ($_GET['fileID']) {
		$fileID = $_GET['fileID'];

		$stmt = $db->prepare("SELECT * FROM files WHERE fileID=:fileID");
		$stmt->execute(array(':fileID' => $fileID));

		$row_count = $stmt->rowCount();

		if ($row_count ==1) {
			$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$resultsArray = $resultsArray[0];
			$groupID = $resultsArray['groupID'];

			$stmt2 = $db->prepare("SELECT * FROM groupMembers WHERE username=:username AND groupID=:groupID");
			$stmt2->execute(array(':username' => $_SESSION['username'], ':groupID' => $groupID));

			$row_count = $stmt2->rowCount();

			if ($row_count == 1) {
					$dl = $resultsArray['dl'];
					$dl = $dl + 1;

					$stmt3 = $db->prepare("UPDATE files SET dl=? WHERE fileID=? AND groupID=?");
					$stmt3->execute(array($dl, $fileID,$groupID));

					$filePath = $fileID.".".strtolower($resultsArray['ext']);

					$original_filename = "../files/".$groupID."/".$filePath;
					$new_filename = $resultsArray['title'].".".strtolower($resultsArray['ext']);

					// headers to send your file
					header("Content-Length: " . filesize($original_filename));
					header('Content-Disposition: attachment; filename="' . $new_filename . '"');

					// upload the file to the user and quit
					readfile($original_filename);
					//exit;
			}
			else {
				header("Location: http://www.revsheets.com");
			}
		}
		else {
			header("Location: http://www.revsheets.com");
		}
	}
	else {
		header("Location: http://www.revsheets.com");		
	}
?>
