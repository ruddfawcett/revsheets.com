<div class='container well path'>
	<div class='row' style='margin-left: auto; margin-right: auto;'>
		<form style='padding: 0; margin: 0;' action='' method='get'>
			<div class="input-append">
				 <input class="span11" id="appendedInputButton" type="text" style='margin-top: 10px; margin-bottom: 0; ' placeholder='Please enter a search query...' name='q' value="<?php echo $_GET['q']; ?>">'>
			 	 <input type='submit' class="btn" style='margin-top: 10px; margin-bottom: 0;' value='Search'>
			</div>
		</form>
	</div>
</div>
<div id='searchReturn'>
	<div class='container well'>
		<?php if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
			<?php
				if ($_GET['q']) {
	
					$search = $_GET['q'];
					$search = trim($search);
	
					if ($search != "") {
						$stmt = $db->prepare("SELECT * FROM groupMembers WHERE username=:username");
						$stmt->execute(array(':username' => $_SESSION['username']));
						
						$userArray = array();
						while ($groups = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$tempArray = array();
							
							$tempArray['groupID'] = $groups['groupID'];
							$userArray[] = $tempArray;
						}
						
						echo "<div class='row'>";
						
						foreach ($userArray as $groupID) {
							$terms = explode(" ", $search);
							$query = "SELECT * FROM files WHERE groupID='".$groupID['groupID']."' AND ";
							foreach ($terms as $each) {	
							
								$i++;				
								if($i == 1) {
					
									$query .= "dump LIKE '%$each%' ";
					
								}					
								else
									$query .= "OR dump LIKE '%$each%' ";
							}
							$query = str_replace("AND OR","AND",$query);
							
							$stmt4 = $db->prepare($query);
							$stmt4->execute();
							$found = $stmt4->rowCount();
							
							if ($found > 0) {
							
								while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {		
									$stmt3 = $db->prepare("SELECT * FROM users WHERE userID=:userID");
									$stmt3->execute(array(':userID' => $row['userID']));
									$resultsArray = $stmt3->fetchAll(PDO::FETCH_ASSOC);
									$resultsArray = $resultsArray[0];
									$fullName = $resultsArray['name'];
									$authorEmail = $resultsArray['email'];
											
									echo "
										<div id='".preg_replace('/[^a-zA-Z1-9]/', '', $row['title'])."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
										  <div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h3 id='myModalLabel'>".$row['title']."<small> by ".$fullName."</small></h3>
										  </div>
										  <div class='modal-body'>
										   <table class='table table-striped table-bordered'>
											  <tbody>
												<tr>
													<td><strong>Title</strong></td><td>".$row['title']."</td>
												  </tr>
												  <tr>
													<td><strong>Subject</strong></td><td>".$row['subject']."</td>
												  </tr>
												  <tr>
													<td><strong>Author</strong></td><td><a href='mailto:".$authorEmail."'>".$fullName."</td>
												  </tr>
												  <tr>
													<td><strong>Uploaded</strong></td><td>".$row['date']."</td>
												  </tr>
												  <tr>
													<td><strong>Test Date</strong></td><td>".$row['testDate']."</td>
												  </tr>
												  <tr>
													<td><strong>Description</strong></td><td>".$row['description']."</td>
												  </tr>
												  <tr>
													<td><strong>File Type</strong></td><td>".$row['ext']."</td>
												  </tr>
												  <tr>
													<td><strong>Downloads</strong></td><td>".$row['dl']."</td>
												  </tr>
												</tbody>
											</table>
										  </div>
										  <div class='modal-footer'>
											<a href='scripts/dl.php?fileID=".$row['fileID']."' class='btn btn-success' target='_blank'>Download Sheet</a>
											<button class='btn' data-dismiss='modal' aria-hidden='true'>Close</button>
										  </div>
										</div>
									";
									$ext = array("DOCX","JPEG","JPG","KEYNOTE","NUMBERS","PAGES","PDF","PNG","PPTX","RTF","TIFF","XLSX","ZIP");
									if (in_array($row['ext'], $ext)) {
										$path = "ext/".$row['ext'];
									}
									else {
										$path = "unknownFile";
									}
									if (strlen($row['title']) > 34) {
										$characters = floor(30 / 2);
										$sheetTitle = substr($row['title'], 0, $characters) . ' ... ' . substr($row['title'], -1 * $characters);
									}
									else {
										$sheetTitle = $row['title'];
									}
				
									echo "<a href='#".preg_replace('/[^a-zA-Z1-9]/', '', $row['title'])."' role='button' class='link' data-toggle='modal'><div class='span3 icon'><img src='images/".$path.".png'><span class='caption'>". $sheetTitle . "</span></div></a>";
								}
							}
							else {
								echo "<div class='span11'><h4>No results found.</h4></div>";
							}
						}
						
						echo "</div>";
					
					}
					else {
						echo "<h4>Please enter a term to search.</h4>";
					}
				}
				else {
					echo "<h4>Please enter a term to search.</h4>";
				}
			?>
		<?php else: ?>
			<h3>Please enter a term to search.</h3>
		<?php endif ?>
	</div>
</div>