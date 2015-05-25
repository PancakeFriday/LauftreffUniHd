
<div id="login">
<h2 style="border-bottom: 1px solid #eee; margin: 0 0 10px 0;">Administration</h1>
<?php
if($database->getuser('*') == false)
{
?>

<div class="success">Looks like you are just setting up this website. Please provide an administrator by filling out the form.</div>
<form action="" method="POST">
	<h3>Username</h3>
	<input type="hidden" name="newadmin" />
	<input type="text" name="username" value="<?=getfull(@$_POST['username'], '') ?>" />
	<h3>Password</h3>
	<input type="password" name="password" value="<?=getfull(@$_POST['password'], '') ?>"/>
	<h3>Repeat password</h3>
	<input type="password" name="password_r" />
	<h3>Email</h3>
	<input type="text" name="email" value="<?=getfull(@$_POST['email'], '') ?>" />
	<input type="submit" name="submit" value="Register" />
</form>

<?php
}
else
{
?>
	<form action="" method="POST">
		<h3>Username</h3>
		<input type="hidden" name="login" />
		<input type="text" name="username" />
		<h3>Password</h3>
		<input type="password" name="password" />
		<br><br>
		<input type="submit" name="submit" value="Login" />
	</form>

<?php
}
?>
<?php echo '<br>' . VIAdminCenter::getError() ?>
</div>
