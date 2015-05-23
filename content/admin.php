<div id="login">
<h2 style="border-bottom: 1px solid #eee; margin: 0 0 10px 0;">Administration</h1>
	<form action="" method="POST">
		<h3>Username</h3>
		<input type="hidden" name="login" />
		<input type="text" name="username" />
		<h3>Password</h3>
		<input type="password" name="password" />
		<br><br>
		<input type="submit" name="submit" value="Login" />
	</form>

	<?php if(isset($error)) echo '<br>' . $error; ?>
</div>