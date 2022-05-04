<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta name="viewport" content="width = 1050, user-scalable = no" />
<script type="text/javascript" src="{{ asset("js/jquery-3.6.0.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("js/turn/extras/modernizr.2.5.3.min.js")}}"></script>
<style>
    .turn-navigation{
        position: absolute;
        top: 0;
        transform: translate(-50%, -50%);
        height: 100%;
        width: 20px;
        background-color: red;
    }
    .turn-navigation-prev{
        left:0;
    }
    .turn-navigation-next{
        right:0;
    }
</style>
</head>
<body>

<div class="flipbook-viewport">
	<div class="container">
		<div class="flipbook">
            @foreach ($collection as $item)
                <div style="background-image:url({{ $item->getFirstMedia('laravel_block2_pdf')->getUrl() }} )"></div>    
            @endforeach
		</div>
        {{-- <div class="turn-navigation turn-navigation-prev" id="prevBtn">Prev</div>
        <div class="turn-navigation turn-navigation-next" id="nextBtn">Next</div> --}}
	</div>
</div>


<script type="text/javascript">

function loadApp() {

	// Create the flipbook

	$('.flipbook').turn({
			// Width

			width:922,
			
			// Height

			height:600,

			// Elevation

			elevation: 50,
			
			// Enable gradients

			gradients: true,
			
			// Auto center this flipbook

			autoCenter: true,
			zoom: true,

	});
}

$("#prevBtn").click(function() {
		$(".flipbook").turn("previous");
});

$("#nextBtn").click(function() {
		$(".flipbook").turn("next");
});

// Load the HTML4 version if there's not CSS transform

yepnope({
	test : Modernizr.csstransforms,
	yep: ['{{ asset("js/turn/lib/turn.js") }}'],
	nope: ['{{ asset("js/turn/lib/turn.html4.min.js") }}'],
	both: ['{{ asset("css/turn/basic.css") }}'],
	complete: loadApp
});

</script>

</body>
</html>