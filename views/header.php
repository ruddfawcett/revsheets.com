<?php
	require('./scripts/session.php');
?>
<!DOCTYPE HTML>
<html lang="en-US">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>Review Sheets | Collaborative Learning</title>
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meat name='og:image' content='./images/shorthand.png'>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <script src="//code.jquery.com/jquery.min.js"></script>
      <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet" />
      <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
      <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
      <?php
      	$getTheme = $db->prepare('SELECT * FROM users WHERE username=:username AND userID=:userID');
      	$getTheme->execute(array(':username'=> $_SESSION['username'], ':userID'=> $_SESSION['userID']));
      	$getTheme = $getTheme->fetchAll(PDO::FETCH_ASSOC);
      	$siteTheme = $getTheme[0] ['siteTheme'];
      	switch($siteTheme) {
      		case "Amelia":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/amelia/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Cerulean":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/cerulean/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Cosmo":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/cosmo/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Cyborg":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/cyborg/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Journal":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/journal/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Readable":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/readable/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Simplex":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/simplex/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Slate":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/slate/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Spacelab":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/spacelab/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Spruce":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/spruce/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "Superhero":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/superhero/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		case "United":
      			 echo "<link href='//netdna.bootstrapcdn.com/bootswatch/2.3.1/united/bootstrap.min.css' rel='stylesheet'>";
      		break;
      		default:
      		break;
      	}
      ?><link type="text/css" rel="stylesheet" href="./styles/main.css" />
      <script src="./bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
      <link rel="stylesheet" href="./bootstrap-fileupload/bootstrap-fileupload.min.css">
      <script src="./scripts/js/jquery.textCounter-min.js" type="text/javascript"></script>
      <script src="./scripts/js/counterPrefs.js" type="text/javascript"></script>
      <script src="./scripts/js/submission.js" type="text/javascript"></script>
      <script src="./scripts/js/removeWhitespace.js" type="text/javascript"></script>
	  <!--[if IE 7]>
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome-ie7.css" rel="stylesheet">
	<![endif]-->
	<script type="text/javascript">

	var _tsq = _tsq || [];
	_tsq.push(["setAccountName", "ruddfawcett"]);
	_tsq.push(["fireHit", "javascript_tracker", ["site-wide"]]);

	(function() {
		function z(){
			var s = document.createElement("script");
			s.type = "text/javascript";
			s.async = "async";
			s.src = window.location.protocol + "//cdn.tapstream.com/static/js/tapstream.js";
			var x = document.getElementsByTagName("script")[0];
			x.parentNode.insertBefore(s, x);
		}
		if (window.attachEvent)
			window.attachEvent("onload", z);
		else
			window.addEventListener("load", z, false);
	})();

	</script>
   </head>
   <body>
		  <div id="login" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModalLabel">Log In</h3>
			 </div>
			 <div id="return" class="return"></div>
			 <div class="modal-body">
				<form action="" id="loginForm" method="post" onsubmit="loginForm();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputUsername">Username</label>
					  <div class="controls">
						 <input type="text" name="username" id="inputUsername" placeholder="johndoe" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputPassword">Password</label>
					  <div class="controls">
						 <input type="password" name="password" id="inputPassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
						 <input type="hidden" value="login" name='type'>
					  </div>
				   </div>
			 </div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return&quot;).html(&quot;&quot;);">Close</a>
			 <input type="submit" class="btn btn-success" value="Login" />
			 </form>
			 <!-- <a class='pull-left btn btn-primary'><i class="icon-facebook-sign"></i> Login with Facebook</a> -->
			 </div>
		  </div>
		  <div id="signup" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return2&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModal2Label">Signup</h3>
			 </div>
			 <div id="return2" class="return"></div>
			 <div class="modal-body">
				<form action="" id="signupForm" method="post" onsubmit="signupForm();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputFirst">First Name</label>
					  <div class="controls">
						 <input type="text" name="firstname" id="inputFirst" placeholder="John" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputLast">Last Name</label>
					  <div class="controls">
						 <input type="text" name="lastname" id="inputLast" placeholder="Doe" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputEmail">Email</label>
					  <div class="controls">
						 <input type="text" name="email" id="inputEmail" placeholder="johndoe@gmail.com" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputUsernameForSignup">Username</label>
					  <div class="controls">
						 <input type="text" name="username" id="inputUsernameForSignup" placeholder="johndoe" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputPassword">Password</label>
					  <div class="controls">
						 <input type="password" name="password" id="inputPassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputPassword2">Verify Password</label>
					  <div class="controls">
						 <input type="password" name="password2" id="inputPassword2" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
						 <input type="hidden" name="type" value="signup" />
					  </div>
				   </div>
			 </div>
<!-- 
				<div style="height: 1px; background-color: #eee; text-align: center; width: 90%; margin-left: auto; margin-right: auto;">
				  <span style="background-color: white; position: relative; top: -0.6em;">&nbsp;&nbsp;&nbsp;or&nbsp;&nbsp;&nbsp;</span>
				</div>
			 	<h3 style='font-weight: normal; text-align: center;'><a class='btn btn-primary'><i class="icon-facebook-sign"></i> Login with Facebook</a></h3>
 -->
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return2&quot;).html(&quot;&quot;);">Cancel</a>
			 <input type="submit" class="btn btn-success" value="Signup!" />
			 </form>
			<!--  <a class='pull-left btn btn-primary'><i class="icon-facebook-sign"></i> Register with Facebook</a> -->
			 </div>
		  </div>
			<script type='text/javascript'>
				$(function() {
					 $('#siteTheme').val("<?php echo $siteTheme; ?>");
				});
			</script>
		  <div id="account" class="modal hide fade in" aria-hidden="true">
			 <div class="modal-header">
				<a class="close" data-dismiss="modal" onclick="$(&quot;#return9&quot;).html(&quot;&quot;);">&times;</a>
				<h3 id="myModal2Label">My Account</h3>
			 </div>
			 <div id="return9" class="return"></div>
			 <div class="modal-body">
				<form action="" id="updateAccountForm" method="post" onsubmit="updateAccount();return false;" class="form-horizontal">
				   <div class="control-group">
					  <label class="control-label" for="inputFirst">First Name</label>
					  <div class="controls">
						 <input type="text" name="firstname2" id="inputFirst" placeholder="John" value="<?php $name = explode(" ", $_SESSION['name']); echo $name[0]; ?>"/>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputLast">Last Name</label>
					  <div class="controls">
						 <input type="text" name="lastname2" id="inputLast" placeholder="Doe" value="<?php $name = explode(" ", $_SESSION['name']); echo $name[1]; ?>"/>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label" for="inputEmail">Email</label>
					  <div class="controls">
						 <input type="text" name="email2" id="inputEmail" placeholder="johndoe@gmail.com" value="<?php echo $_SESSION['email']; ?>"/>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Username</label>
					  <div class="controls">
						 <span class="uneditable-input"/><?php echo $_SESSION['username']; ?></span>
						 <input type="hidden" name="type" value="updateAccount" />
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Site Theme</label>
					  <div class="controls">
						<select name='siteTheme' id='siteTheme'>	
							<option value='Original'>Original</option>	
							<option value='Amelia'>Amelia</option>
							<option value='Cerulean'>Cerulean</option>						
							<option value='Cosmo'>Cosmo</option>						
							<option value='Cyborg'>Cyborg</option>						
							<option value='Journal'>Journal</option>						
							<option value='Readable'>Readable</option>
							<option value='Simplex'>Simplex</option>
							<option value='Slate'>Slate</option>
							<option value='Spacelab'>Spacelab</option>
							<option value='Spruce'>Spruce</option>			
							<!-- <option value='Superhero'>Superhero</option> -->				
							<option value='United'>United</option>
						</select>
					  </div>
				   </div></div>
			 <div class="modal-footer">
			 <a class="btn" data-dismiss="modal" aria-hidden="true" onclick="$(&quot;#return9&quot;).html(&quot;&quot;);">Cancel</a>
			 <input type="submit" class="btn btn-success" value="Save Changes" />
			 </div>
			 </form>
		  </div>