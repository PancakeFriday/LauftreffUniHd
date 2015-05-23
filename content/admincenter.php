<?php
	$nav_admin = Array( 'Home',
		'Edit content' => 'edit',
		'Add content' => 'add',
		'Media center' => 'media',
		'Add admin' => 'user',
		'Profile' => 'profile',
		'Logout' => 'logout'
		);
	$max_art_per_page = 4;

	$nav = Array( 'Infos', 'Aktuelles', 'Strecken', 'Links');

	$error = '';

	function getempty($var, $what)
	{
		if(empty($var))
			return $what;
	}

	function makelist($string)
	{
		return '<li>' . $string . '</li>';
	}

	// Someone submitted a form. What could it be?
	if(isset($_POST['editpost']))
	{ // Someone edited a post
		if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_GET['cat']) && !empty($_SESSION['editid']))
		{
			// All entries have been provided, let's edit the post!
			$t = $database->edit_content($_GET['cat'], $_GET['action'], $_POST['title'], $_POST['content']);

			$error = '<div class="success">Successfully edited the post</div>';
		}
		else
		{
			// Whoops something's been left empty...
			$list = '<ul class="errorlist">';
			$list .= makelist(getempty($_POST['title'], 'Title'));
			$list .= makelist(getempty($_POST['content'], 'Content'));
			$list .= makelist(getempty($_GET['cat'], 'Category'));
			$list .= makelist(getempty($_SESSION['editid'], 'Editid (How did you get there?)'));
			$list .= '</ul>';

			$error = '<div class="error">Some of the required fields have not been provided';
			$error .= $list . '</div>';
		}

		if(isset($_SESSION['editid']))
			unset($_SESSION['editid']);
	}

	if(isset($_POST['addpost']))
	{
		// Someone wants to add a post
		if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_GET['cat']) && !empty($_SESSION['user']))
		{
			$database->set_content($_GET['cat'], $_SESSION['user'], $_POST['title'], $_POST['content']);

			$error = '<div class="success">Successfully added the post</div>';
		}
		else
		{
			// Whoops something's been left empty...
			$list = '<ul class="errorlist">';
			$list .= makelist(getempty($_POST['title'], 'Title'));
			$list .= makelist(getempty($_POST['content'], 'Content'));
			$list .= makelist(getempty($_GET['cat'], 'Category'));
			$list .= makelist(getempty($_SESSION['user'], 'User (How did you get there?)'));
			$list .= '</ul>';

			$error = '<div class="error">Some of the required fields have not been provided';
			$error .= $list . '</div>';
		}
	}

	if(isset($_POST['adduser']))
	{
		// Someone wants to add a post
		if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_r']) && !empty($_POST['email']) && !empty($_SESSION['user']))
		{
			if($_POST['password'] == $_POST['password_r'])
			{
				if(strlen($_POST['password']) < 8)
				{
					$error = '<div class="error">Password has to be at least 8 Characters long</div>';
				}
				else
				{
					$database->add_admin( $_POST['username'], $_POST['email'], $_POST['password']);
					$error = '<div class="success">Successfully added the administrator</div>';
				}
			}
		}
		else
		{
			// Whoops something's been left empty...
			$list = '<ul class="errorlist">';
			$list .= makelist(getempty($_POST['username'], 'Username'));
			$list .= makelist(getempty($_POST['password'], 'Password'));
			$list .= makelist(getempty($_POST['password_r'], 'Repeat Password'));
			$list .= makelist(getempty($_POST['email'], 'Email'));
			$list .= makelist(getempty($_SESSION['user'], 'User (How did you get there?)'));
			$list .= '</ul>';

			$error = '<div class="error">Some of the required fields have not been provided';
			$error .= $list . '</div>';
		}
	}

	if(isset($_POST['profile']))
	{
		// Someone wants to edit their profile
		if($database->check_password($_SESSION['user'], $_POST['password_o']))
		{
			if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_SESSION['user']))
			{
				if(!empty($_POST['password']) && !empty($_POST['password_r']))
				{ // Also update password
					if($_POST['password'] == $_POST['password_r'])
					{
						if(strlen($_POST['password']) >= 8)
						{
							$result = $database->updateuser($_SESSION['user'], $_POST['username'], $_POST['email'], $_POST['password_o'], $_POST['password']);
							if($result == 1)
							{
								$_SESSION['user'] = $_POST['username'];
							}
						}
						else
							$error = '<div class="error">The passwords has to be at least 8 characters long</div>';
					}
					else
					{
						$error = '<div class="error">The passwords did not match</div>';
					}
				}
				else
				{ // Dont update password
					$result = $database->updateuser($_SESSION['user'], $_POST['username'], $_POST['email'], $_POST['password_o']);
					if($result == 1)
					{
						$_SESSION['user'] = $_POST['username'];
					}
				}
			}
			else
			{
				// Whoops something's been left empty...
				$list = '<ul class="errorlist">';
				$list .= makelist(getempty($_POST['username'], 'Username'));
				$list .= makelist(getempty($_POST['password'], 'Password'));
				$list .= makelist(getempty($_POST['password_r'], 'Repeat Password'));
				$list .= makelist(getempty($_POST['email'], 'Email'));
				$list .= makelist(getempty($_SESSION['user'], 'Session User (How did you get there?)'));
				$list .= '</ul>';

				$error = '<div class="error">Some of the required fields have not been provided';
				$error .= $list . '</div>';
			}
		}
		else
		{
			// Password doesnt match
			$error = '<div class="error">You either didn\'t provide your old password, or it is wrong.';
			$error .= '</div>';
		}
	}

	if(isset($_POST['media']))
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);

		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 2500000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES["file"]["error"] > 0) {
		    $error = "<div class='error'>Return Code: " . $_FILES["file"]["error"] . "</div>";
		  } else {
		    if (file_exists(VIPagemap::$basedir . "/media/" . $_FILES["file"]["name"])) {
		      $error = '<div class="error">' . $_FILES["file"]["name"] . " already exists. </div>";
		    } else {
		      move_uploaded_file($_FILES["file"]["tmp_name"],
		      VIPagemap::$basedir . "/media/" . $_FILES["file"]["name"]);
		      $error = "<div class='success'>Stored in: " . VIPagemap::$basedir . "/media/" . $_FILES["file"]["name"] . '</div>';
		    }
		  }
		} else {
		  echo "<div class='error'>Invalid file</div>";
		}
	}
?>

<div id="admin_nav">
<ul>
	<?php
		foreach($nav_admin as $n=>$v)
		{
			if($n == 'Home')
			{
				echo '<li><a href="' . VIPagemap::$baseurl . '">Home</a></li>';
			}
			else
			{
				$class = '';
				if(isset($_GET['nav']))
				{
					if($_GET['nav'] == strtolower($v))
					{
						$class = ' class="active"';
					}
				}
				else
				{
					if($v == 'edit')
					{
						$class = ' class="active"';
					}
				}
				echo '<li'. $class .'><a href="admin?nav='. $v  .'">' . $n . '</a></li>';
			}
		}
	?>
</ul>
</div>

<div id="content_creator">
	<?php

	echo $error;

	$page = 1;

	if(isset($_GET['page']))
	{
		$page = (int)($_GET['page']);
	}

	if(isset($_GET['nav']) && $_GET['nav'] === 'add')
	{ // Add posts
		if(isset($_GET['cat']))
		{ // Add an article
			$faddarticle = new VIForm('', 'POST');
			$faddarticle->add('input', 'hidden', 'addpost');
			$faddarticle->headl('3', 'Title');
			$faddarticle->add('input', 'text', 'title');
			$faddarticle->headl('3', 'Content');
			$faddarticle->add('textarea', '', 'content', '', '', Array('style="width: 788px; height: 355px; max-width: 788px; max-height: 355px;"'));

			$faddarticle->draw();
		}
		else
		{ // Select the category
			foreach($nav as $n)
			{
				if(strtolower($n) == 'admin')
					continue;

				$carray = $database->get_content( strtolower($n) );

				$carray_count = count($carray);

				if(strtolower($n) == 'infos' && $carray_count >= 1)
				{
					echo '<h1>' . $n . ' (' . $carray_count . ')</h1>';
					echo 'Notice: There can only be one post in infos!';
					continue;
				}

				echo '<h1><a href="admin?nav=add&cat=' . strtolower($n) . '">' . $n . '</a> (' . $carray_count . ')</h1>';
			}
		}
	}
	elseif(isset($_GET['nav']) && $_GET['nav'] === 'user')
	{ // Add user
		$fadduser = new VIForm('', 'POST');
		$fadduser->add('input', 'hidden', 'adduser');
		$fadduser->headl('3', 'Username');
		$fadduser->add('input', 'text', 'username');
		$fadduser->headl('3', 'Password');
		$fadduser->add('input', 'password', 'password');
		$fadduser->headl('3', 'Repeat password');
		$fadduser->add('input', 'password', 'password_r');
		$fadduser->headl('3', 'Email');
		$fadduser->add('input', 'text', 'email');

		$fadduser->draw();
	}
	elseif(isset($_GET['nav']) && $_GET['nav'] === 'profile')
	{ // Profile settings
		$user = $database->getuser($_SESSION['user']);

		$fprofile = new VIForm('', 'POST');
		$fprofile->add('input', 'hidden', 'profile');
		$fprofile->headl('6', 'Registration Date: ' . $user[2]);
		$fprofile->headl('3', 'Username');
		$fprofile->add('input', 'text', 'username', $user[0]);
		$fprofile->headl('3', 'Old password');
		$fprofile->add('input', 'password', 'password_o');
		$fprofile->headl('3', 'New password');
		$fprofile->add('input', 'password', 'password');
		$fprofile->headl('3', 'Repeat new password');
		$fprofile->add('input', 'password', 'password_r');
		$fprofile->headl('3', 'Email');
		$fprofile->add('input', 'text', 'email', $user[1]);

		$fprofile->draw();
	}
	elseif(isset($_GET['nav']) && $_GET['nav'] === 'media')
	{ // Media center
		$fupload = new VIForm('', 'POST', 'enctype="multipart/form-data"');
		$fupload->add('input', 'hidden', 'media');
		$fupload->headl('3', 'Upload Image');
		$fupload->add('input', 'file', 'file', '', '', '', Array(), false);
		$fupload->draw();

		echo '<br>';

		$dir = VIPagemap::$basedir.'/media/';
		$images = array_diff(scandir($dir), array('..', '.'));
		
		$rex = "/^.*\.(jpg|jpeg|png|gif)$/i";

		foreach($images as $i)
		{
			if(preg_match($rex, $i))
			{
				$dim = getimagesize('media/' . $i);
				echo '<div class="media_image">';
				echo '<div class="media_overlay">';
				echo '<p>Dimensions: ' . $dim[0] . 'x' . $dim[1] . '</p>';
				echo '<p>To insert this into your post, use:<br>&lt;img src="media/' . $i . '"&gt;';
				echo '</div>';
				echo '<a href="" class="amedia"><img src="media/'.$i.'" /></a>';
				echo '</div>';
			}
		}
	}
	else // $_GET['nav'] === 'edit'
	{ // Edit content
		if(isset($_GET['action']) && isset($_GET['cat']))
		{ // Edit an article
			// 0 id, 1 title, 2 content, 3 author, 4 date
			$id = $_GET['action'];
			$carray = $database->get_content( strtolower($_GET['cat']) );

			foreach($carray as $c)
			{
				if($c[0] != $id)
					continue;

				$fedit = new VIForm('', 'POST');
				$fedit->add('input', 'hidden', 'editpost');
				$fedit->headl('3', 'Title');
				$fedit->add('input', 'text', 'title', $c[1]);
				$fedit->headl('3', 'Content');
				$fedit->add('textarea', '', 'content', '', $c[2], Array('style="width: 788px; height: 355px; max-width: 788px; max-height: 355px;"'));

				$fedit->draw();

				$_SESSION['editid'] = $c[0];
			}

		}
		else
		{ // Select the article
			foreach($nav as $n)
			{
				$carray = $database->get_content( strtolower($n) );

				$carray_count = count($carray);

				if(strtolower($n) == 'admin')
					continue;

				echo '<h1><a href="admin?nav=edit&cat=' . strtolower($n) . '">' . $n . '</a> (' . $carray_count . ')</h1>';

				$style = '';

				if($carray_count <= 0)
					continue;

				if(isset($_GET['cat']) && $_GET['cat'] == strtolower($n))
					$style = 'style="display: block;"';

				if(strtolower($n) == 'infos')
				{
					echo '<div class="cat_hide" '. $style . '>';
					echo '<p style="font-weight: bold;">Notice, there can only be one post in Infos. If you want multiple infos, put them in one post!</p>';
					// Only take the last one...
					$count = $carray_count - 1;
					$id = $carray[$count][0];
					$title = $carray[$count][1];
					$content = $carray[$count][2];
					$author = $carray[$count][3];
					$date = $carray[$count][4];

						echo '<p class="author">By <strong>' . $author . '</strong> on ' . $date . '</p>'; // Author
						echo '<h4>' . $title . '</h4>'; // Title
						if(substr($content, 0, 150) == $content)
							$cont = $content;
						else
							$cont = substr($content, 0, 250) . '...';

						echo '<p>' . $cont . '</p>'; // Content 
						echo '<a href="admin?nav=edit&action=' . $id . '&cat='. strtolower($n) . '">Edit this post</a> | ';
						echo '<a href="admin?nav=del&action=' . $id . '&cat='. strtolower($n) . '">Delete this post</a><br><br>';

					echo '</div>';
					continue;
				}

				echo '<div class="cat_hide" '. $style . '>';
				$max_pages = ceil($carray_count / $max_art_per_page);

				echo '<ul class="pagination">';

				$get = 'admin?';
				$bget = false;
				if(isset($_GET['nav']))
				{
					$get .= 'nav=' . $_GET['nav'];
					$bget = true;
				}
				if(isset($_GET['action']))
				{
					$get .= '&action=' . $_GET['action'];
					$bget = true;
				}
				if(isset($_GET['cat']))
				{
					$get .= '&cat=' . $_GET['cat'];
					$bget = true;
				}
				if($bget)
					$get .= '&page=';
				else
					$get .= 'page=';

				if($page > 1)
				{	// Show previous page
					$prevpage = $page - 1;
					echo '<li><a href="' . $get . $prevpage . '">Previous Page</a></li>';
				}
				else
				{
					echo '<li class="disabled"><a href="#">Previous Page</a></li>';
				}
				for($i=1; $i<=$max_pages; $i++)
				{
					if($i == $page)
						echo '<li class="active"><a href="#">' . $i . '</a></li>';
					else
						echo '<li class="enabled"><a href="' . $get . $i . '">' . $i . '</a></li>';
				}
				if($page < $max_pages)
				{
					$nextpage = $page + 1;
					echo '<li><a href="' . $get . $nextpage . '">Next Page</a></li>';
				}
				else
				{
					echo '<li class="disabled"><a href="#">Next Page</a></li>';
				}

				echo '</ul>';

				foreach($carray as $key=>$c)
				{
					if($key+$max_art_per_page >= $page * $max_art_per_page && $key+$max_art_per_page < ($page + 1 )* $max_art_per_page)
					{
						echo '<p class="author">By <strong>' . $c[3] . '</strong> on ' . $c[4] . '</p>'; // Author
						echo '<h4>' . $c[1] . '</h4>'; // Title
						if(substr($c[2], 0, 150) == $c[2])
							$cont = $c[2];
						else
							$cont = substr($c[2], 0, 250) . '...';
						echo '<p>' . $cont . '</p>'; // Content 
						echo '<a href="admin?nav=edit&action=' . $c[0] . '&cat='. strtolower($n) . '">Edit this post</a><br><br>';
					}
				}

				echo '</div>';
			}
		}
	}
	?>
</div>
