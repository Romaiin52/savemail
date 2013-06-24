$(document).ready(function() {
	$('.colorpicker').colorpicker().on('changeColor', function(ev){
		//this.backgroundColor = ev.color.toHex();
		//alert(ev.color.toHex())
		$(this).css({'backgroundColor':ev.color.toHex(),'color':ev.color.toHex()});
	});
	$('.colorpicker').css('backgroundColor',function(){
		return $(this).val();
	}).css('color',function(){
		return $(this).val();
	});;

	var clip = new ZeroClipboard( $(".copy-button"), {
	  moviePath: "http://localhost/savemail/web/js/ZeroClipboard.swf"
	});

	clip.on( 'complete', function(client, args) {
	  //this.style.display = 'none'; // "this" is the element that was clicked
	  //alert("Copied text to clipboard: " + $('#collapse1 pre').text() );
	} );
});