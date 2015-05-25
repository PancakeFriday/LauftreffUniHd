$(function(){
	var parallax = document.getElementById('background');
	var speed = 10;

	tinymce.init({
	    selector: "textarea",
	    plugins: [
        "autolink lists link charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code",
        "insertdatetime nonbreaking save table contextmenu directionality",
        "paste textcolor colorpicker textpattern"
    	],
    	toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
    	toolbar2: "print preview | forecolor backcolor",
	});

	window.onscroll = function() {
		var yOffset = window.pageYOffset
		$('#background').stop(true, true)
		$('#background').animate({ backgroundPositionY: (yOffset / speed) - 100}, 50, "linear")
	}

	window.onload = function() {
		$('#navWrapper').animate({"bottom": "30px"}, 300).animate({"bottom": "0px"}, 300);

		$('.amedia').click(function(event) {
			event.preventDefault();

			if($(this).parent().css("width") == '500px')
			{
				// Size down
				$(this).parent().animate({"height": "120px", "width": "120px"});
				$(this).parent().children('.media_overlay').fadeOut({ duration: 200, queue: false });
			}
			else
			{
				// Size up
				$('.media_image').animate({"height": "120px", "width": "120px"}, { duration: 200, queue: false });
				$('.media_overlay').fadeOut({ duration: 200, queue: false });
				$(this).parent().children('.media_overlay').fadeIn({ duration: 600, queue: false });
				$(this).parent().animate({"height": "500px", "width": "500px"}, { duration: 200, queue: false });
			}
		});
	}

	$('.image').click(function(e){
		// e.preventDefault();
		
	});
});

changeUrl = function(url) {
	// window.history.pushState(null, null, url);

	// console.log('#c' + url);

	// $('html, body').animate({scrollTop:$('#c' + url).offset().top}, 'slow', 'swing', function() {
	// 	$('#c' + url).css("background-color", "#efefef").animate({"background-color": "#fff"}, 700).clear('background-color');
	// });

	// $('#content_wrap').animate({opacity: 0}, "swing", function() {
	// 	var content = "";
	// 	$.get(url, function(data) {
	// 	  	var content = $('<div>' + data + '</div>');
	// 	  	$('#content_wrap').html(content.find('#content_wrap').html());
	// 		$('#content_wrap').animate({opacity: 1});
	// 	});
	// });



	return false;
}