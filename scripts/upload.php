<?php
	if (empty($_POST['title']) || empty($_POST['description']) || empty($_FILES['sheet']['name'])) {
		echo "<div class='alert alert-error'><strong>Error!</strong> Please enter values for all fields!</div>";
	}
	else {
		function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){$str = '';$count = strlen($charset);while ($length--) {$str .= $charset[mt_rand(0, $count-1)];}return $str;}
		$rand = randString(13);
		$stmt = $db->prepare("SELECT * FROM files WHERE fileID=:fileID");
		$stmt->execute(array(':fileID' => $rand));
		$row_count = $stmt->rowCount();
		if ($row_count == 0) {
			$dump = $_POST['title']." ".$_POST['description']." ".$_POST['subject'];
			$stmt = $db->prepare("INSERT INTO files(fileID,title,description,subject,testDate,date,ext,groupID,userID) VALUES(:fileID,:title,:description,:subject,:testDate,:date,:ext,:groupID,:userID)");
			$stmt->execute(array(':fileID' => $rand,':title' => $_POST['title'],':description' => $_POST['description'],':subject'=> $_POST['subject'],':testDate' => $_POST['month']." ".$_POST['day'].", ".$_POST['year'],':date' => date('F j, Y'),':ext' => strtoupper(pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION)),':groupID' => $_POST['groupID'],':userID' => $_SESSION['userID']));

			move_uploaded_file($_FILES['sheet']['tmp_name'], "files/".$_GET['groupID']."/".$rand.pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION));

			echo "<div class='alert alert-success'><strong>Success!</strong> Sweet!  You've set uploaded a sheet!</div><script type='text/javascript'>window.setTimeout(function(){location.href=sheets.php?groupID=".$_POST['groupID']."&subject=".$_POST['subject']."()},3000);</script>";
		}
		else {
			echo "<div class='alert alert-error'><strong>Whoops!</strong> Something happened at our end.  Can you resubmit the form please?</div>";
		}
	}
?>
