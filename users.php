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
							<li><a href='/'>Sheets</a></li>
							<li><a href='upload.php'>Upload</a></li>
						 	<li><a href='search.php'>Search</a></li>
						<?php else: ?>
						<?php endif ?>
					  </ul>
					  <ul class="nav pull-right">
						 <?php
							if(array_key_exists('username', $_SESSION)) {
								echo "<li class='active'><a href='#'>My Account</a></li>
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
		  <div class="container well">
				<?php if(array_key_exists('username', $_SESSION)): ?>
					<?php require('views/account.php'); ?>
				<?php else: ?>
						  <div class='center'>
						  <img src='images/logo.png' class='hidden-phone'>
						  <h1><small>Share review sheets with your classes, with a system based much like <a href='http://quizlet.com'>Quizlet</a>.   Having trouble in history, but you're a Latin ace?  No problem!  Upload sheets to some groups, download sheets from others!</small></h1>
						  </div>
				<?php endif ?>
		  </div>
		  <div id="footer" class='hidden'>
			 <div class="container">
				<p class="muted credit">Copyright &copy; 2013 <a href='//ruddfawcett.com'>Rudd Fawcett</a>. A <a href='#'>Four Leaf LLC</a> project. <span class='pull-right'><i class="icon-facebook icon-large"></i></span></p>
			 </div>
		  </div>
   </body>
</html>
