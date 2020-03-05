window.addEventListener('load', function initialise () {
// Function to resize text size
document.getElementById('increase').onclick = increaseSize;
document.getElementById('decrease').onclick = decreaseSize;

function increaseSize(){
	resizeText(1);
}
function decreaseSize(){
	resizeText(-1);
}
	function resizeText(multiplier) {
		if (document.body.style.fontSize == "") {
			document.body.style.fontSize = "1.0em";
		}
		document.body.style.fontSize = parseFloat(document.body.style.fontSize) + (multiplier * 0.2) + "em";
	}
});
$(document).ready(function () {
$( '#increase, #decrease, small' ).hide();
	$( '#increase, #decrease' ).unbind('click');
	$('#close-div').click(function(e) {
	
	$( '#resize-button' ).toggleClass('resize-buttonopen');
	$( '#increase, #decrease, small' ).toggle();
	
  });
});
	
	