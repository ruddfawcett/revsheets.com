<?php require('views/header.php') ?>
		  <div class="navbar navbar-inverse navbar-fixed-top">
			 <div class="navbar-inner">
				<div class="container">
				   <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
				   </a>
				   <a class="brand righteous" href="http://revsheets.com/" style="color: #fff;">Review Sheets</a>
				   <div class="nav-collapse collapse">
					  <ul class="nav">
						 <?php if(array_key_exists('username', $_SESSION)): ?>
							<li><a href='/'><i class="icon-folder-open-alt"></i> Sheets</a></li>
							<li class='active'><a href='upload.php'><i class="icon-file-alt"></i> Upload</a></li>
						 	<li><a href='search.php'><i class="icon-search"></i> Search</a></li>
						<?php else: ?>
						<?php endif ?>
					  </ul>
					  <ul class="nav pull-right">
						 <?php
							if(array_key_exists('username', $_SESSION)) {
								echo "<li><a href='#account' role='button' class='link' data-toggle='modal'>My Account</a></li>
								<li><a href='scripts/logout.php'>Logout</a></li>";
							}
							else {
										echo "<li><a href='#login' data-toggle='modal'>Log In</a></li>
											  <li class='hidden-phone'><a href='#signup' data-toggle='modal'>Sign Up</a></li>";
									}
								?>
					  </ul>
				   </div>
				</div>
			 </div>
		  </div>

				<?php if(array_key_exists('username', $_SESSION)): ?>
					<?php require('views/upload.php'); ?>
				<?php else: ?>
<div class="container well">
						  <div class='center'>
						  <img src='images/logo.png' class='hidden-phone'>
						  <h3 class='lead'>A website similar to Quizlet, but with review sheet sharing instead of flashcards.<br /> ReviewSheets make it easy to collaborate and share while studying with your friends.</h3>
						  </div>
				<?php endif ?>
		  </div>
<?php require('views/footer.php'); ?>
