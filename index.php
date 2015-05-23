<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require_once(__DIR__.'/VIWebFramework/VILogger.php');
	VILogger::get('default')->configureErrorReporting(VI_LOG_LEVEL_DEBUG);

	require_once(__DIR__.'/VIWebFramework/VIForm.php');

	require_once(__DIR__.'/VIWebFramework/VIAdminCenter.php');

	require_once(__DIR__.'/secret.php');

	require_once(__DIR__.'/functions.php');

    require_once(__DIR__.'/pagemap_setup.php');

    $current_page = VIPagemap::getCurrentPage();

    // VIPagemap::checkURL();

    if(isset($_POST['login']))
	{
		if($database->check_password($_POST['username'], $_POST['password']))
		{
			$_SESSION['user'] = $_POST['username'];
			header('Location: ' . VIPagemap::$baseurl . '/admin');
		}
		else
		{
			$error = '<div class="error">Username and password do not match</div>';
		}
	}

	if(isset($_GET['nav']) && $_GET['nav'] == 'logout')
	{
		session_unset();
		header('Location: ' . VIPagemap::$baseurl);
	}

	// Delete a post
	if(isset($_GET['nav'], $_GET['action'], $_GET['cat']) && $_GET['nav'] == 'del')
	{
		$database->delete_content( $_GET['cat'], $_GET['action']);
		header('Location: ' . VIPagemap::$baseurl . '/admin?nav=edit&cat=' . $_GET['cat']);
	}

	require(__DIR__.'/header.php');

	if(valid_token())
	{
		if($current_page->getID() == 'admin')
		{
			if(isset($_SESSION['user']))
				$current_page->filename = 'admincenter.php';
		}

		if(isset($_SESSION['user']))
			array_push($nav, 'Admin');
	}


	if(!in_array('no_navigation', $current_page->options))
	{
		require(__DIR__.'/nav_full.php');
	}

	$database->create_content_table();
	$database->create_admin_table();

	include(__DIR__.'/content/'.$current_page->getFile());

	require(__DIR__.'/footer.php');

	// for($i=0; $i<=20; $i++)
	// 	$database->set_content( 'aktuelles', 'Robin', 'Test Post ' . $i, lorem_ipsum( Array( rand(1,3), 'plaintext' ), false) );
?>
