
  <meta charset='utf-8' />
  <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
  <!-- Import Mapbox GL JS  -->
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
  <!-- Import jQuery -->
  <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->

  <style>

	.head {
        width: 300px;
        height: 300px;
    }
	
	.comment {
		width: 70px;
        height: 70px;
	}

	.imgRgoods {
        width: 100px;
        height: 100px;
    }

    #map {
	  height: 200px;
    }

	@media screen and (max-width: 480px) {
		.head {
            width: 200px;
            height: 200px;
        }
		.comment {
			width: 50px;
			height: 50px;
		}
		.imgRgoods {
			width: 50px;
			height: 50px;
		}
	}
	
  </style>

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
				<div class="row mt-3 text-center">
                    <div class="col-sm">
						<div id='map'></div>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm">
                        <?php if ($marketdetail[0]['m_img'] != ''): ?>
                            <img src="<?php echo site_url('assets/img/market/'.$marketdetail[0]['m_img']); ?>" class="img-thumbnail head">
                        <?php else: ?>
                            <img src="<?php echo site_url('assets/img/logo/store.png'); ?>" class="img-thumbnail head">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-5 col-xl-5 d-flex justify-content-end">
                      	<b>ชื่อร้าน :</b> 
                    </div>
					<div class="col">
                        <?=$marketdetail[0]['m_shopname'];?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 col-xl-5 d-flex justify-content-end">
                		<b>เจ้าของร้าน :</b> 
                    </div>
					<div class="col-7 col-xl-2">
						<?=$marketdetail[0]['m_name'],' ',$marketdetail[0]['m_lname'];?>
                    </div>
                    <div class="col-5 col-xl-1 d-flex justify-content-end">
                    	<b>ประเภท :</b>
                    </div>
					<div class="col-7 col-xl">
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
                    <div class="col-5 col-xl-5 d-flex justify-content-end">
						<b>รายละเอียด :</b>
                    </div>
					<div class="col col-xl-5">
						<?php echo $marketdetail[0]['m_shopdetail'];?>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col">
                        <h4>สินค้าแนะนำ</h4> 
                    </div>
                </div>
                <div class="row">
					<?php if (count($Rgoods) == 0) : ?>
						<div class="col mt-3 text-center d-flex justify-content-center">
							ไม่มีสินค้าแนะนำ
						</div>
					<?php else : ?>
						<?php foreach ($Rgoods as $r) :?>
							<div class="col-12 col-md-4 text-center mt-3">
								<div class="row">
									<div class="col-4 col-md-12 text-center">
										<img src="<?php echo site_url("assets/img/goods/{$r['g_img']}");?>" class="imgRgoods">
									</div>
									<div class="col-8 col-md-12 mt-md-2 text-left text-md-center">
										<span class="ml-2"><?=$r['g_name'];?> <?=$r['g_price'];?> บาท</span>
									</div>
								</div>
							</div>
						<?php endforeach?>
					<?php endif ?>
				</div>
				<div class="row pt-3">
					<div class="col text-center">
						<a href="<?php echo site_url("index/gooddetail/{$id}"); ?>" class="btn btn-sm btn-link text-primary">ดูสินค้าทั้งหมด</a>
					</div>
				</div>
				
				
                <!-- <div class="row mt-3 text-center">
                    <div class="col-sm-12">
                        <h4>ภาพแผนที่ตั้งร้าน</h4>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm-12 pl-0 pr-0">
						<div id='map'></div>
                    </div>
                </div> -->
				<!-- <div class="row mt-3 text-center">
					<div class="col-sm-12 pl-0 pr-0">
						<a href="<?php echo site_url("app/customer/sentmap?m_lat=".$marketdetail[0]['m_lat'].'&m_lng='.$marketdetail[0]['m_lng']); ?>" class="btn btn-sm btn-success">ไปยังแผนที่</a>
					</div>
                </div> -->
				<div class="row mt-3 text-center">
                    <div class="col-sm-12">
                        <h4>ความคิดเห็น</h4>
                    </div>
                </div>
				<div class="row mt-3 text-center">
					<?php if (count($report) == 0): ?>
						<div class="col">ไม่มีความคิดเห็น</div>
					<?php else: ?>
						<?php foreach ($report as $r): ?>
							<div class="col-3">
								<?php if ($r['c_img'] != ''): ?>
									<img src="<?php echo site_url('assets/img/customer/'.$r['c_img']); ?>" class="comment">
								<?php else: ?>
									<img src="<?php echo site_url('assets/img/boy.png'); ?>" class="comment">
								<?php endif; ?>
								<!-- <div class="col">
									<span class="align-middle"><?=$r['c_name']?> <?=$r['c_lname']?></span>
								</div> -->
							</div>
							<div class="col-9 text-left d-flex align-items-center"><?=$r['r_comment']?></div>
						<?php endforeach; ?>
					<?php endif; ?>
                </div>
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