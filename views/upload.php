<script type='text/javascript'>
	$(function() {
 		 $("#inputTitle").focus();
 		 $('#month').val("<?php echo date('F'); ?>");
 		 $('#day').val("<?php echo date('j'); ?>");
	});
</script>
<?php if (array_key_exists('subject',$_GET)): ?>
	<script type='text/javascript'>
		$(document).ready(function(){
			$('#subject').val("<?php echo $_GET['subject']; ?>");
		});
	</script>
<?php endif ?>
<?php if (array_key_exists('groupID',$_GET)): ?>
<?php
	$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `groupID`=:groupID AND username=:username");
	$stmt->execute(array(':groupID' => $_GET['groupID'], ':username' => $_SESSION['username']));
	
	$row_count = $stmt->rowCount();
	$stmt = $db->prepare("SELECT * FROM groups WHERE `groupID`=:groupID");
	$stmt->execute(array(':groupID' => $_GET['groupID']));
	$groupName = $stmt->fetch(PDO::FETCH_ASSOC);
	$groupName = $groupName['name'];
	
	if ($row_count == 0):
?>
<h4>You aren't a member of this group, so you can't upload a sheet to it.</h4>
<script type='text/javascript'>setTimeout(function () {window.location.href = "upload.php";}, 2000);</script>
<?php else: ?>
    <div class='container well path'>
    <ul class='breadcrumb'>
    <li><a href='upload.php'><h4>Upload</a> <span class='divider'>/</span></h4></li>
    <li class='active'><h4><?php echo $groupName; ?></h4></li>
    </ul>
    </div>
    <div class='container well'>
    <div id='return6'>
    <?php
    	if($_SERVER['REQUEST_METHOD'] == "POST") {
			if (empty($_POST['title']) || empty($_POST['description']) || empty($_FILES['sheet']['name'])) {
				echo "<div class='alert alert-error'><strong>Error!</strong> Please enter values for all fields!</div>";
			}
			else {
				$noEXT = array("PHP","HTML","HTM","RB","JS","JAVA","SH","SQL","AAF","3GP","GIF","ASF","AVCHD","AVI","CAM","DAT","DSH","FLV","MPEG-1","MPEG-2","M1V","M2V","FLA","FLR","SOL","M4V","MKV","WRAP","MNG","MOV","MPEG","MPG","MPE","MP4","MXF","ROQ","NSV","OGG","RM","SVI","SMI","SWF","WMV","IMOVIEPROJ","PPJ","FCP","MSWMM","SUF","VEG","VEG-BAK","WLMP","AIFF","AU","BWF","CDDA","IFF-8SVX","IFF-16SV","RAW","WAV","FLAC","LA","PAC","M4A","APE","RKA","SHN","TTA","WV","WMA","BRSTM","AST","AMR","MP2","MP3","GSM","WMA","M4A","MP4","M4P","AAC","MPC","VQF","RA","RM","OTS","SWA","VOX","VOC","DWD","SMP","AUP","BAND","CUST","MID","MUS","SIB","SID","LY","GYM","VGM","PSF","NSF","MOD","PTB","S3M","XM","IT","MT2","MNG","MINIPSF","PSFLIB","2SF","DSF","GSF","PSF2","QSF","SSF","USF","RMJ","SPC","NIFF","TXM","YM","JAM","ASF","MP1","MSCZ","MSCZ","ASX","M3U","PLS","RAM","XPL","XSPF","ZPL","ALS","AUP","CEL","CPR","CWP","DRM","MMR","NPR","OMFI","SES","SFL","SNG","STF","SND","SYN");
				if (!in_array(strtoupper(pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION)),$noEXT)) {
					function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){$str = '';$count = strlen($charset);while ($length--) {$str .= $charset[mt_rand(0, $count-1)];}return $str;}
					$rand = randString(13);
					$stmt = $db->prepare("SELECT * FROM files WHERE fileID=:fileID");
					$stmt->execute(array(':fileID' => $rand));
					$row_count = $stmt->rowCount();		
					if ($row_count == 0) {
						$dump = $_POST['title']." ".$_POST['description']." ".$_POST['subject']." ".strtoupper(pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION));
						$stmt = $db->prepare("INSERT INTO files(fileID,title,description,subject,testDate,date,ext,groupID,userID,dump) VALUES(:fileID,:title,:description,:subject,:testDate,:date,:ext,:groupID,:userID,:dump)");
						$stmt->execute(array(':fileID' => $rand,':title' => $_POST['title'],':description' => $_POST['description'],':subject'=> $_POST['subject'],':testDate' => $_POST['month']." ".$_POST['day'].", ".$_POST['year'],':date' => date('F j, Y'),':ext' => strtoupper(pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION)),':groupID' => $_POST['groupID'],':userID' => $_SESSION['userID'], ':dump' => $dump));
			
						move_uploaded_file($_FILES['sheet']['tmp_name'], "./files/".$_GET['groupID']."/".$rand.".".pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION));
					
						echo "<script type='text/javascript'>
								$(document).ready(function(){
									$('#removeSuccess').empty();
								});
							  </script>";
						echo "<div class='alert alert-success' style='margin-bottom: 0;'><strong>Success!</strong> Sweet!  You've uploadeded a sheet!</div>";
						echo "<script type='text/javascript'>
								setTimeout(function () {
									window.location.href = '/?groupID=".$_GET['groupID']."&subject=".$_POST['subject']."'
								}, 3000);
							  </script>";
					}
					else {
						echo "<div class='alert alert-error'><strong>Whoops!</strong> Something happened at our end.  Can you resubmit the form please?</div>";
					}
				}
				else {
					echo "<div class='alert alert-error'><strong>Error!</strong> The file type \"".strtoupper(pathinfo($_FILES['sheet']['name'], PATHINFO_EXTENSION))."\" is not allowed!</div>";
				}
			}
		}
	?>
    </div>
    <div id='removeSuccess'>
<form enctype='multipart/form-data' action='upload.php?groupID=<?php echo $_GET['groupID']; ?>' method='POST' id='uploadForm'>
  <div class="control-group">
    <label class="control-label" for="inputTitle">Title, <span id="remainingCharacters2"></span> characters remaining.</label>
    <div class="controls">
      <input type="text" id="inputTitle" placeholder="Sheet title" class="input-xlarge" name='title' value="<?php if ($_POST['title']) echo $_POST['title']; ?>" >
    </div>
  </div>
  <div class="control-group">
    <p class="control-label">Test Date</p>
    <div class="controls">
	<select name='month' class="input-small" id='month'>			
		<option value='January'>January</option>
		<option value='February'>February</option>						
		<option value='March'>March</option>						
		<option value='April'>April</option>						
		<option value='May'>May</option>						
		<option value='June'>June</option>
		<option value='July'>July</option>
		<option value='August'>August</option>
		<option value='September'>September</option>
		<option value='October'>October</option>			
		<option value='November'>November</option>				
		<option value='December'>December</option>
	</select>					
	<select name='day' class="input-small" id='day'>
		<option value='1'>1</option>
		<option value='2'>2</option>					
		<option value='3'>3</option>					
		<option value='4'>4</option>				
		<option value='5'>5</option>					
		<option value='6'>6</option>
		<option value='7'>7</option>						
		<option value='8'>8</option>						
		<option value='9'>9</option>						
		<option value='10'>10</option>						
		<option value='11'>11</option>
		<option value='12'>12</option>					
		<option value='13'>13</option>					
		<option value='14'>14</option>				
		<option value='15'>15</option>					
		<option value='16'>16</option>
		<option value='17'>17</option>						
		<option value='18'>8</option>						
		<option value='19'>19</option>						
		<option value='20'>20</option>						
		<option value='21'>21</option>
		<option value='22'>22</option>					
		<option value='23'>23</option>					
		<option value='24'>24</option>				
		<option value='25'>25</option>					
		<option value='26'>26</option>
		<option value='27'>27</option>						
		<option value='28'>28</option>						
		<option value='29'>29</option>						
		<option value='30'>30</option>
		<option value='31'>31</option>
	</select>	
	<select name='year' class="input-small">
		<?php
			$lastyear = date('Y')-1;
			$thisyear = date('Y');
			$nextyear = date('Y')+1;
			echo "<option value='".$lastyear."'>".$lastyear."</option>
				  <option value='".$thisyear."' selected>".$thisyear."</option>
				  <option value='".$nextyear."'>".$nextyear."</option>";
		?>
	</select>
  </div>
  <div class="control-group">
    <label class="control-label" for="sheetDescription">Sheet Description, <span id="remainingCharacters"></span> characters remaining.</label>
    <div class="controls">
      <textarea rows='5' id="sheetDescription" class="input-xlarge" name='description'><?php if ($_POST['description']) echo $_POST['description']; ?></textarea>
    </div>
  </div>
  <div class="control-group">
    <p class="control-label">Sheet Subject</p>
    <div class="controls">
	<?php
		$stmt = $db->prepare("SELECT * FROM subjects WHERE `groupID`=:groupID ORDER BY name");
		$stmt->execute(array(':groupID' => $_GET['groupID']));
		$row_count = $stmt->rowCount();		
		if ($row_count > 0) {
			echo "<select name='subject' class='input-xlarge' id='subject'>";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='".$row['name']."'>".$row['name']."</option>";
			}
			echo "</select>";
		}
		else {
			echo "<strong>No Subjects!</strong> Have your grade admin add your grade's subjects.<br /><br />";	
		}
	?>
    </div>
  <div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
    <div class="uneditable-input"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">File</span><span class="fileupload-exists">Change</span><input type="file" name='sheet'/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>
  
  <div class="control-group">
    <div class="controls">
      <input type='hidden' name='groupID' value="<?php echo $_GET['groupID']; ?>">
      <input type="submit" class="btn" value='Upload Sheet'><a href='/' class='btn margin-left'>Cancel</a>
    </div>
  </div>
</form>
</div>
</div>
</div>
<?php endif ?>
<?php else: ?>
<div class='container well path'>
    <ul class='breadcrumb'>
    <li class='active'><h4>Select a group in which to upload a sheet:</h4></li>
    </ul>
    </div>
    <div class='container well'>
<?php
	$stmt = $db->prepare("SELECT * FROM groupMembers WHERE `username`=:username ORDER BY groupName");
	$stmt->execute(array(':username' => $_SESSION['username']));
	$row_count = $stmt->rowCount();		
	if ($row_count > 0) {
		echo "<div class='row'>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<a href='?groupID=".$row['groupID']."'><div class='span3 icon'><img src='images/folder.png'><span class='caption'>". $row['groupName'] . "</span></div></a>";
		}
		echo "</div></div></div>";
	}
	else {
		echo "<h4>You haven't joined any groups!  Either create a group, or join one!</h4>";
	}
?>
<?php endif ?>