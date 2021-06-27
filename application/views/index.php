<style>
	.overlay {
		position: relative;
		z-index: 1;
	}

	.instructions {
		z-index: 3; 
		width: 30%; 
		height: 50%;
		position: relative;
		margin: 3%;
	}

	.right {
		right: 0;
	}

	.top {
		top: 10%
	}

	.bg-faded {
		background-color:rgba(255, 255, 255, 0.7);
	}

	.outputroute {
		z-index: 2;
		position: fixed;
		width: 100%;
		bottom: 0
	}

	.head {
        width: 100%;
        height: 100px;
    }

	@media screen and (max-width: 480px) {
		.instructions {
			z-index: 3; 
			width: 100%; 
			height: 30%;
			position: fixed;
			bottom: 0;
			margin: 0%;
		}

		/* .outputroute {
			z-index: 2;
			position: fixed;
			width: 100%;
			bottom: 0
		} */
	}

	/* @media screen and (min-width: 480px) {
		.outputroute {
			z-index: 2;
			position: relative;
			top: 15%
		}
	} */
</style>

<!-- Turf JS -->
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

<!-- Mapbox GL Directions -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css"/>

<!-- <div class="full-height bg-warning" style="z-index: 1; position:fixed"></div> -->
<div class="full-height position-fixed z-index-1" id="map"></div>
<!-- <p class="m-2 bg-warning" id="demo" style="z-index: 3; position:fixed; bottom: 0;"></p> -->
<!-- <div class="overlay position-absolute right">
	<button class="overlay btn btn-primary" id="search">ค้นหา</button>
</div> -->
<div class="d-flex justify-content-center">
	<div class="dropdown mr-2" id="dropdownchoose">
		<button class="overlay btn btn-warning dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			เลือกร้านค้า
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu">
			<button class="dropdown-item" type="button" data-toggle="modal" data-target="#searchMarketModal">
				<div class="row">
					<div class="col">ค้นหา <i class="fas fa-search"></i></div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces(1)">
				<div class="row">
					<div class="col">แสดงเฉพาะเสื้อผ้า</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces(2)">
				<div class="row">
					<div class="col">แสดงเฉพาะอาหาร</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces(3)">
				<div class="row">
					<div class="col">แสดงเฉพาะของฝาก</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces(4)">
				<div class="row">
					<div class="col">แสดงเฉพาะเครื่องใช้ไฟฟ้า</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces(5)">
				<div class="row">
					<div class="col">แสดงเฉพาะผลไม้</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" onclick="addplaces()">
				<div class="row">
					<div class="col">เลือกทั้งหมด</div>
				</div>
			</button>
		</div>
	</div>
	<!-- <button class="overlay btn btn-primary mr-2" id="search">ค้นหา</button> -->
	<button class="d-none" id="start">เริ่ม</button>
	<button class="d-none" id="replay">เล่นใหม่อีกครั้ง</button>
	<div class="dropdown">
		<button class="overlay btn btn-primary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			จุดเริ่มต้น
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenu">
			<button class="dropdown-item" type="button" id="startCurentLocationPoint">
				<div class="row">
					<div class="col-2 text-center"><i class="fas fa-crosshairs"></i></div>
					<div class="col">ตำแหน่งของคุณ</div>
				</div>
			</button>
			<button class="dropdown-item" type="button" id="startPoint">
				<div class="row">
					<div class="col-2 text-center"><i class="fas fa-map-marker"></i></div>
					<div class="col">เลือกตำแหน่ง</div>
				</div>
			</button>
		</div>
	</div>
	<button class="d-none" id="usePoint">ใช้จุดนี้</button>
	<button class="d-none" id="replay">เล่นใหม่อีกครั้ง</button>
	<button class="overlay btn btn-danger ml-2" id="stopPoint">จุดปลายทาง</button>
	<button class="d-none" id="driving"><i class="fas fa-car"></i></button>
	<button class="d-none" id="walking"><i class="fas fa-walking" ></i></button>
	<button class="d-none" id="cycling"><i class="fas fa-motorcycle"></i></button>
	<button class="d-none" id="getRoute">เส้นทาง</button>
</div>

<div class="d-none" id="bginstructions">
	<button class="btn btn-sm btn-danger position-absolute right m-1" id="closeinstructions" style="z-index: 3">x</button>
	<div class="p-2" id="instructions">
</div>
</div>
<div class="d-none" id="routeDisplay">
	<div class="p-2">
		<span class="" id="valueinstruction"></span><button class="ml-1 btn btn-sm btn-primary" id="showinstructions">ดูเส้นทาง</button>
	</div>
</div>

<div class="modal fade" id="searchMarketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog top" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addgoodsLabel"><i class="fas fa-search"></i> ค้นหาร้านค้า</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-body">
					<div class="input-group">
						<input type="text" class="form-control bg-light border-1 small" placeholder="ใส่ชื่อร้านค้า" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;" onkeyup="showText(this);">
						<!-- <div class="input-group-append">
							<button class="btn btn-primary" type="button">
								<i class="fas fa-search fa-sm"></i>
							</button>
						</div> -->
						<!-- <div class="input-group-append">
							<button class="btn btn-primary" type="button">
								<i class="fas fa-search fa-sm"></i>
							</button>
						</div> -->
					</div>
					<div class="row" id="showText">
						<!-- <div class="col mt-2" id="showText">
							<div class='col-5 bg-dark'>The number is " + json[i].g_name + "</div>
							<div class='col-'><button class='btn btn-sm btn-danger'>เส้นทาง</button></div>
						</div> -->
						<!-- <div class="col">
						</div> -->
					</div>
					<!-- <div class="row">
						<div class="col-3 text-right">รูปภาพ</div>
						<div class="col-6">
							<input type="file" name="picture" id="fileToUpload" onchange="goodspreviewFile(this);" required>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-3 text-right">ชื่อสินค้า</div>
						<div class="col-6">
							<input class="form-control form-control-sm" name="g_name"  type="text" required>
						</div>
					</div>
					<div class="row my-3">
						<div class="col-3 text-right">ราคา</div>
						<div class="col">
							<input class="form-control form-control-sm" name="g_price"  type="number" required>
						</div>
						<div class="col-3">บาท</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload Image">บันทึก</button>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const x					= document.getElementById("valueinstruction");
	const routeDisplay		= document.getElementById("routeDisplay");
	const startbt			= document.getElementById("start");
	const startDemobt		= document.getElementById("startDemo");
	const replaybt			= document.getElementById('replay');
	const startCLPointbt	= document.getElementById('startCurentLocationPoint');
	const getRoutebt		= document.getElementById('getRoute');
	const startPointbt		= document.getElementById('startPoint');
	const usePointbt		= document.getElementById('usePoint');
	const stopPointbt		= document.getElementById('stopPoint');
	const drivingbt			= document.getElementById('driving');
	const walkingbt			= document.getElementById('walking');
	const cyclingbt			= document.getElementById('cycling');
	const dropdownMenubt	= document.getElementById('dropdownMenu');
	const dropdownMenuStbt	= document.getElementById('dropdownMenuStart');
	const instructions		= document.getElementById('instructions');
	const closeinstructions	= document.getElementById('closeinstructions');
	const bginstructions	= document.getElementById('bginstructions');
	const showinstructions	= document.getElementById('showinstructions');
	const dropdownchoose	= document.getElementById('dropdownchoose');
	var checkStartPoint 	= false;
	var checkStopPoint		= false;
	var checkgetRoute		= false;
	var checkReplay			= false;
	var startPoint;
	var stopPoint;
	var type;
	let compass;
	const isIOS = (
		navigator.userAgent.match(/(iPod|iPhone|iPad)/i) &&
		navigator.userAgent.match(/AppleWebKit/i)
	);
	const isAndriods = navigator.userAgent.match(/Android/i)	
	var long 	= 100.469789
	var lat 	= 7.008181

	mapboxgl.accessToken = 'pk.eyJ1Ijoiem9ycmVlbmF0IiwiYSI6ImNrOW84Y2FteTA5b3MzbXA3cWN0eHVoemcifQ.yIvdBJcVxhwb3Yn3h5vYJQ';
	var map = new mapboxgl.Map({
		container: 'map', // container ID
		style: 'mapbox://styles/mapbox/streets-v11', // style URL
		center: [long, lat], // starting position [lng, lat]
		zoom: 17,
		testMode: true
	});	
	
	// Load an image from an external URL.
	map.loadImage('<?php echo site_url("assets/img/navigation/navigator.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('navigator', image);
	});

	map.loadImage('<?php echo site_url("assets/img/typeofmarket/wear.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('wear', image);
	});

	map.loadImage('<?php echo site_url("assets/img/typeofmarket/food.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('food', image);
	});

	map.loadImage('<?php echo site_url("assets/img/typeofmarket/souvenir.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('souvenir', image);
	});

	map.loadImage('<?php echo site_url("assets/img/typeofmarket/electronics.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('electronics', image);
	});

	map.loadImage('<?php echo site_url("assets/img/typeofmarket/fruits.png"); ?>', function (error, image) {
		if (error) throw error;
		// Add the image to the map style.
		map.addImage('fruits', image);
	});

	navigator.geolocation.getCurrentPosition(function (position) {})

	var markerStart	= new mapboxgl.Marker({color: '#394EEA'})
	var markerEnd	= new mapboxgl.Marker({color: '#fc544b'})
	var markerGPS	= new mapboxgl.Marker({color: '#66bb6a'})
	
	startCLPointbt.onclick = function() {
		navigator.geolocation.getCurrentPosition(function (position) {
			map.setCenter([position.coords.longitude, position.coords.latitude]);
			startPoint = [map.getCenter().lng.toFixed(6),map.getCenter().lat.toFixed(6)]
			markerStart.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
		})
	}

	startPointbt.onclick = function() {
		checkStartPoint = !checkStartPoint
		// console.log(checkStartPoint)
		if (checkStartPoint) {
			markerStart.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
			stopPointbt.className		= "d-none"
			getRoutebt.className		= "d-none"
			dropdownMenubt.className	= "d-none"
			usePoint.className			= "overlay btn btn-primary"
		}
	}

	stopPointbt.onclick = function() {
		checkStopPoint = !checkStopPoint
		// console.log(checkStopPoint)
		if (checkStopPoint) {
			markerEnd.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
			stopPointbt.innerHTML 		= "ใช้จุดนี้";
			getRoutebt.className		= "d-none"
			dropdownMenubt.className	= "d-none"
		} else {
			stopPoint = [map.getCenter().lng.toFixed(6),map.getCenter().lat.toFixed(6)]
			stopPointbt.innerHTML 		= "จุดปลายทาง";
			dropdownMenubt.className	= "overlay btn btn-primary dropdown-toggle"
			// console.log(stopPoint)
			if (startPoint != null && stopPoint != null) {
				getRoutebt.className	= "overlay btn btn-primary ml-2"
			}
		}
	}

	usePoint.onclick = function() {
		checkStartPoint = !checkStartPoint
		// console.log(checkStartPoint)
		startPoint = [map.getCenter().lng.toFixed(6),map.getCenter().lat.toFixed(6)]
		usePoint.className			= "d-none"
		dropdownMenubt.className	= "overlay btn btn-primary dropdown-toggle"
		stopPointbt.className		= "overlay btn btn-danger ml-2"
		if (startPoint != null && stopPoint != null) {
			getRoutebt.className	= "overlay btn btn-primary ml-2"
		}
	}

	getRoutebt.onclick = function() {
		checkgetRoute = !checkgetRoute
		// console.log('checkgetRoute = ' + checkgetRoute)
		if (checkgetRoute == false) {
			map.setBearing(0);
			map.setCenter([long, lat]);
			map.setZoom(17);
			if (map.getLayer('route')) map.removeLayer('route')
			if (map.getSource('route')) map.removeSource('route') 
			if (map.getLayer('point')) map.removeLayer('point') 
			if (map.getSource('point')) map.removeSource('point') 
			dropdownMenubt.className	= "overlay btn btn-primary dropdown-toggle"
			stopPointbt.className		= "overlay btn btn-danger ml-2"
			dropdownchoose.className	= "dropdown mr-2";
			drivingbt.className			= "d-none"
			walkingbt.className			= "d-none"
			cyclingbt.className			= "d-none"
			startbt.className			= "d-none"
			replaybt.className			= "d-none"
			routeDisplay.className		= "d-none";
			bginstructions.className	= "d-none";
			getRoutebt.innerHTML		= "เส้นทาง"
			x.innerHTML					= ""
		} else {
			type = 'driving'
			getRoute()
		}
	}

	drivingbt.onclick = function() {
		type = 'driving'
		getRoute()
		drivingbt.className		= "overlay btn btn-outline-success ml-2 active"
		walkingbt.className		= "overlay btn btn-outline-warning ml-2 bg-white"
		cyclingbt.className		= "overlay btn btn-outline-info ml-2 bg-white"
		
	}

	walkingbt.onclick = function() {
		type = 'walking'
		getRoute()
		drivingbt.className		= "overlay btn btn-outline-success ml-2 bg-white"
		walkingbt.className		= "overlay btn btn-outline-warning ml-2 active"
		cyclingbt.className		= "overlay btn btn-outline-info ml-2 bg-white"
	}

	cyclingbt.onclick = function() {
		type = 'cycling'
		getRoute()
		drivingbt.className		= "overlay btn btn-outline-success ml-2 bg-white"
		walkingbt.className		= "overlay btn btn-outline-warning ml-2 bg-white"
		cyclingbt.className		= "overlay btn btn-outline-info ml-2 active"
	}

	startbt.onclick = function() {
		drivingbt.className			= "d-none"
		walkingbt.className			= "d-none"
		cyclingbt.className			= "d-none"
		if (map.getSource('point') == null) {
			start()
		}
	}

	closeinstructions.onclick = function() {
		bginstructions.className = "d-none"
	}

	showinstructions.onclick = function() {
		bginstructions.className = "instructions form-control overflow-auto"
	}

	var shoptype = ["", "wear", "food", "souvenir", "electronics", "fruits"]

	map.on('load', function () {
		// Add a data source containing GeoJSON data.
		map.addSource('maine', {
			'type': 'geojson',
			'data': '<?php echo site_url("assets/map/gimyong.geojson"); ?>'
		})

		// Add a new layer to visualize the polygon.
		map.addLayer({
			'id': 'maine',
			'type': 'fill',
			'source': 'maine', // reference the data source
			'layout': {},
			'paint': {
				'fill-color': '#0080ff', // blue color fill
				'fill-opacity': 0.5
			}
		});

		// Add a black outline around the polygon.
		map.addLayer({
			'id': 'outline',
			'type': 'line',
			'source': 'maine',
			'layout': {},
			'paint': {
				'line-color': '#000',
				'line-width': 1
			}
		});

		// Add a data source containing GeoJSON data.
		map.addSource('60th', {
			'type': 'geojson',
			'data': '<?php echo site_url("assets/map/60th.geojson"); ?>'
		})

		// Add a new layer to visualize the polygon.
		map.addLayer({
			'id': '60th',
			'type': 'fill',
			'source': '60th', // reference the data source
			'layout': {},
			'paint': {
				'fill-color': '#0080ff', // blue color fill
				'fill-opacity': 0.5
			}
		});

		// Add a black outline around the polygon.
		map.addLayer({
			'id': 'outline60th',
			'type': 'line',
			'source': '60th',
			'layout': {},
			'paint': {
				'line-color': '#000',
				'line-width': 1
			}
		});

		addplaces ()

		// When a click event occurs on a feature in the places layer, open a popup at the
		// location of the feature, with description HTML from its properties.
		map.on('click', 'places', function (e) {
			var coordinates = e.features[0].geometry.coordinates.slice();
			var description = e.features[0].properties.description;
			
			// Ensure that if the map is zoomed out such that multiple
			// copies of the feature are visible, the popup appears
			// over the copy being pointed to.
			while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
				coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
			}
				
			new mapboxgl.Popup()
			.setLngLat(coordinates)
			.setHTML(description)
			.addTo(map)
		});
			
		// Change the cursor to a pointer when the mouse is over the places layer.
		map.on('mouseenter', 'places', function () {
			map.getCanvas().style.cursor = 'pointer';
		});
			
		// Change it back to a pointer when it leaves.
		map.on('mouseleave', 'places', function () {
			map.getCanvas().style.cursor = '';
		});

	})

	map.on('move', (e) => {

		if (checkStartPoint){
			if (map.getLayer('point') == null) {
				markerStart.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)])
				// x.innerHTML = 'lat = ' + map.getCenter().lng.toFixed(6) + ' | long = ' + map.getCenter().lat.toFixed(6) + ' \n zoom = ' + map.getZoom().toFixed(2);
			}
		}

		if (checkStopPoint){
			if (map.getLayer('point') == null) {
				markerEnd.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)])
				// x.innerHTML = 'lat = ' + map.getCenter().lng.toFixed(6) + ' | long = ' + map.getCenter().lat.toFixed(6) + ' \n zoom = ' + map.getZoom().toFixed(2);
			}
		}
		
	});
	
	function addplaces (check) {
		if (map.getLayer('places')) map.removeLayer('places') 
		if (map.getSource('places')) map.removeSource('places')

		if (check) {

			var url = '<?php echo site_url("index/addplaces/");?>' + check;
			var req = new XMLHttpRequest();
			req.open('GET', url, true);
			req.onload = function() {
				var json = JSON.parse(req.response);
				var e = []
				json.forEach(function(r){
					var x

					if (r['m_img']){
						x = '<img class="head" src="assets/img/market/'+r['m_img']+'" alt="Trulli">'
					} else {
						x = '<img class="head" src="assets/img/typeofmarket/' + shoptype[r['m_shoptype']] + '.png" alt="Trulli">'
					}
					
					Feature = {
						'type': 'Feature',
						'properties': {
							'description':
							'<br>'+
							x +
							'<br><br><strong>ชื่อร้าน : '+r['m_shopname']+'</strong>'+
							'<p>'+
								'รายละเอียด : '+r['m_shopdetail']+
							'</p>'+
							'<div class="d-flex">'+
								'<div class="col">'+
									'<button class="form-control form-control-sm overlay btn btn-sm btn-primary" onclick="getRoutePupup(['+r['m_lng']+', '+r['m_lat']+'])">เส้นทาง</button>'+
								'</div>'+
								'<div class="col">'+
									'<a href="<?php echo site_url("index/marketdetial/"); ?>'+r['m_id']+'" class="form-control form-control-sm overlay btn btn-sm btn-success">ละเอียดร้าน</a>' +
								'</div>'+
							'</div>'
							,
							'icon': shoptype[r['m_shoptype']]
						},
						'geometry': {
							'type': 'Point',
							'coordinates': [r['m_lng'], r['m_lat']]
						}
					}
					e.push(Feature)
				})
				if (json.length != 0) {
					map.addSource('places', {
						// This GeoJSON contains features that include an "icon"
						// property. The value of the "icon" property corresponds
						// to an image in the Mapbox Streets style's sprite.
						'type': 'geojson',
						'data': {
							'type': 'FeatureCollection',
							'features': e
						}
					});

					// Add a layer showing the places.
					map.addLayer({
						'id': 'places',
						'type': 'symbol',
						'source': 'places',
						'layout': {
							'icon-image': '{icon}',
							'icon-allow-overlap': true,
							'icon-size': 0.05
						}
					});
				}
			};
			req.send();

		} else {

			map.addSource('places', {
				// This GeoJSON contains features that include an "icon"
				// property. The value of the "icon" property corresponds
				// to an image in the Mapbox Streets style's sprite.
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': [
						<?php foreach ($marker as $r) : ?>
							{
								'type': 'Feature',
								'properties': {
									'description':
									'<br>'+
									<?php if ($r['m_img'] != ''): ?>
									'<img class="head" src="assets/img/market/<?=$r['m_img']?>" alt="Trulli">' +
									<?php else: ?>
									'<img class="head" src="assets/img/typeofmarket/' + shoptype[<?=$r['m_shoptype']?>] + '.png" alt="Trulli">' +
									<?php endif; ?>
									'<br><br><strong>ชื่อร้าน : <?=$r['m_name']?></strong>'+
									'<p>'+
										'รายละเอียด : <?=$r['m_shopdetail']?>'+
									'</p>'+
									'<div class="d-flex">'+
										'<div class="col">'+
											'<button class="form-control form-control-sm overlay btn btn-sm btn-primary" onclick="getRoutePupup([<?=$r['m_lng']?>, <?=$r['m_lat']?>])">เส้นทาง</button>'+
										'</div>'+
										'<div class="col">'+
											'<a href="<?php echo site_url("index/marketdetial/{$r['m_id']}"); ?>" class="form-control form-control-sm overlay btn btn-sm btn-success">ละเอียดร้าน</a>' +
										'</div>'+
									'</div>'
									,
									'icon': shoptype[<?=$r['m_shoptype']?>]
								},
								'geometry': {
									'type': 'Point',
									'coordinates': [<?=$r['m_lng']?>, <?=$r['m_lat']?>]
								}
							},
						<?php endforeach; ?>
					]
				}
			});

			// Add a layer showing the places.
			map.addLayer({
				'id': 'places',
				'type': 'symbol',
				'source': 'places',
				'layout': {
					'icon-image': '{icon}',
					'icon-allow-overlap': true,
					'icon-size': 0.05
				}
			});

		}

	}

	function showText(a) {
		// console.log(a.value)
		if (a.value) {
			var url = '<?php echo site_url("index/searchmarket");?>' ;
			var req = new XMLHttpRequest();
			req.open('POST', url, true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.onload = function() {
				var json = JSON.parse(req.response);
				if (json.length != 0) {
					console.log(json)
					var text = ''
					for (i = 0; i < json.length; i++) {
						text += "<div class='col-8 col-lg-9 mt-2'><span class='align-middle text-primary'>" + json[i].g_name + " - ร้าน" + json[i].m_shopname +"</span></div><div class='col-4 col-lg-3 mt-2 text-right'><button class='btn btn-sm btn-danger' data-dismiss='modal' onclick='getRoutePupup([" + json[i].m_lng + "," + json[i].m_lat + "]);'>เส้นทาง</button></div>";
					}
					document.getElementById("showText").innerHTML = text
				} else {
					console.log('no data')
					document.getElementById("showText").innerHTML = "<div class='col mt-2 text-center'><span class='align-middle text-primary'>-- NO DATA --</span></div>";
				}
			}
			req.send("data="+a.value);
		} 
		else {
			// console.log('')
			document.getElementById("showText").innerHTML = "";
			// document.getElementById("showText").innerHTML = "<div class='col mt-2 text-center'><span class='align-middle text-primary'>-- NO DATA --</span></div>";

		}
		
	}

	function start () {
		map.setZoom(17);
		replaybt.className = "d-none";
		startbt.className = "d-none";
		var url = 'https://api.mapbox.com/directions/v5/mapbox/' + type + '/' + startPoint[0] + ',' + startPoint[1] + ';' + stopPoint[0] + ',' + stopPoint[1] + '?geometries=geojson&steps=true&overview=full&access_token=' + mapboxgl.accessToken;
		var req = new XMLHttpRequest();
		req.open('GET', url, true);
		req.onload = function() {
			bginstructions.className = "d-none";
			routeDisplay.className = "outputroute d-flex justify-content-center bg-white";
			var json = JSON.parse(req.response);
			var data = json.routes[0];
			var route = data.geometry.coordinates;
			var turn = [];

			for (var i = 0; i < data.legs[0].steps.length; i++) {
				turn.push(data.legs[0].steps[i].maneuver.location)
			}

			const turnlong	= turn.map(x => x[0]);
			const turnlat	= turn.map(x => x[1]);

			// console.log(turn)
			// console.log(turnlong)
			// console.log(turnlat)

			// console.log(data.legs[0].steps[0].distance)


			// San Francisco
			var origin		= route[0];
				
			// Washington DC
			var destination	= [route[route.length-1]];

			// A simple line from origin to destination.
			// var line = {
			// 	'type': 'FeatureCollection',
			// 	'features': [
			// 		{
			// 			'type': 'Feature',
			// 			'geometry': {
			// 				'type': 'LineString',
			// 				'coordinates': route
			// 			}
			// 		}
			// 	]
			// };


			// A single point that animates along the route.
			// Coordinates are initially set to origin.
			var point = {
				'type': 'FeatureCollection',
				'features': [
					{
						'type': 'Feature',
						'properties': {},
						'geometry': {
							'type': 'Point',
							'coordinates': origin
						}
					}
				]
			};

			var arc = [];


			//NORMAL VERSION

			// Calculate the distance in kilometers between route start/end point.
			// var lineDistance = turf.length(line, {units: 'kilometers'});

			// lineDistance0 = turf.length(line0.features[0], {units: 'kilometers'});
			// console.log('lineDistance : ' + lineDistance)

			// console.log('Total distance: ' + lineDistance.toFixed(3) + ' km')
			// console.log('Total distance: ' + lineDistance.toFixed(3)*1000 + ' m')
			
			// Number of steps to use in the arc and animation, more steps means
			// a smoother arc and animation, but too many steps will result in a
			// low frame rate
			// var steps = lineDistance.toFixed(3)*1000;

			// console.log('steps : ' + steps)
			
			// Draw an arc between the `origin` & `destination` of the two points
			// for (var i = 0; i < lineDistance; i += lineDistance / steps) {
			// 	var segment = turf.along(line.features[0], i);
			// 	arc.push(segment.geometry.coordinates);
			// }
			
			
			// Update VERSION
			for (var i = 0; i < data.legs[0].steps.length; i++) {
				var linec = turf.lineString(data.legs[0].steps[i].geometry.coordinates);
				for (var j = 0; j < data.legs[0].steps[i].distance/1000; j += (data.legs[0].steps[i].distance/1000)/data.legs[0].steps[i].distance) {
					var segment = turf.along(linec, j);
					arc.push(segment.geometry.coordinates);
				}
				// console.log(linec)	
			}

			// DEMO ROUTE
			const routelong	= arc.map(x => x[0]);
			const routelat	= arc.map(x => x[1]);

			// Location ROUTE
			// const routelong	= arc.map(x => x[0].toFixed(6));
			// const routelat	= arc.map(x => x[1].toFixed(6));



			// console.log('arc.length : ' + arc[arc.length-1])
			if (arc.length != route[route.length-1]) {
				arc.push(destination[0]);
			}
			// console.log('arc.length : ' + arc[arc.length-1])

			// Update the route with calculated arc coordinates
			// line.features[0].geometry.coordinates = arc;
			// const routelong	= arc.map(x => x[0].toFixed(6));
			// const routelat	= arc.map(x => x[1].toFixed(6));
			// console.log(routelong)
			// console.log(routelat)
			// console.log(arc)
			

			var turnbyturn = []

			for (i = 0; i < turn.length; i++) {
				console.log('DDDDDD ' + i)
				console.log(turn[i])
				var line1 = turf.lineString(arc);
				var pt1 = turf.point(turn[i]);
				var snapped = turf.nearestPointOnLine(line1, pt1, {units: 'kilometers'});
				console.log(snapped)
				console.log(snapped.geometry.coordinates[0].toFixed(6))
				var snappedflong	= routelong.findIndex(function myFunction(value, index, array) {
					return value == snapped.geometry.coordinates[0].toFixed(6);
				});
				var snappedllong	= routelong.findIndex(function myFunction(value, index, array) {
					return value == snapped.geometry.coordinates[0].toFixed(6);
				});
				var snappedflat		= routelat.findIndex(function myFunction(value, index, array) {
					return value == snapped.geometry.coordinates[1].toFixed(6);
				});
				var snappedllat		= routelat.findIndex(function myFunction(value, index, array) {
					return value == snapped.geometry.coordinates[1].toFixed(6);
				});

				if (snappedflong != -1 && snappedflat != -1) {
					if (snappedflong == snappedflat) {
						turnbyturn.push(snappedflong);
						console.log('Prefect = ' + snappedflong)
					}  
				} else {
					console.log('snapped ' + snapped.geometry.coordinates[1].toFixed(6));
					console.log(routelat.lastIndexOf(snapped.geometry.coordinates[1]));
					console.log('Lastpoint')
					turnbyturn.push((arc.length)-1);
				}

				console.log('snappedflong = ' + snappedflong)
				console.log('snappedllong = ' + snappedllong)
				console.log('snappedflat = ' + snappedflat)
				console.log('snappedllat = ' + snappedllat)

				// if (snappedflong != -1 && snappedflat != -1) {
				// 	if (snappedflong == snappedflat) {
				// 		turnbyturn.push(snappedflong);
				// 		console.log('Preject = ' + snappedflong)
				// 	} else {
				// 		console.log('Preject2 = ' + snappedflong + ' ' + snappedflat)
				// 		// console.log('PrejectCall = ' + (snappedflong + snappedflat)/2)
				// 		console.log('PrejectCall = ' + Math.max(snappedflong, snappedflat))
				// 		// turnbyturn.push((snappedflong + snappedflat)/2);
				// 		turnbyturn.push(Math.max(snappedflong, snappedflat));
						
				// 	} 
				// } else {
				// 	// console.log(snappedflong)
				// 	var snappedflongMath = parseFloat(snapped.geometry.coordinates[0].toFixed(6))
				// 	if (snappedflong == -1) {
				// 		for (j = 0; j < 10; j++) {
				// 			snappedflongMath = snappedflongMath + 0.000001
				// 			// console.log('snappedflongMath = ' + snappedflongMath)
				// 			snappedflong = routelong.findIndex(function myFunction(value, index, array) {
				// 				return value == snappedflongMath.toFixed(6);
				// 			});
				// 			if (snappedflong != -1) { break; }
				// 		}
				// 	}
				// 	// console.log(snappedflong)

					
				// 	// console.log(snappedllong)
				// 	var snappedllongMath = parseFloat(snapped.geometry.coordinates[0].toFixed(6))
				// 	if (snappedllong == -1) {
				// 		for (j = 0; j < 10; j++) {
				// 			snappedllongMath = Math.floor((snappedllongMath - 0.000001)*1000000)/1000000
				// 			// console.log('snappedllongMath = ' + snappedllongMath)
				// 			snappedllong = routelong.findIndex(function myFunction(value, index, array) {
				// 				return value == snappedllongMath.toFixed(6);
				// 			});
				// 			if (snappedllong != -1) { break; }
				// 		}
				// 	}
				// 	// console.log(snappedllong)

				// 	console.log("lattllll")
					
					
				// 	// console.log(snappedflat)
				// 	var snappedflatMath = parseFloat(snapped.geometry.coordinates[1].toFixed(6))
				// 	if (snappedflat == -1) {
				// 		for (j = 0; j < 10; j++) {
				// 			snappedflatMath = Math.floor((snappedflatMath + 0.000001)*1000000)/1000000
				// 			// console.log('snappedflatMath = ' + snappedflatMath)
				// 			snappedflat = routelat.findIndex(function myFunction(value, index, array) {
				// 				return value == snappedflatMath.toFixed(6);
				// 			});
				// 			if (snappedflat != -1) { break; }
				// 		}
				// 	}
				// 	// console.log(snappedflat)

					
				// 	// console.log(snappedllat)
				// 	var snappedllatMath = parseFloat(snapped.geometry.coordinates[1].toFixed(6))
				// 	if (snappedllat == -1) {
				// 		for (j = 0; j < 10; j++) {
				// 			snappedllatMath = Math.floor((snappedllatMath - 0.000001)*1000000)/1000000
				// 			// console.log('snappedflatMath = ' + snappedllatMath)
				// 			snappedllat = routelat.findIndex(function myFunction(value, index, array) {
				// 				return value == snappedllatMath.toFixed(6);
				// 			});
				// 			if (snappedllat != -1) { break; }
				// 		}
				// 	}
				// 	// console.log(snappedllat)

				// 	if (snappedflong != -1) {
				// 		if (snappedflong == snappedflat) {
				// 			if (turnbyturn[i] == null) {
				// 				turnbyturn.push(snappedflong);
				// 				console.log('V1 = ' + snappedflong)
				// 			}	
				// 		}
				// 		if (snappedflong == snappedllat) {
				// 			if (turnbyturn[i] == null) {
				// 				turnbyturn.push(snappedflong);
				// 				console.log('V2 = ' + snappedflong)
				// 			}	
				// 		}
				// 	} else if (snappedllong != -1) {
				// 		if (snappedllong == snappedflat) {
				// 			if (turnbyturn[i] == null) {
				// 				turnbyturn.push(snappedllong);
				// 				console.log('V3 = ' + snappedllong)
				// 			}
				// 		}
				// 		if (snappedllong == snappedllat) {
				// 			if (turnbyturn[i] == null) {
				// 				turnbyturn.push(snappedllong);
				// 				console.log('V4 = ' + snappedllong)
				// 			}
				// 		}
				// 	}	

				// 	console.log('snappedflong = ' + snappedflong)
				// 	console.log('snappedllong = ' + snappedllong)
				// 	console.log('snappedflat = ' + snappedflat)
				// 	console.log('snappedllat = ' + snappedllat)
				// 	var array = [snappedflong, snappedllong, snappedflat, snappedllat]
				// 	var filter = array.filter(function (value, index, array) {
				// 		return value != -1;
				// 	})
				// 	var filtercall = 0;
				// 	for (j = 0; j < filter.length; j++){
				// 		filtercall += filter[j]
				// 	}
				// 	if (turnbyturn[i] == null) {
				// 		console.log('V5 = ' + Math.round(filtercall/filter.length))
				// 		turnbyturn.push(Math.round(filtercall/filter.length));
				// 	}

				// }
			}

			console.log(turnbyturn)


			
			// var turnbyturn = []

			// for (i = 0; i < turn.length; i++) {
			// 	console.log(i)
			// 	var fturnlong	= routelong.findIndex(function myFunction(value, index, array) {
			// 		return value == turnlong[i];
			// 	});
			// 	var lturnlong = routelong.findIndex(function myFunction(value, index, array) {
			// 		return value == turnlong[i];
			// 	});
			// 	var fturnlat	= routelat.findIndex(function myFunction(value, index, array) {
			// 		return value == turnlat[i];
			// 	});
			// 	var lturnlat	= routelat.findIndex(function myFunction(value, index, array) {
			// 		return value == turnlat[i];
			// 	});
			// 	if (fturnlong != -1 && fturnlat != -1) {
			// 		if (fturnlong == fturnlat) {
			// 			console.log('Perfect ' + fturnlong)
			// 			turnbyturn.push(fturnlong);
			// 		}
			// 	} else {
			// 		flatMath = turnlat[i]
			// 		for (j = 0; j < 11; j++) {
			// 			// console.log('turnlong = ' + flatMath)
			// 			fturnlat = routelat.findIndex(function myFunction(value, index, array) {
			// 				return value == flatMath.toFixed(6);
			// 			});
			// 			flatMath = flatMath + 0.000001
			// 			if (fturnlat != -1) { break; }
			// 		}
			// 		llatMath = turnlat[i]
			// 		for (j = 0; j < 11; j++) {
			// 			// console.log('turnlong = ' + llatMath)
			// 			lturnlat = routelat.findIndex(function myFunction(value, index, array) {
			// 				return value == llatMath.toFixed(6);
			// 			});
			// 			llatMath = llatMath - 0.000001
			// 			if (lturnlat != -1) { break; }
			// 		}
			// 		flongMath = turnlong[i]
			// 		for (j = 0; j < 11; j++) {
			// 			// console.log('turnlong = ' + flongMath)
			// 			fturnlong = routelong.findIndex(function myFunction(value, index, array) {
			// 				return value == flongMath.toFixed(6);
			// 			});
			// 			flongMath = flongMath + 0.000001
			// 			if (fturnlong != -1) { break; }
			// 		}
			// 		llongMath = turnlong[i]
			// 		for (j = 0; j < 11; j++) {
			// 			// console.log('turnlong = ' + llongMath)
			// 			lturnlong = routelong.findIndex(function myFunction(value, index, array) {
			// 				return value == llongMath.toFixed(6);
			// 			});
			// 			llongMath = llongMath - 0.000001
			// 			if (lturnlong != -1) { break; }
			// 		}

			// 		if (fturnlat != -1) {
			// 			if (fturnlat == fturnlong) {
			// 				turnbyturn.push(fturnlat);
			// 				console.log('V1 = ' + fturnlat)
			// 			}
			// 			if (fturnlat == lturnlong) {
			// 				turnbyturn.push(fturnlat);
			// 				console.log('V2 = ' + fturnlat)
			// 			}
			// 		} else if (lturnlat != -1) {
			// 			if (lturnlat == fturnlong) {
			// 				turnbyturn.push(lturnlat);
			// 				console.log('V3 = ' + lturnlat)
			// 			}
			// 			if (lturnlat == lturnlong) {
			// 				turnbyturn.push(lturnlat);
			// 				console.log('V4 = ' + lturnlat)
			// 			}
			// 		}					
					
			// 		console.log('fturnlat = ' + fturnlat)
			// 		console.log('lturnlat = ' + lturnlat)
			// 		console.log('fturnlong = ' + fturnlong)
			// 		console.log('lturnlong = ' + lturnlong)
			// 		var array = [fturnlat,lturnlat,fturnlong,lturnlong]
			// 		var filter = array.filter(function (value, index, array) {
			// 			return value != -1;
			// 		})
			// 		var filtercall = 0;
			// 		for (j = 0; j < filter.length; j++){
			// 			filtercall += filter[j]
			// 		}
			// 		console.log(Math.round(filtercall/filter.length))
			// 		if (turnbyturn[i] == null) {
			// 			turnbyturn.push(Math.round(filtercall/filter.length));
			// 		}

			// 	}

			// }

			// console.log(turnbyturn)

			

		
			// Used to increment the value of the point measurement against the route.
			var counter = 0;

			// Add a source and layer displaying a point which will be animated in a circle.
			if (map.getSource('route') == null) {
				map.addSource('route', {
					'type': 'geojson',
					'data': line
				});
			}
				
			if (map.getSource('point') == null) {
				map.addSource('point', {
					'type': 'geojson',
					'data': point
				});
			}
			
			if (map.getLayer('point') == null) {
				map.addLayer({
					'id': 'point',
					'source': 'point',
					'type': 'symbol',
					'layout': {
						// This icon is a part of the Mapbox Streets style.
						// To view all images available in a Mapbox style, open
						// the style in Mapbox Studio and click the "Images" tab.
						// To add a new image to the style at runtime see
						// https://docs.mapbox.com/mapbox-gl-js/example/add-image/
						// 'icon-image': 'airport-15',
						'icon-image': 'navigator',
						'icon-rotate': ['get', 'bearing'],
						'icon-rotation-alignment': 'map',
						'icon-allow-overlap': true,
						'icon-ignore-placement': true,
						'icon-size': 0.5
						// 'icon-size': 0.1
					}
				});
			}
				
			function animate() {
				
				//DEMO NAVIGATION	
				// var start	= line.features[0].geometry.coordinates[counter >= steps ? counter - 1 : counter];
				// var end		= line.features[0].geometry.coordinates[counter >= steps ? counter : counter + 1];
				var start	= arc[counter >= arc.length-1 ? counter - 1 : counter];
				var end		= arc[counter >= arc.length-1 ? counter : counter + 1];
							
				if (!start || !end) return;
							
				if (counter < 0){
					counter = 0
				}

				map.setCenter(arc[counter]);

				// Update point geometry to a new position based on counter denoting
				// the index to access the arc
				// point.features[0].geometry.coordinates =
				// line.features[0].geometry.coordinates[counter];
				point.features[0].geometry.coordinates = arc[counter];
						
				// Calculate the bearing to ensure the icon is rotated to match the route arc
				// The bearing is calculated between the current point and the next point, except
				// at the end of the arc, which uses the previous point and the current point
				point.features[0].properties.bearing = turf.bearing(
					turf.point(start),
					turf.point(end)
				);

				map.setBearing(point.features[0].properties.bearing);
						
				// Update the source with this new data
				if (map.getSource('point') != null && checkReplay == false) {
					map.getSource('point').setData(point);
					// Request the next frame of animation as long as the end has not been reached
					if (counter < arc.length-1) {
						setTimeout(function(){
							for (i = 0; i < turnbyturn.length; i++) {
								if (counter > turnbyturn[i]) {
									if (data.legs[0].steps[i].distance >= 1000) {
										x.innerHTML = data.legs[0].steps[i].maneuver.instruction + ' and go straight ' + Math.round(data.legs[0].steps[i].distance/1000) + ' Km';
									} else {
										x.innerHTML = data.legs[0].steps[i].maneuver.instruction + ' and go straight ' + Math.round(data.legs[0].steps[i].distance) + ' m';
									}
								}
							}
							requestAnimationFrame(animate);
							// x.innerHTML = 'center = ' + arc[counter][0].toFixed(6) + ',' + arc[counter][1].toFixed(6) + ' counter = ' + counter;
						}, 0);
					} else {
						checkReplay = !checkReplay
						replaybt.className = "overlay btn btn-primary ml-2";
						x.innerHTML = '>>END<<';
					}
				} else {
					map.setCenter([long, lat]);
					map.setBearing(0);
				}
				
				// console.log(fturnlong)
				// console.log(fturnlat)
				counter = counter + 1;
				//DEMO NAVIGATION

				// //GPS NAVIGATION
				// navigator.geolocation.getCurrentPosition(
				// 	function (position) {
					
				// 		longCurrent	= position.coords.longitude;
				// 		latCurrent	= position.coords.latitude;
						
				// 		// var start	= line.features[0].geometry.coordinates[counter >= steps ? counter - 1 : counter];
				// 		// var end		= line.features[0].geometry.coordinates[counter >= steps ? counter : counter + 1];
				// 		var start	= arc[counter >= arc.length-1 ? counter - 1 : counter];
				// 		var end		= arc[counter >= arc.length-1 ? counter : counter + 1];

				// 		// console.log(arc)

								
				// 		if (!start || !end) return;

				// 		var lineMap = turf.lineString(arc);
				// 		var pt = turf.point([longCurrent, latCurrent]);
				// 		var snapped = turf.nearestPointOnLine(lineMap, pt, {units: 'kilometers'});

				// 		var firstlong	= routelong.findIndex(function myFunction(value, index, array) {
				// 			return value == snapped.geometry.coordinates[0].toFixed(6);
				// 		});

				// 		var firstlat	= routelat.findIndex(function myFunction(value, index, array) {
				// 			return value == snapped.geometry.coordinates[1].toFixed(6);
				// 		});

				// 		// console.log(firstlong)
				// 		// console.log(firstlat)

				// 		longMath	= parseFloat(snapped.geometry.coordinates[0].toFixed(6))
				// 		latMath		= parseFloat(snapped.geometry.coordinates[1].toFixed(6))

				// 		if (firstlong == -1 && firstlat == -1){
				// 			for (i = 0; i < 11; i++) {
				// 				longMath = longMath + 0.000001
				// 				firstlong = routelong.findIndex(function myFunction(value, index, array) {
				// 					return value == longMath.toFixed(6);
				// 				});
				// 				if (firstlong != -1) { break; }
				// 				// console.log(longMath.toFixed(6))
				// 			}

				// 			for (i = 0; i < 11; i++) {
				// 				latMath = latMath + 0.000001
				// 				firstlat = routelat.findIndex(function myFunction(value, index, array) {
				// 					return value == latMath.toFixed(6);
				// 				});
				// 				if (firstlat != -1) { break; }
				// 				// console.log(latMath.toFixed(6))
				// 			}
				// 		}

				// 		// console.log('newlong = ' + firstlong)
				// 		// console.log('newlat = ' + firstlat)

				// 		counterMath = Math.max(firstlat, firstlong);
				// 		counter = counterMath

				// 		// counter2 = Math.round((firstlat+firstlong)/2);
				// 		// console.log('counteraverage = ' + counter2)
							
				// 		if (counter < 0){
				// 			counter = 0
				// 		}
						
				// 		// map.flyTo({
				// 		// 	center: arc[counter],
				// 		// 	speed: 5,
				// 		// 	zoom: 18
				// 		// });

				// 		// console.log(map.isZooming())

				// 		map.setCenter(arc[counter]);
				// 		// map.setZoom(17);

				// 		// Update point geometry to a new position based on counter denoting
				// 		// the index to access the arc
				// 		// point.features[0].geometry.coordinates =
				// 		// line.features[0].geometry.coordinates[counter];
				// 		point.features[0].geometry.coordinates = arc[counter];
						
				// 		// Calculate the bearing to ensure the icon is rotated to match the route arc
				// 		// The bearing is calculated between the current point and the next point, except
				// 		// at the end of the arc, which uses the previous point and the current point
				// 		point.features[0].properties.bearing = turf.bearing(
				// 			turf.point(start),
				// 			turf.point(end)
				// 		);

				// 		map.setBearing(point.features[0].properties.bearing);

				// 		// console.log(map.getSource('point').setData(point))
				// 		// map.getSource('point').setData(point);
				// 		// Update the source with this new data
				// 		if (map.getSource('point') != null && checkReplay == false) {
				// 			map.getSource('point').setData(point);
				// 			// Request the next frame of animation as long as the end has not been reached
				// 			if (counter < arc.length-1) {
				// 				setTimeout(function(){
				// 					for (i = 0; i < turnbyturn.length; i++) {
				// 						if (counter > turnbyturn[i]) {
				// 							x.innerHTML = data.legs[0].steps[i].maneuver.instruction + ' and go straight ' + Math.round(data.legs[0].steps[i].distance) + ' m';
				// 						}
				// 						if (counter = turnbyturn[i]) {
				// 							x.innerHTML = data.legs[0].steps[i].maneuver.instruction + ' and go straight ' + Math.round(data.legs[0].steps[i].distance) + ' m';
				// 						}
				// 					}
				// 					markerGPS.setLngLat([longCurrent, latCurrent]).addTo(map)
				// 					requestAnimationFrame(animate);
				// 					// x.innerHTML = 'center = ' + arc[counter][0].toFixed(6) + ',' + arc[counter][1].toFixed(6) + ' counter = ' + counter;
				// 				}, 0);
				// 			} else {
				// 				checkReplay = !checkReplay
				// 				replaybt.className = "overlay btn btn-primary ml-2";
				// 				x.innerHTML = '>>END<<';
				// 				markerGPS.remove()
				// 			}
				// 		} else {
				// 			markerGPS.remove()
				// 		}
				// 	}
				// )
				// //GPS NAVIGATION
					
			}

			replaybt.onclick = function() {
				x.innerHTML = '>>RESTART<<';
				replaybt.className = "d-none";
				setTimeout(function(){
					checkReplay = !checkReplay
					counter = 0
					animate()
				}, 1000);
			}

			// Start the animation
			// animate(counter);
			animate();

		};
		req.send();

	}

	function getsearchlaglat(lng, lat) {
		console.log(lng + ' ' + lat)
	}

	// create a function to make a directions request
	function getRoute() {

		if (checkReplay == true) {
			checkReplay = !checkReplay
		}

		if (map.getLayer('point')) map.removeLayer('point') 
		if (map.getSource('point')) map.removeSource('point') 

		getRoutebt.innerHTML 		= "ยกเลิกเส้นทาง"
		dropdownMenubt.className	= "d-none"
		stopPointbt.className		= "d-none"
		replaybt.className			= "d-none"
		dropdownchoose.className	= "d-none";
		startbt.className 			= "overlay btn btn-primary ml-2"
		drivingbt.className			= "overlay btn btn-outline-success ml-2 active"
		walkingbt.className			= "overlay btn btn-outline-warning ml-2 bg-white"
		cyclingbt.className			= "overlay btn btn-outline-info ml-2 bg-white"
		getRoutebt.className		= "overlay btn btn-primary ml-2"

		// make a directions request using cycling profile
		// an arbitrary start will always be the same
		// only the end or destination will change
		var url = 'https://api.mapbox.com/directions/v5/mapbox/' + type + '/' + startPoint[0] + ',' + startPoint[1] + ';' + stopPoint[0] + ',' + stopPoint[1] + '?geometries=geojson&steps=true&overview=full&access_token=' + mapboxgl.accessToken;

		// make an XHR request https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
		var req = new XMLHttpRequest();
		req.open('GET', url, true);
		req.onload = function() {
			var json = JSON.parse(req.response);
			// console.log(json)
			var data = json.routes[0];
			var route = data.geometry.coordinates;
			var geojson = {
				type: 'Feature',
				properties: {},
				geometry: {
					type: 'LineString',
					coordinates: route
				}
			};
			// if the route already exists on the map, reset it using setData
			if (map.getSource('route')) {
				map.getSource('route').setData(geojson);
			} else { // otherwise, make a new request
				map.addLayer({
					id: 'route',
					type: 'line',
					source: {
					type: 'geojson',
					data: {
						type: 'Feature',
						properties: {},
						geometry: {
							type: 'LineString',
							// coordinates: geojson
							coordinates: route
						}
					}
					},
					layout: {
					'line-join': 'round',
					'line-cap': 'round'
					},
					paint: {
					'line-color': '#b638be',
					'line-width': 10,
					'line-opacity': 0.75
					}
				});
			}

			var fitBounds = route
			fitBounds.unshift(startPoint); 
			fitBounds.push(stopPoint)
			var linebbox = turf.lineString(fitBounds);
			var bbox = turf.bbox(linebbox);

			// add turn instructions here at the end
			map.fitBounds([[bbox[0],bbox[1]],[bbox[2],bbox[3]]], {
				padding: {top: 100, bottom:100, left: 100, right: 100}
			});

			var steps = data.legs[0].steps;
			var distance = data.distance;
			var tripInstructions = [];
			for (var i = 0; i < steps.length; i++) {
				// console.log(i)
				// console.log(steps.length-1)
				if (i < steps.length-1){
					if (Math.round(steps[i].distance) >= 1000) {
						tripInstructions.push('<br><li>' + steps[i].maneuver.instruction + ' distance: ' + Math.round(steps[i].distance/1000) + ' Km') + '</li>';
					} else {
						tripInstructions.push('<br><li>' + steps[i].maneuver.instruction + ' distance: ' + Math.round(steps[i].distance) + ' m') + '</li>';
					}
				} else {
					tripInstructions.push('<br><li>' + steps[i].maneuver.instruction) + '</li>';
				}
				if (distance >= 1000){
					instructions.innerHTML = '<div><br><span>Trip duration: ' + 
					Math.floor(data.duration / 60) + 
					' min <br> distance: ' +
					(distance/1000).toFixed(3) + ' Km</span>' + 
					tripInstructions +
					'</div>';
				} else {
					instructions.innerHTML = '<div><br><span>Trip duration: ' + 
					Math.floor(data.duration / 60) + 
					' min <br> distance: ' +
					Math.floor(distance) + ' m</span>' + 
					tripInstructions +
					'</div>';
				}

				bginstructions.className = 'instructions form-control overflow-auto'
			}



		};
		req.send();	

	}

	// create a function to make a directions request
	function getRoutePupup(end) {
		if (map.getSource('point') != null && checkReplay == false) {
			// console.log("No")
		} else {
			navigator.geolocation.getCurrentPosition(function (position) {
				if (checkgetRoute == false) {
					checkgetRoute = !checkgetRoute
				}
				if (checkReplay == true) {
					checkReplay = !checkReplay
				}
				// console.log(checkgetRoute)
				startPoint	= [position.coords.longitude, position.coords.latitude]
				stopPoint	= end
				type		= 'driving'
				markerStart.setLngLat(startPoint).addTo(map)
				markerEnd.setLngLat(stopPoint).addTo(map)
				getRoute()
			})
		}
	}
	
</script>