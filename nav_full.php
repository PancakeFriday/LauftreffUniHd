<div id="background">
	<div id="navWrapper">
			<div class="gr_bot visible-small" style="margin-left: -1.5em; margin-top: -1.5em"></div>
			<ul id="ulNav">
				<div style="float: left; height: 45pt; overflow: hidden;" id="navcut">
				<li class="navTitle pNav"><a href="<?=VIPagemap::$baseurl;?>" style="color: #fff;">Lauftreff Uni Heidelberg</a></li>

				<?php
					printNavigation(true, $nav);
					printNavigation(false, $nav);
				?>
				</div>
			</ul>
	</div>
</div>
<div id="content">
	<div class="gr_top"></div>
	<div id="content_wrap" class="container">