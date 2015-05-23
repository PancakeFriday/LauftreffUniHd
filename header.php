<!DOCTYPE html>
<html lang="de">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"">

		<!-- Title -->
		<title>
			<?php echo VIPagemap::$main_title.' | '.$current_page->title; ?>
		</title>
	
		<!-- Favicon -->
		<!-- <link rel="icon" type="image/x-icon" href="/img/icon/favicon.ico">
		<link rel="apple-touch-icon" href="/img/icon/apple-touch-icon-precomposed.png"> -->
	
  		<!-- Stylesheets -->
  		<link rel="stylesheet" href="css/reset.css" type="text/css" />
  		<link rel="stylesheet" href="css/bootstrap.min.css">
  		<link rel="stylesheet" href="css/style.css" type="text/css" />
  		<?php
  		if(in_array('no_navigation', $current_page->options))
		{
			?> <link rel="stylesheet" href="css/login.css" type="text/css" /> <?php
		}
		?>
	    
	    <!-- jQuery -->
	    <script src="js/jquery.min.js"></script>
	    <script src="js/jquery.color-2.1.0.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/tinymce/tinymce.min.js"></script>

	    <!-- Javascript -->
	    <script src="js/main.js"></script>

	    <!-- Fonts -->
	    <link href='http://fonts.googleapis.com/css?family=Raleway:400,900' rel='stylesheet' type='text/css'>
	</head>

<body>