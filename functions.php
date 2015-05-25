<?php
	$background = 1;

	function lorem_ipsum($options = Array(), $show_url = false)
	{
		/* --- OPTIONS ---
		(integer) - The number of paragraphs to generate.
		short, medium, long, verylong - The average length of a paragraph.
		decorate - Add bold, italic and marked text.
		link - Add links.
		ul - Add unordered lists.
		ol - Add numbered lists.
		dl - Add description lists.
		bq - Add blockquotes.
		code - Add code samples.
		headers - Add headers.
		allcaps - Use ALL CAPS.
		prude - Prude version.
		plaintext - Return plain text, no HTML.
		*/

		$str = '';

		foreach($options as $option) {
			$str .= '/' . $option;
		}

		if($show_url === true)
			echo 'http://loripsum.net/api' . $str;

		return file_get_contents('http://loripsum.net/api' . $str);
	}

	function printNavigation($mobile, $nav) {
		if($mobile)
			$class = "visible-small liNav-small";
		else
			$class = "hidden-small liNav-medium";

		foreach($nav as $n)
		{
			if($n != 'Admin')
			{
				$lown = strtolower($n);
				$class2 = "";
				if(VIPagemap::getCurrentPage()->getID() === $lown)
					$class2 = " currentPage";

				$changeUrl = "'lauftr/" . $lown . "\'";
				echo '<li class="' . $class . $class2 . '"><a href="/" onclick="changeUrl(\'' . $lown . '\');">' . $n . '</a></li>';
			}
			else
			{
				$class2 = ' admin';
				echo '<li class="' . $class . $class2 . '"><a href="admin">' . $n . '</a></li>';
			}
		}
	}

	function get_facebook() {
		$limit = 5;
		$group_id = '154401784623863';
		$fb_appId = '777058495646977';
		$fb_appSecret = '1324c2ec4294a2722423621a3fb8c1d4';
		// Needs to be changed once the group is public
		$access_token = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id=' . $fb_appId . '&client_secret=' . $fb_appSecret . '&grant_type=client_credentials');
		$access_token = "access_token=CAACEdEose0cBAPewupTr1EZAJmoDRE17r5oSCoiNZCG7wV6RbT5dbNNAceKa6eZBrgjfRapaZC7JOfsqb78Gw2GIOBqioeHiZA6uslv2ItVMztBXI9d7J6PTRZBb93I7k9ZAnGUEQ2jZAJGhu60U1qti0Skic4ZCRsxCmacZA8yujJV4xZBS3s6QXtYshCeTJ1Uf337nnoX8ScjSAZDZD";

		// $response = file_get_contents("https://graph.facebook.com/".$group_id."/feed?limit=". $limit ."&".$access_token);
		$response = file_get_contents("messages.json");

		$data = json_decode($response, true);

		foreach($data['data'] as $key=>$value)
		{
			echo '<div style="display: block; clear: both;"><img src="http://graph.facebook.com/' . $value['from']['id'] . '/picture" style="float:left; padding-right: 0.5em;"/>';
			echo '<p style="font-weight: bold;">' . $value['from']['name'] . '</p></div>';
			echo '<p>' . $value['message'] . '</p>';
		}
		// print_r($data['data']);
	}

	function valid_token() {
		// connect to database and check for token...
		return true;
	}

	function getempty($var, $what)
	{
		if(empty($var))
			return $what;
	}

	function getfull($var, $what)
	{
		if(isset($var) && empty($var))
			return $what;
		return $var;
	}

	function makelist($string)
	{
		return '<li>' . $string . '</li>';
	}
?>
