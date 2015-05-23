<?php
	$max_posts = 5;

	$infos = $database->get_content( 'infos' );
	$aktuelles = $database->get_content( 'aktuelles' );
	$strecken = $database->get_content( 'strecken' );
	$links = $database->get_content( 'links' );

	function link_image($string)
	{
		$pos_start = strpos($string, '<img');
		if($pos_start !== FALSE)
		{
			$urlpos1 = strpos($string, '"', $pos_start);
			$urlpos2 = strpos($string, '"', $urlpos1+1);
			$url = substr($string, $urlpos1 + 1, $urlpos2 - $urlpos1 - 1);

			$add_string = '<a href="' . $url . '" class="image" target="_blank">';
			$string = substr_replace($string, $add_string, $pos_start, 0);
			$pos_end = strpos($string, '>', $pos_start + strlen($add_string)) + 1;
			$string = substr_replace($string, '</a>', $pos_end, 0);
		}

		return $string;
	}

	function print_content( $carray, $author, $min = 0, $max = 10000 )
	{
		foreach ($carray as $key=>$c)
		{
			if($key >= $min && $key < $max)
			{
				if($author === true)
				{
					echo '<p class="author">By <strong>' . $c[3] . '</strong> on ' . $c[4] . '</p>';
				}
				echo '<h4>' . $c[1] . '</h4>';
				echo '<p>' . link_image($c[2]) . '</p><br>';
			}
		}
	}
?>

<div class="row">
	<div class="col-sm-8">
		<div id="caktuelles">
		<h2> Aktuelles </h2>
			<?php
				$num = 0;
				if(isset($_GET['page']))
					$num = $_GET['page'];
				print_content($aktuelles, true, $num*$max_posts, $num*$max_posts + $max_posts);
			?>
		</div>
		<ul class="pagination">
		  <li><a href="home?page=0">&laquo;</a></li>
		  <?php for($i=0; $i<=count($aktuelles) / $max_posts; $i++)
		  	{
		  		$ti = $i + 1;
		  		if(isset($_GET['page']) && $_GET['page'] == $i)
		  		{
		  			echo '<li class="active"><a href="#"> ' . $ti . '</a></li>';
		  			continue;
		  		}
				echo '<li><a href="home?page=' . $i . '">' . $ti . '</a></li>';
		  	}
		  ?>
		  <li><a href="home?page=<?=floor(count($aktuelles)/$max_posts);?>">&raquo;</a></li>
		</ul>
	</div>
	
	<div class="col-sm-4 hidden-xs">
		<h2><?php
			if(isset($links[0]))
				echo $links[0][2];
		?></h2>
		<div id="cinfos">
		<h2> Infos </h2>
			<?php
				$count = count($infos)-1;
				echo '<h4>' . $infos[$count][1] . '</h4>';
				echo '<p>' . link_image($infos[$count][2]) . '</p><br>';
			?>
		</div>
		<h2> Strecken </h2>
			<?php
				print_content($strecken, false);
			?>
		</div>
</div>
