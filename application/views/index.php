<!-- <div class="col-12 mb-2" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-bullhorn"> </i> หน้าแรก</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">หน้าแรก</li>
		</ol>
	</div>

	<div class="col-12 pr-0 pl-0">
		<div class="card mb-0">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h5 class="panel-title">หน้าหลัก</h5>
			</div>
			<hr/>
			<span class="text-right px-5">
			   </span>
			<div class="card-body pr-0 pl-0">
				<div id='map' style='width: 100%; max-height: 800px;'></div>
			</div>
		</div>
	</div>
</div> -->


	
<div class="full-height" style="z-index: 1; position:fixed"></div>
<!-- <div class="full-height position-fixed z-index-1" id="map"></div> -->
<div class="col-12 z-index-1 p-0 d-flex justify-content-around">
	<button class="btn btn-dark position-relative z-index-1">BUTTON</button>
	<button class="btn btn-dark position-relative z-index-1">BUTTON</button>
	<button class="btn btn-dark position-relative z-index-1">BUTTON</button>
</div>
<p class="m-2 bg-warning" id="demo" style="z-index: 1; position:fixed; bottom: 0;"></p>
<script>

	var x = document.getElementById("demo");
	var lat = 6.943188;
	var long = 100.800371;

	mapboxgl.accessToken = 'pk.eyJ1Ijoiem9ycmVlbmF0IiwiYSI6ImNrOW84Y2FteTA5b3MzbXA3cWN0eHVoemcifQ.yIvdBJcVxhwb3Yn3h5vYJQ';
	var map = new mapboxgl.Map({
		container: 'map', // container ID
		style: 'mapbox://styles/mapbox/streets-v11', // style URL
		center: [100.800371,6.943188], // starting position [lng, lat]
		zoom: 16 // starting zoom
	});
	

	if (navigator.geolocation) {
		myVar = setInterval(locate, 2000);
		
	} else { 
		x.innerHTML = "Geolocation is not supported by this browser.";
		console.log("Latitude: ");
	}

	function locate() {
		navigator.geolocation.getCurrentPosition(showPosition)
	}
	
	function showPosition(position) {
		
		// long == null ? long = 1 : long = long;
		// lat == null ? lat = 1 : lat = lat;
		// long = long
		// lat = lat
		console.log("Long = " + long + " Lat = " + lat)
		// long += 0.001
		maker(long, lat)
		lat = lat - 0.00001
		map.flyTo({
			center: [long, lat],
			bearing: 0,
			curve:0,
			essential:  false// this animation is considered essential with respect to prefers-reduced-motion
		});
		
		// var lat = parseFloat(position.coords.latitude).toFixed(6);
		// var long = parseFloat(position.coords.longitude).toFixed(6);
		// x.innerHTML = "Latitude: " + lat + "<br>Longitude: " + long;
		// console.log("Latitude: " + lat + " Longitude: " + long);
		// marker.remove();
		// removePosition(long,lat);
	}

	function maker(long, lat) {
		var marker = new mapboxgl.Marker({
			draggable: true
		}).setLngLat([long, lat]).addTo(map);
	}

	// var marker = new mapboxgl.Marker({
	// 		draggable: true
	// 	}).setLngLat([long, lat-0.00003]).addTo(map);
	
</script>