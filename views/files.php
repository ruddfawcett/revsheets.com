<script>
    $(document).ready(function(){    
        $("#alertDeleteLink").click(function () {
             $("#alertDelete").slideDown();
        });
    });
</script>
<div id="group" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return5&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModalLabel">New Group</h3>
			 </div>
			 <div id="return5" class="return"></div>
			 <div class="modal-body">
				<form action="" id="addGroup" method="post" onsubmit="addGroup();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputName">Group Name</label>
					  <div class="controls">
						 <input type="text" name="groupName" id="inputName" placeholder="School: Grade 11" />
						 <input type="hidden" value="newGroup" name='type'>
					  </div>
				   </div>
			 </div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return5&quot;).html(&quot;&quot;);">Close</a>
			 <input type="submit" class="btn btn-success" value="Create Group" />
			 </div>
			 </form>
		  </div>
<div id="settings" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return7&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModalLabel">Group Info</h3>
			 </div>
			 <div id="return7" class="return"></div>
			 <div class="modal-body">
				  <?php				  
				 		$stmt = $db->prepare("SELECT * FROM groupMembers WHERE username=:username AND admin=:admin AND groupID=:groupID");
						$stmt->execute(array(':username' => $_SESSION['username'], ':admin'=>1, ':groupID' => $_GET['groupID']));
						$row_count = $stmt->rowCount(); 
					?>		
					<?php if ($row_count > 0): ?>
				<ul id="myTab" class="nav nav-tabs">
				  <li class="active"><a href="#members" data-toggle="tab">Members</a></li>
				   <li><a href="#subjects" data-toggle="tab">Subjects</a></li>
				  <li><a href="#stats" data-toggle="tab">Detailed Info</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade in" id="stats">
						<div id='alertDelete' class='returnDelete' style='display: none;'><div class="alert alert-block alert-error fade in">
            				<button type="button" class="close" onclick="$('#alertDelete').slideUp();">×</button>
           						 <h4 class="alert-heading">Are you sure you wish to proceed?</h4>
           							 <p>By deleting this group, you are deleting everything associated with it.</p>
            							<p>
             								 <a class="btn btn-danger" href="scripts/delete.php?groupID=<?php echo $_GET['groupID']; ?>">Confirm Deletion</a> <a class="btn" href="#" onclick="$('#alertDelete').slideUp();">Cancel</a>
            							</p>
         				 </div></div>
						<table class="table table-striped table-bordered">
							  <tbody>
								<?php
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
										$stmt2 = $db->prepare("SELECT * FROM groups WHERE groupID=:groupID");
										$stmt2->execute(array(':groupID' => $row['groupID']));
			
										$stmt3 = $db->prepare("SELECT * FROM files WHERE groupID=:groupID");
										$stmt3->execute(array(':groupID' => $row['groupID']));
										$row_count3 = $stmt3->rowCount();
			
										$stmt4 = $db->prepare("SELECT * FROM groupMembers WHERE groupID=:groupID");
										$stmt4->execute(array(':groupID' => $row['groupID']));
										$row_count4 = $stmt4->rowCount();
			
										$stmt5 = $db->prepare("SELECT * FROM groupMembers WHERE groupID=:groupID AND admin=:admin");
										$stmt5->execute(array(':groupID' => $row['groupID'],':admin'=>1));
										$row_count5 = $stmt5->rowCount();
										
										$stmt6 = $db->prepare("SELECT * FROM subjects WHERE groupID=:groupID");
										$stmt6->execute(array(':groupID' => $row['groupID']));
										$row_count6 = $stmt6->rowCount();
			
										while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
											echo "<tr>
													<td><strong>Name</strong></td><td>".$row2['name']."</td>
												  </tr>
												  <tr>
													<td><strong>Sheets</strong></td><td>".$row_count3."</td>
												  </tr>
												  <tr>
													<td><strong>Subjects</strong></td><td>".$row_count6."</td>
												  </tr>
												  <tr>
													<td><strong>Members</strong></td><td>".$row_count4."</td>
												  </tr>
												  <tr>
													<td><strong>Admins</strong></td><td>".$row_count5."</td>
												  </tr>
												  <tr>
													<td><strong>Created</strong></td><td>".$row2['dateCreated']."</td>
												  </tr>";
										}
									}
								?>
							</tbody>
						</table>
						
						<a href='#' class='btn btn-large btn-block btn-danger' id='alertDeleteLink'>Delete Group</a>
						</div>
					<div class="tab-pane fade in active" id="members">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
								  <th>Name</th>
								  <th>Username</th>
								  <th>Role</th>
								  <th>Sheets</th>
								  <th>Actions</th>
								</tr>
							  </thead>
							  <tbody>
								<?php
									$stmt7 = $db->prepare("SELECT * FROM groupMembers WHERE groupID=:groupID");
									$stmt7->execute(array(':groupID' => $_GET['groupID']));
									$row_count = $stmt7->rowCount();
							
									while($row3 = $stmt7->fetch(PDO::FETCH_ASSOC)) {
									
										$stmt8 = $db->prepare("SELECT * FROM users WHERE username=:username");
										$stmt8->execute(array(':username' => $row3['username']));
										$resultsArray = $stmt8->fetch(PDO::FETCH_ASSOC);
										$name = $resultsArray['name'];
										$userID = $resultsArray['userID'];
										
										$stmt9 = $db->prepare("SELECT * FROM files WHERE userID=:userID AND groupID=:groupID");
										$stmt9->execute(array(':userID' => $userID, ':groupID' => $_GET['groupID']));
										$sheetsUploaded = $stmt9->rowCount();
										
										if ($row3['admin'] == 1) {
											$groupRole = "Admin";
										}
										else {
											$groupRole = "Member";
										}
									
										echo "<tr>
												<td>".$name."</td>
												<td>".$row3['username']."</td>
												<td>".$groupRole."</td>
												<td>".$sheetsUploaded."</td>
												<td><a href='#' class='btn btn-small' onclick='alert(\"Sorry!  This feature is coming soon!\");'>Admin</a><a href='' onclick='alert(\"Sorry!  This feature is coming soon!\");' class='btn btn-danger btn-small' style='margin-left: 10px;'>Kick</a></td>
											  </tr>";
									}
								?>
								</tbody>
							</table>
						</div>
					<div class="tab-pane fade in" id="subjects">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
								  <th>Name</th>
								  <th>Sheets</th>
								  <th>Actions</th>
								</tr>
							  </thead>
							  <tbody>
								<?php
									$stmt10 = $db->prepare("SELECT * FROM subjects WHERE groupID=:groupID");
									$stmt10->execute(array(':groupID' => $_GET['groupID']));
									$row_count = $stmt10->rowCount();
							
									while($row4 = $stmt10->fetch(PDO::FETCH_ASSOC)) {
									
										$stmt11 = $db->prepare("SELECT * FROM files WHERE subject=:subject AND groupID=:groupID");
										$stmt11->execute(array(':subject' => $row4['name'], ':groupID'=>$_GET['groupID']));
										$sheetCount = $stmt11->rowCount();
									
										echo "<tr>
												<td>".$row4['name']."</td>
												<td>".$sheetCount."</td>
												<td><a href='#' class='btn btn-small' onclick='alert(\"Sorry!  This feature is coming soon!\");'>Edit</a><a href='' onclick='alert(\"Sorry!  This feature is coming soon!\");' class='btn btn-danger btn-small' style='margin-left: 10px;'>Delete</a></td>
											  </tr>";
									}
								?>
								</tbody>
							</table>
						</div>
				</div>
						<?php else: ?>
							<h3>Nope, sorry, you don't have permission to do that!</h3>
						<?php endif ?>
			</div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return7&quot;).html(&quot;&quot;);">Close</a>
			 </div>
			 </form>
		  </div>
		  </div>
<div id="subject" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return4&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModalLabel">Add Subject</h3>
			 </div>
			 <div id="return4" class="return"></div>
			 <div class="modal-body">
				<form action="" id="addSubject" method="post" onsubmit="addSubject();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputName">Subject</label>
					  <input type="hidden" value="newSubject" name='type'>
					  <input type='hidden' value="<?php echo $_GET['groupID']; ?>" name="groupID">
					  <div class="controls">
						 <input type="text" name="subjectName" id="inputName" placeholder="History" />
					  </div>
				   </div>
			 </div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return4&quot;).html(&quot;&quot;);">Close</a>
			 <input type="submit" class="btn btn-success" value="Add Subject" />
			 </div>
			 </form>
		  </div>
<div id="member" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return8&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModalLabel">Add Member</h3>
			 </div>
			 <div id="return8" class="return"></div>
			 <div class="modal-body">
				<form action="" id="newMemberForm" method="post" onsubmit="newMember();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputName">Username</label>
					  <input type="hidden" value="newMember" name='type'>
					  <input type='hidden' value="<?php echo $_GET['groupID']; ?>" name="groupID">
					  <div class="controls">
						 <input type="text" name="memberUsername" id="inputName" placeholder="johndoe" />
					  </div>
				   </div>
			 </div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return8&quot;).html(&quot;&quot;);">Close</a>
			 <input type="submit" class="btn btn-success" value="Add Member" />
			 </div>
			 </form>
		  </div>
<?php
	if (!array_key_exists('groupID',$_GET) && !array_key_exists('subject',$_GET)) {
		echo "
			<div class='container well path'>
			<ul class='breadcrumb'>
				<li class='active'><h4>Sheets</h4></li>
				<a  href='#group' data-toggle='modal'><li class='pull-right'><h4><i class='icon-folder-open'></i> Create Group&nbsp;&nbsp;</h4></li></a>
			</ul>
			</div>
			<div class='container well'>
			";
		$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `username`=:username ORDER BY groupName");
		$stmt->execute(array(':username' => $_SESSION['username']));
		$row_count = $stmt->rowCount();		
		if ($row_count > 0) {
			echo "<div class='row'>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<a href='?groupID=".$row['groupID']."'><div class='span3 icon'><img src='images/folder.png'><span class='caption'>".str_replace('\\','',$row['groupName'])."</span></div></a>";
			}
			//echo "<a  href='#group' data-toggle='modal'><div class='span3 icon'><img src='images/addFolder.png'><span class='caption'>New Group</span></div></a>";
			echo "</div></div></div>";
		}
					// else if ($row_count == 1) {
			// 			$groupID = $stmt->fetch(PDO::FETCH_ASSOC);
			// 			$groupID = $groupID['groupID'];
			// 			$stmt = $db->prepare("SELECT * FROM subjects WHERE `groupID`=:groupID");
			// 			$stmt->execute(array(':groupID' => $groupID));
			// 			$row_count = $stmt->rowCount();		
			// 			if ($row_count > 0) {
			// 				echo "<div class='row'>";
			// 				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			// 					echo "<a href='?groupID=".$row['groupID']."&subject=".$row['name']."'><div class='span3 icon'><img src='images/folder.png'><span class='caption'>". $row['name'] . "</span></div></a>";
			// 				}
			// 				echo "</div></div></div>";
			// 			}
			// 			else {
			// 				echo "<h4>There are no sheets available! Would you like to <a href='upload.php'>upload</a> one now?</h4>";	
			// 			}
			// 		}
		else {
			echo "<h4>You haven't joined any groups!  Either create a group, or join one!</h4>";
			//echo "<div class='row'><a  href='#group' data-toggle='modal'><div class='span3 icon'><img src='images/addFolder.png'><span class='caption'>New Group</span></div></a></div></div>";	
		}
	}
	else if (array_key_exists('groupID',$_GET) && array_key_exists('subject',$_GET)) {
		$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `username`=:username AND groupID=:groupID");
		$stmt->execute(array(':username' => $_SESSION['username'], ':groupID' => $_GET['groupID']));
		$row_count = $stmt->rowCount();		
		$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$resultsArray = $resultsArray[0];
		$admin = $resultsArray['admin'];
		if ($row_count == 1) {
			$stmt = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));
			$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$resultsArray = $resultsArray[0];
			$groupName = $resultsArray['name'];
				if ($admin == 1) {
					$adminControls = "
						<a href='#settings' data-toggle='modal'><li class='pull-right'><h4><i class='icon-info-sign'></i> Group Info</h4></li></a>
						<a href='#subject' data-toggle='modal'><li class='pull-right'><h4><i class='icon-folder-open'></i> Add Subject&nbsp;&nbsp;</h4></li></a>";
				}
			echo "
				<div class='container well path'>
				<ul class='breadcrumb'>
					<li><a href='/'><h4>Sheets</a> <span class='divider'>/</span></h4></li>
					<li><a href='?groupID=".$_GET['groupID']."'><h4>".str_replace('\\','',$groupName)."</a> <span class='divider'>/</span></h4></li>
					<li class='active'> <h4>".$_GET['subject']."</h4></li>
					<a href='#member' data-toggle='modal'><li class='pull-right'><h4><i class='icon-user'></i> Add Member&nbsp;&nbsp;</h4></li></a>
					<a href='upload.php?groupID=".$_GET['groupID']."&subject=".$_GET['subject']."'><li class='pull-right'><h4>&nbsp;&nbsp;<i class='icon-file-alt'></i> Add Sheet&nbsp;&nbsp;</h4></li></a>".$adminControls."
				</ul>
				</div>
				<div class='container well'>
				";
			$stmt = $db->prepare("SELECT * FROM files WHERE `subject`=:subject AND `active`=:active AND `groupID`=:groupID ORDER BY title");
			$stmt->execute(array(':subject' => $_GET['subject'], ':active' => 1, ':groupID' => $_GET['groupID']));
			$row_count = $stmt->rowCount();		
			if ($row_count > 0) {
				echo "<div class='row'>";
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$stmt2 = $db->prepare("SELECT * FROM users WHERE userID=:userID");
					$stmt2->execute(array(':userID' => $row['userID']));
					$resultsArray = $stmt2->fetchAll(PDO::FETCH_ASSOC);
					$resultsArray = $resultsArray[0];
					$fullName = $resultsArray['name'];
					$authorEmail = $resultsArray['email'];
				echo "
					<div id='".preg_replace('/[^a-zA-Z1-9]/', '', stripslashes($row['title']))."' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					  <div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h3 id='myModalLabel'>".stripslashes($row['title'])."<small> by ".$fullName."</small></h3>
					  </div>
					  <div class='modal-body'>
					   <table class='table table-striped table-bordered'>
					   	  <tbody>
							<tr>
								<td><strong>Title</strong></td><td>".stripslashes($row['title'])."</td>
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
								<td><strong>Description</strong></td><td>".stripslashes($row['description'])."</td>
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
    				$sheetTitle = stripslashes(substr($row['title'], 0, $characters) . ' ... ' . substr($row['title'], -1 * $characters));
				}
				else {
					$sheetTitle = stripslashes($row['title']);
				}
				
				echo "<a href='#".preg_replace('/[^a-zA-Z1-9]/', '', $row['title'])."' role='button' class='link' data-toggle='modal'><div class='span3 icon'><img src='images/".$path.".png'><span class='caption'>". $sheetTitle . "</span></div></a>";
				}
				echo "</div></div></div>";
			}
			else {
				echo "<h4>There are no sheets available for ".$_GET['subject']."! Would you like to <a href='upload.php?groupID=".$_GET['groupID']."&subject=".$_GET['subject']."'>upload</a> one now?</h4>";	
			}
		}
		else {
			$stmt = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));
			$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$resultsArray = $resultsArray[0];
			$groupName = $resultsArray['name'];
			echo "
				<div class='container well path'>
				<ul class='breadcrumb'>
					<li><a href='/'><h4>Sheets</a> <span class='divider'>/</span></h4></li>
					<li><a href='?groupID=".$_GET['groupID']."'><h4>".str_replace('\\','',$groupName)."</a> <span class='divider'>/</span></h4></li>
					<li class='active'> <h4>".$_GET['subject']."</h4></li>
				</ul>
				</div>
				<div class='container well'>
				<h4>You aren't a member of the group ".$groupName."!  Ask the admin of your class to add you to the group, or create a new one!</h4>";	
		}
	}
	else {
		$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `username`=:username AND groupID=:groupID ORDER BY groupName");
		$stmt->execute(array(':username' => $_SESSION['username'], ':groupID' => $_GET['groupID']));
		$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$resultsArray = $resultsArray[0];
		$admin = $resultsArray['admin'];
		$row_count = $stmt->rowCount();	
		if ($row_count == 1) {
			$stmt = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));
			$resultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$resultsArray = $resultsArray[0];
			$groupName = $resultsArray['name'];
			if ($admin == 1) {
					$adminControls = "
						<a  href='#settings' data-toggle='modal'><li class='pull-right'><h4><i class='icon-info-sign'></i> Group Info</h4></li></a>
						<a  href='#subject' data-toggle='modal'><li class='pull-right'><h4><i class='icon-folder-open'></i> Add Subject&nbsp;&nbsp;</h4></li></a>";
				}
			echo "
				<div class='container well path'>
				<ul class='breadcrumb'>
					<li><a href='/'><h4>Sheets</a> <span class='divider'>/</span></h4></li>
					<li class='active'><h4>".str_replace('\\','',$groupName)."</h4></li>
					<a href='#member' data-toggle='modal'><li class='pull-right'><h4><i class='icon-user'></i> Add Member&nbsp;&nbsp;</h4></li></a>
					<a href='upload.php?groupID=".$_GET['groupID']."'><li class='pull-right'><h4>&nbsp;&nbsp;<i class='icon-file-alt'></i> Add Sheet&nbsp;&nbsp;</h4></li></a>".$adminControls."
				</ul>
				</div>
				<div class='container well'>
				";
			$stmt = $db->prepare("SELECT * FROM subjects WHERE `groupID`=:groupID ORDER BY name");
			$stmt->execute(array(':groupID' => $_GET['groupID']));
			$row_count = $stmt->rowCount();		
			if ($row_count > 0) {
				echo "<div class='row'>";
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<a href='?groupID=".$row['groupID']."&subject=".$row['name']."'><div class='span3 icon'><img src='images/folder.png'><span class='caption'>". $row['name'] . "</span></div></a>";
				}
// 				if ($admin == 1) {
// 					echo "<a  href='#subject' data-toggle='modal'><div class='span3 icon'><img src='images/addFolder.png'><span class='caption'>Add Subject</span></div></a>";
// 					echo "<a  href='#member' data-toggle='modal'><div class='span3 icon'><img src='images/userFolder.png'><span class='caption'>Add Member</span></div></a>";
// 					echo "<a  href='#settings' data-toggle='modal'><div class='span3 icon'><img src='images/gearFolder.png'><span class='caption'>Group Details</span></div></a>";
// 				}
				echo "</div></div></div>";
			}
			else {
				echo "<h4>There are no sheets available! Would you like to <a href='upload.php'>upload</a> one now?</h4>";
// 				if ($admin == 1) {
// 					echo "<a  href='#subject' data-toggle='modal'><div class='span3 icon'><img src='images/addFolder.png'><span class='caption'>Add Subject</span></div></a>";
// 					echo "<a  href='#member' data-toggle='modal'><div class='span3 icon'><img src='images/userFolder.png'><span class='caption'>Add Member</span></div></a>";
// 					echo "<a  href='#settings' data-toggle='modal'><div class='span3 icon'><img src='images/gearFolder.png'><span class='caption'>Group Details</span></div></a>";
// 				}	
			}
		}
		else {
			$stmt = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
			$stmt->execute(array(':groupID' => $_GET['groupID']));
			$groupName = $stmt->fetch(PDO::FETCH_ASSOC);
			$groupName = $groupName['groupID'];
			echo "
				<div class='container well path'>
				<ul class='breadcrumb'>
					<li><a href='/'><h4>Sheets</a> <span class='divider'>/</span></h4></li>
					<li class='active'><h4>".str_replace('\\','',$groupName)."</h4></li>
				</ul>
				</div>
				<div class='container well'>
				<h4>You aren't a member of the group ".str_replace('\\','',$groupName)."!  Ask the admin of your class to add you to the group, or create a new one!</h4>";	
		}
	}
?>