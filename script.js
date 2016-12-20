/*
version 0.2
*/
$(document).ready(function(e) {
	var current = 0;
	var total_images = images.names.length;//should be same for times
	
	$('body').append('<span id="loading">loading&hellip;</span><img src="' + folder + images.names[0] + '?ts=' + images.times[0] + '" alt=""></div>');
	$('body').append('<nav><div id="gui"><button id="prev">&larr; Previous</button> <button id="next">Next &rarr;</button> <span>' + retitle(images.names[0]) + '</span></div></nav>');
	$('body').css('margin-bottom', $('nav').height() + 'px');//so the nav bar won't cover the image, doesnt account for border/margin
	
	//only show if we have more than 1 image
	if (total_images < 2){
		$('nav').hide(0);	
		$('body').css('margin-bottom', 0);
	}
	
	//PREVIOUS
	$('button#prev').click(function () {
		if ((current - 1) < 0) {
			current = total_images - 1;
		}
		else {
			current--;
		}
		
		change_image();
	});
	
	//NEXT
	$('button#next').click(function () {
		if ((current + 1) > total_images - 1) {
			current = 0;
		}
		else {
			current++;
		}
		
		change_image();
	});
	
	function change_image(){
		$('img').attr('src', folder + images.names[current] + '?ts=' + images.times[current]);
		$('nav span').text(retitle(images.names[current]));
	}
	
	function retitle(filename) {
		var name = filename.substr(0, filename.lastIndexOf('.'));//remove extension
		var regex = /^\d+_/;
		name = name.replace(regex, '');//remove leading numbers that are followed by a underscore: 001_
		regex = /(_|-)/g;
		return name.replace(regex, ' ');//return name with underscores and dashes replaced with spaces
	}
});
