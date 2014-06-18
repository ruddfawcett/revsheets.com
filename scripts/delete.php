<?php
	if (array_key_exists('groupID',$_GET)) {

		require('session.php');

		$stmt = $db->prepare("SELECT * FROM groupMembers WHERE username=:username AND admin=:admin AND groupID=:groupID");
		$stmt->execute(array(':username' => $_SESSION['username'], ':admin'=>1, ':groupID' => $_GET['groupID']));
		$row_count = $stmt->rowCount();

		if ($row_count > 0) {
			$stmt = $db->prepare("DELETE FROM groupMembers WHERE groupID=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));

			$stmt = $db->prepare("DELETE FROM files WHERE groupID=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));

			$stmt = $db->prepare("DELETE FROM subjects WHERE groupID=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));

			$stmt = $db->prepare("DELETE FROM groups WHERE groupID=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));

			rmdir('/home/files/'.$_GET['groupID']);
		}
		header("Location: http://revsheets.com");
	}
?>
