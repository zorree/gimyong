
  <meta charset='utf-8' />
  <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
  <!-- Import Mapbox GL JS  -->
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
  <!-- Import jQuery -->
  <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->

  <style>

    #map {
      /* position: absolute; */
      /* top: 0;
      bottom: 0; */
	  /* width: 50px; */
	  height: 400px;
    }
  </style>

<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">รายละเอียดร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item"><a href="<?php echo site_url("admin/market"); ?>">ร้านค้า</a></li>
			<li class="breadcrumb-item active" aria-current="page">รายละเอียดร้านค้า</li>
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
				<form action="<?php echo site_url("admin/marketeditaction");?>" method="post">
                    <div class="row text-center">
                        <div class="col-sm">
                            <img src="https://images.thaiza.com/119/119_20190116100624..jpg" class="img-thumbnail" alt="" width="400" height="400">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-2 text-right">
                            <!-- ชื่อร้าน : <?php echo $marketdetail[0]['m_shopname'];?> -->
                            ชื่อร้าน :
                        </div>
                        <div class="col-sm">
                            <input class="form-control form-control-sm" type="text" name="m_shopname" value="<?php echo $marketdetail[0]['m_shopname'];?>">
                            <!-- ชื่อร้าน : <?php echo $marketdetail[0]['m_shopname'];?> -->
                            <!-- ชื่อร้าน : <input type="text" name="m_shopname" value="<?php echo $marketdetail[0]['m_shopname'];?>"> -->
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <!-- เจ้าของร้าน : <?php echo $marketdetail[0]['m_name'];?> <?php echo $marketdetail[0]['m_lname'];?> -->
                            เจ้าของร้าน :
                        </div>
                        <div class="col-sm">
                            <input class="form-control form-control-sm" type="text" name="m_name" value="<?php echo $marketdetail[0]['m_name'];?>">
                        
                            <!-- <input type="text" name="m_shopname" value="<?php echo $marketdetail[0]['m_shopname'];?>"> -->
                            <!-- ชื่อร้าน : <?php echo $marketdetail[0]['m_shopname'];?> -->
                            <!-- ชื่อร้าน : <input type="text" name="m_shopname" value="<?php echo $marketdetail[0]['m_shopname'];?>"> -->
                        </div>
                        <div class="col-sm">
                            <input class="form-control form-control-sm" type="text" name="m_lname" value="<?php echo $marketdetail[0]['m_lname'];?>">
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <!-- ประเภท : <?php echo $marketdetail[0]['m_shoptype'];?> -->
                            ประเภท :
                        </div>
                        <div class="col-sm">
                            <!-- ประเภท : <?php echo $marketdetail[0]['m_shoptype'];?> -->
                            <input class="form-control form-control-sm" type="text" name="m_shoptype" value="<?php echo $marketdetail[0]['m_shoptype'];?>">
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 text-right">
                            <!-- รายละเอียดร้าน : <?php echo $marketdetail[0]['m_shopdetail'];?> -->
                            รายละเอียดร้าน :
                        </div>
                        <div class="col-sm">
                            <!-- ประเภท : <?php echo $marketdetail[0]['m_shoptype'];?> -->
                            <textarea class="form-control" name="m_shopdetail"><?php echo $marketdetail[0]['m_shopdetail'];?></textarea>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-sm-12">
                            <h4>ภาพแผนที่ตั้งร้าน</h4>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-sm ml-5 mr-5">
                            <div id='map'></div>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                        <div class="col-sm">ละติจูด</div>
                        <div class="col-sm-5"><input class="form-control form-control-sm" type="text" name="m_lat" value="<?php echo $marketdetail[0]['m_lat'];?>"></div>
                        <div class="col-sm">ลองติจูด</div>
                        <div class="col-sm-5"><input class="form-control form-control-sm" type="text" name="m_lng" value="<?php echo $marketdetail[0]['m_lng'];?>"></div>
                    </div>
					<div class="row text-center">
						<div class="col-sm mt-3">
                            <input type="hidden" name="m_id" value="<?php echo $marketdetail[0]['m_id'];?>">
							<button class="btn form-control btn-sm btn-success" type="submit" name="submit" value="submit">ยืนยัน</button>
                        </div>
						<div class="col-sm mt-3">
                            <a class="btn form-control btn-sm btn-light">ยกเลิก</a>
                        </div>
                    </div>
                </form>
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
		zoom: 18, // Specify the starting zoom
	});

	var marker = new mapboxgl.Marker()
		.setLngLat([<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>])
		.addTo(map);
</script>

