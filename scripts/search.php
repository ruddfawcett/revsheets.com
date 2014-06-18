<?php require('session.php'); ?>
<div class='container well'>
	<?php
		if ($_POST['query']) {

			$search = $_POST['query'];
			$search = trim($search);

			if ($search != "") {

				$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `username`=:username");
				$stmt->execute(array(':username' => $_SESSION['username']));
				$row_count = $stmt->rowCount();
				if ($row_count > 0) {
					echo "<div class='row'>";
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$stmt2 = $db->prepare("SELECT * FROM files WHERE groupID=:groupID");
						$stmt2->execute(array(':groupID' => $row['groupID']));

						while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

							$terms = explode(" ", $search);

							$query = "SELECT * FROM files WHERE `groupID`='".$row2['groupID']."' AND";

							foreach ($terms as $each) {

								$i++;

								if ($i == 1) {
									$query .= " dump LIKE '%".$each."%' ";
								}
								else {
									$query .= " OR dump LIKE '%".$each."%' ";
								}
							}

							$query = str_replace('AND OR','AND',$query);

							$stmt3 = $db->prepare($query);
							$stmt3->execute();
							$row_count3=$stmt3->rowCount();

							if ($row_count3 > 0) {
								echo $row_count3;
								while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
									echo $row3['title']."<br>";
								}
							}
							else {
								echo "<h3>No results found for \"".$search."\".</h3>";
							}
			}
			else {
				echo "<h3>Please enter a term to search.</h3>";
			}
		}
		else {
			echo "<h3>Please enter a term to search.</h3>";
		}
	?>


</div>
