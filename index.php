<?php include 'theme/header.php'; ?>

	<div id="content" class="clearfix">
		<div class="content-row">
				<h2>Per accedere alla piattaforma di gestione del Bot devi fare il Login:</h2>
				   <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
					  <fieldset >
					  <legend>Login</legend>
					  <input type='hidden' name='submitted' id='submitted' value='1'/>
					  <label for='username' >UserName*:</label>
					  <input type='text' name='username' id='username'  maxlength="50" />
					  <label for='password' >Password*:</label>
					  <input type='password' name='password' id='password' maxlength="50" />
					  <input type='submit' name='Submit' value='Submit' />
					  </fieldset>
				</form>

		</div>
	</div>
<!-- Footer page -->
<?php include 'theme/footer.php'; ?>
