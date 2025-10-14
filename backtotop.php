<div  class="back-to-top">&nbsp;</div>
<style>
.back-to-top{
	position:fixed;
	bottom:20px;
	right:20px;
	background:#43c7ce;
	color:#fff;
	width:40px;
	height:40px;
	line-height:40px;
	text-align:center;
	border-radius:5px;
	visibility:hidden; cursor:pointer;
	transition:all .3s;
}
.back-to-top:after {
    position: absolute;
    content: '';
    width: 15px;
    height: 15px;
    border-top: solid 3px #fff;
    border-left: solid 3px #fff;
    top: 60%;
    transform: translateX(-50%) translateY(-50%) rotate(45deg);
    left: 50%;
    border-radius: 1px;
}
.back-to-top.show-back-to-top{ visibility:visible;}
</style>


<script>
// Check distance to top and display back-to-top.
$( window ).scroll( function() {
	if ( $( this ).scrollTop() > 800 ) {
		$( '.back-to-top' ).addClass( 'show-back-to-top' );
	} else {
		$( '.back-to-top' ).removeClass( 'show-back-to-top' );
	}
});

// Click event to scroll to top.
$( '.back-to-top' ).click( function() {
	$( 'html, body' ).animate( { scrollTop : 0 }, 800 );
	return false;
});
</script>