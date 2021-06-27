
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

	.comment {
		width: 50px;
		height: 50px;
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

<!-- <div class="container-fluid" id="container-wrapper"> -->
<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">รายละเอียดร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item">ร้านค้า</a></li>
		</ol>
	</div>

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h3 class="m-0 font-weight-bold text-primary">
                    รายละเอียดร้านค้า
				</h3>
			</div>
			<div class="card-body">
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
                    <div class="col-4 col-xl-2 d-flex justify-content-end">
                      	<b>ชื่อร้าน :</b> 
                    </div>
					<div class="col">
                        <?=$marketdetail[0]['m_shopname'];?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 col-xl-2 d-flex justify-content-end">
                		<b>เจ้าของร้าน :</b> 
                    </div>
					<div class="col-8 col-xl-2">
						<?=$marketdetail[0]['m_name'],' ',$marketdetail[0]['m_lname'];?>
                    </div>
                    <div class="col-4 col-xl-2 d-flex justify-content-end">
                    	<b>ประเภท :</b>
                    </div>
					<div class="col-8 col-xl-6">
                        <?php 
							if ($marketdetail[0]['m_shoptype'] == 1) {
								echo 'เสื้อผ้า';
							} else if ($marketdetail[0]['m_shoptype'] == 2) {
								echo 'อาหาร';
							} else if ($marketdetail[0]['m_shoptype'] == 2) {
								echo 'ของฝาก';
							} else if ($marketdetail[0]['m_shoptype'] == 2) {
								echo 'เครื่องใช้ไฟฟ้า';
							} else {
								echo 'ผลไม้';
							}
						?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 col-xl-2 d-flex justify-content-end">
						<b>รายละเอียด :</b>
                    </div>
					<div class="col-8">
						<?php echo $marketdetail[0]['m_shopdetail'];?>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm-12">
                        <h4>แผนที่ตั้งร้าน</h4>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm">
						<div id='map'></div>
                        <!-- <img src="https://static.posttoday.com/media/content/2018/02/21/6A4F3A5B48E94BB7A216F55CA98AF3F3.jpg" class="img-thumbnail" alt="" width="400" height="400"> -->
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm">
                        <a href="<?php echo site_url("market/marketedit"); ?>"  class="btn btn-sm btn-success">แก้ไขข้อมูล</a>
                        <!-- <a class="btn btn-sm btn-success">แก้ไข</a> -->
                    </div>
                </div>
				<!-- <div class="row mt-3">
                    <div class="col-sm text-center">
						<h4>ความคิดเห็น</h4>
                    </div>
                </div>
				<div class="row mt-3 align-items-center">
                    <div class="col-2 text-center">
						<img src="https://images.thaiza.com/119/119_20190116100624..jpg" class="rounded-circle comment">
                    </div>
					<div class="col-10">
						คะแนน
						<br>
						คอมเมนต์
                    </div>
                </div> -->
			</div>
		</div>
	</div>
</div>

<!-- Create a container for the map -->

<script>
	// Add your Mapbox access token
	mapboxgl.accessToken = 'pk.eyJ1Ijoiem9ycmVlbmF0IiwiYSI6ImNrOW84Y2FteTA5b3MzbXA3cWN0eHVoemcifQ.yIvdBJcVxhwb3Yn3h5vYJQ';
	var map = new mapboxgl.Map({
		container: 'map', // Specify the container ID
		style: 'mapbox://styles/mapbox/streets-v11', // Specify which map style to use
		center: [<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>], // Specify the starting position
		zoom: 15, // Specify the starting zoom
	});

	var marker = new mapboxgl.Marker()
		.setLngLat([<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>])
		.addTo(map);
</script>
