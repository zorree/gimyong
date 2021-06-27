
  <meta charset='utf-8' />
  <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
  <!-- Import Mapbox GL JS  -->
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
  <!-- Import jQuery -->
  <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->

  <style>

    #map {
	    height: 300px;
    }
    
    .head {
        width: 50%;
        height: 300px;
    }

    @media screen and (max-width: 480px) {
		.head {
            width: 100%;
            height: 300px;
        }
	}

  </style>

<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">รายละเอียดร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item"><a href="<?php echo site_url("market/profile"); ?>">ร้านค้า</a></li>
			<li class="breadcrumb-item active" aria-current="page">แก้ไขรายละเอียดร้านค้า</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h3 class="m-0 font-weight-bold text-primary">
                    แก้ไขรายละเอียดร้านค้า
				</h3>
			</div>
			<div class="card-body">
				<form action="<?php echo site_url("market/marketeditaction");?>" method="post"  role="form" enctype="multipart/form-data">
                    <div class="row text-center">
                        <div class="col-sm">
                            <?php if ($marketdetail[0]['m_img'] != ''): ?>
                                <img id="previewImg" src="<?php echo site_url('assets/img/market/'.$marketdetail[0]['m_img']); ?>" class="img-thumbnail head">
                            <?php else: ?>
                                <img id="previewImg" src="<?php echo site_url('assets/img/logo/store.png'); ?>" class="img-thumbnail head">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4 text-right">
                            รูปภาพ :
                        </div>
                        <div class="col-8 col-xl-6 bg-blue overflow-auto">
                            <input type="file" name="picture" id="fileToUpload" onchange="previewFile(this);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4 text-right">
                            ชื่อร้าน :
                        </div>
                        <div class="col col-xl-6">
                            <input class="form-control form-control-sm" type="text" name="m_shopname" value="<?php echo $marketdetail[0]['m_shopname'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            เจ้าของร้าน :
                        </div>
                        <div class="col col-xl-3 pr-0">
                            <input class="form-control form-control-sm" type="text" name="m_name" value="<?php echo $marketdetail[0]['m_name'];?>">
                        </div>
                        <div class="col col-xl-3 pl-0">
                            <input class="form-control form-control-sm" type="text" name="m_lname" value="<?php echo $marketdetail[0]['m_lname'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            ประเภท :
                        </div>
                        <div class="col col-xl-3 pr-sm-0">
                            <!-- <input class="form-control form-control-sm" type="text" name="m_shoptype" value="<?php echo $marketdetail[0]['m_shoptype'];?>"> -->
                            <select class="form-control form-control-sm" name="m_shoptype">
                                <option selected disabled>เลือกประเภทร้าน</option>
                                <option value="1" <?php if ($marketdetail[0]['m_shoptype'] == 1):?><?='selected'?><?php endif; ?>>เสื้อผ้า</option>
                                <option value="2" <?php if ($marketdetail[0]['m_shoptype'] == 2):?><?='selected'?><?php endif; ?>>อาหาร</option>
                                <option value="3" <?php if ($marketdetail[0]['m_shoptype'] == 3):?><?='selected'?><?php endif; ?>>ของฝาก</option>
                                <option value="4" <?php if ($marketdetail[0]['m_shoptype'] == 4):?><?='selected'?><?php endif; ?>>เครื่องใช้ไฟฟ้า</option>
                                <option value="5" <?php if ($marketdetail[0]['m_shoptype'] == 5):?><?='selected'?><?php endif; ?>>ผลไม้</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-right">
                            รายละเอียดร้าน :
                        </div>
                        <div class="col col-xl-6">
                            <textarea class="form-control" name="m_shopdetail"><?php echo $marketdetail[0]['m_shopdetail'];?></textarea>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col">
                            <h4>ภาพแผนที่ตั้งร้าน</h4>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col">
                            <div id='map'>
                                <div class="position-relative d-flex justify-content-center p-2" style="z-index: 1;">
                                    <button type="button" class="btn-sm btn-success form-control" id="markgps">GPS</button>
                                    <button type="button" class="ml-2 btn-sm btn-primary form-control" id="markchoose">เลือกจุดเอง</button>
                                    <button type="button" class="d-none" id="mychoose">เลือกจุดนี้</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-4 col-xl-2">ลองติจูด</div>
                        <div class="col-8 col-xl-4"><input class="form-control form-control-sm" type="text" id="mlong" name="m_lng" value="<?php echo $marketdetail[0]['m_lng'];?>"></div>
                        <div class="col-4 col-xl-2">ละติจูด</div>
                        <div class="col-8 col-xl-4"><input class="form-control form-control-sm" type="text" id="mlat"  name="m_lat" value="<?php echo $marketdetail[0]['m_lat'];?>"></div>
                    </div>
					<div class="row text-center">
						<div class="col-6 mt-3">
                            <input type="hidden" name="m_id" value="<?php echo $marketdetail[0]['m_id'];?>">
							<button class="btn form-control btn-sm btn-success" type="submit" name="submit" value="submit">ยืนยัน</button>
                        </div>
						<div class="col-6 mt-3">
                            <a href="<?php echo site_url("market/profile"); ?>" class="btn form-control btn-sm btn-light d-flex align-items-center justify-content-center">ยกเลิก</a>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

<!-- Create a container for the map -->

<script>

    // id choose marker
    var markgps         = document.getElementById("markgps");
    var markchoose      = document.getElementById("markchoose");
    var mychoose        = document.getElementById("mychoose");
    var mlong           = document.getElementById("mlong");
    var mlat            = document.getElementById("mlat");
    var choosecheck     = false;

	// Add your Mapbox access token
	mapboxgl.accessToken = 'pk.eyJ1Ijoiem9ycmVlbmF0IiwiYSI6ImNrOW84Y2FteTA5b3MzbXA3cWN0eHVoemcifQ.yIvdBJcVxhwb3Yn3h5vYJQ';
	var map = new mapboxgl.Map({
		container: 'map', // Specify the container ID
		style: 'mapbox://styles/mapbox/streets-v11', // Specify which map style to use
		center: [<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>], // Specify the starting position
		zoom: 18, // Specify the starting zoom
	});

	var markercheck = new mapboxgl.Marker()
		.setLngLat([<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>])
		.addTo(map);

    markgps.onclick = function() {
		navigator.geolocation.getCurrentPosition(function (position) {
			map.setCenter([position.coords.longitude, position.coords.latitude]);
			markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
            mlong.value      = map.getCenter().lng.toFixed(6)
            mlat.value       = map.getCenter().lat.toFixed(6)
		})
	}

    markchoose.onclick = function() {
        choosecheck = !choosecheck;
        if(choosecheck) {
            markgps.className       = "d-none";
            markchoose.className    = "d-none";
            mychoose.className      = "btn-sm btn-success form-control mx-5";
            markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
        }
    }

    mychoose.onclick = function() {
        choosecheck = !choosecheck;
        markgps.className       = "btn-sm btn-success form-control";
        markchoose.className    = "ml-2 btn-sm btn-primary form-control";
        mychoose.className      = "d-none";
    }

    map.on('move', (e) => {
        if (choosecheck){
            mlong.value      = map.getCenter().lng.toFixed(6)
            mlat.value        = map.getCenter().lat.toFixed(6)
            markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)])
        }
    });
    
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
</script>

