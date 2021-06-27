<meta charset='utf-8' />
  <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
  <!-- Import Mapbox GL JS  -->
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />
  <!-- Import jQuery -->
  <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script> -->

  <style>

	.top {
		top: 10%
	}

    #map {
	  height: 200px;
    }

	/* .imgcard {
        width: 100%;
        height: 200px;
    } */

	.imgcard {
        width: 50px;
        height: 50px;
    }

	.comment {
		width: 50px;
		height: 50px;
	}

	.head {
        width: 100%;
        height: 100%;
    }

	.addgoods {
        width: 100%;
        height: 100px;
    }

	@media screen and (max-width: 480px) {
		#map {
			height: 100px;
		}

		.head {
            width: 50%;
            height: 150px;
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
				<div class="row">
					<div class="col-12">
						<div class="bg-danger" id='map'></div>
						<!-- <div id='map'></div> -->
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-12 col-lg-3 text-center d-flex align-items-center">
						<div class="row">
							<div class="col-12">
								<?php if ($marketdetail[0]['m_img'] != ''): ?>
									<img src="<?php echo site_url('assets/img/market/'.$marketdetail[0]['m_img']); ?>" class="img-thumbnail head">
								<?php else: ?>
									<img src="<?php echo site_url('assets/img/logo/store.png'); ?>" class="img-thumbnail head">
								<?php endif; ?>
							</div>
							
						</div>
					</div>
					<div class="col-12 col-lg-9">
						<div class="row mt-3">
							<div class="col-5 col-xl-2 d-flex justify-content-end">
								<b>ชื่อร้าน :</b> 
							</div>
							<div class="col-7">
								<?=$marketdetail[0]['m_shopname'];?>
							</div>
						</div>
						<div class="row">
							<div class="col-5 col-xl-2 d-flex justify-content-end">
								<b>เจ้าของร้าน :</b> 
							</div>
							<div class="col-7 col-xl-2">
								<?=$marketdetail[0]['m_name'],' ',$marketdetail[0]['m_lname'];?>
							</div>
							<div class="col-5 col-xl-2 d-flex justify-content-end">
								<b>ประเภท :</b>
							</div>
							<div class="col-7 col-xl-6">
								<?php 
									if ($marketdetail[0]['m_shoptype'] == 1) {
										echo 'เสื้อผ้า';
									} else if ($marketdetail[0]['m_shoptype'] == 2) {
										echo 'อาหาร';
									} else if ($marketdetail[0]['m_shoptype'] == 3) {
										echo 'ของฝาก';
									} else if ($marketdetail[0]['m_shoptype'] == 4) {
										echo 'เครื่องใช้ไฟฟ้า';
									} else {
										echo 'ผลไม้';
									}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-5 col-xl-2 d-flex justify-content-end">
								<b>รายละเอียด :</b>
							</div>
							<div class="col-7">
								<?php echo $marketdetail[0]['m_shopdetail'];?>
							</div>
						</div>
						<div class="row mt-3 text-center">
							<div class="col-sm">
								<a href="<?=site_url("admin/marketedit/{$marketdetail[0]['m_id']}")?>" class="btn btn-sm btn-success">แก้ไขข้อมูล</a>
								<!-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editprofileModal">แก้ไขข้อมูล</button> -->
								<!-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editprofileModal">แก้ไขข้อมูล</button> -->
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3 text-center">
                    <div class="col-sm-12">
                        <h4>สินค้าแนะนำ</h4> 
                    </div>
                </div>
				<div class="card-header d-flex justify-content-center justify-content-lg-start">
					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addgoodsModal"><i class="fas fa-plus"></i> เพิ่มสินค้าแนะนำ</button>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
                        <div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th width="3%">#</th>
										<th>ภาพ</th>
										<th>ชื่อสินค้า</th>
										<th>ราคา</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php $num = 0?>
									<?=$goods == null ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : '' ?>
									<?php foreach($goods as $r): ?>
										<tr>
											<td class="align-middle"><?=++$num?></td>
											<td class="align-middle">
												<img src="<?=site_url("assets/img/goods/")?><?=$r['g_img']?>" class="imgcard" alt="">
											</td>
											<td class="align-middle"><?=$r['g_name']?></td>
											<td class="align-middle"><?=$r['g_price']?></td>
											<td class="align-middle">
												<div class='d-flex justify-content-center'>
													<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(<?=$r['g_id']?>)">แก้ไข</button>
													<form action="<?php echo site_url('admin/deletegoods');?>" method="post">
														<input type="hidden" name="m_id" value="<?=$marketdetail[0]['m_id']?>">
														<input type="hidden" name="g_img" value="<?=$r['g_img']?>">
														<button type="submit" name="submit" value="<?=$r['g_id']?>" class="btn btn-sm btn-danger ml-2" onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">ลบ</button>
													</form>
												</div>
											</td>

										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> แก้ไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				<form action="<?php echo site_url('admin/marketeditaction'); ?>" method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="m_id" value="<?=$marketdetail[0]['m_id']?>">
					<div class="modal-body">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-6">
								<?php if ($marketdetail[0]['m_img'] != ''): ?>
									<img id="previewProfile" src="<?php echo site_url('assets/img/market/'.$marketdetail[0]['m_img']); ?>" class="addgoods mb-3">
								<?php else: ?>
									<img id="previewProfile" src="<?php echo site_url('assets/img/logo/store.png'); ?>" class="addgoods mb-3">
								<?php endif; ?>
								<!-- <img class="addgoods mb-3" id="previewImgedit" src="" alt="Placeholder"> -->
							</div>
						</div>
						<div class="row">
							<div class="col-3 text-right">รูปภาพ</div>
							<div class="col-6">
								<input type="file" name="m_img" id="m_img" onchange="marketpreviewProfile(this);">
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-3 text-right">ชื่อร้าน</div>
							<div class="col-6">
								<input class="form-control form-control-sm" id="m_shopname"	name="m_shopname" 	value="<?=$marketdetail[0]['m_shopname']?>"  type="text" required>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-3 text-right">ชื่อเจ้าของ</div>
							<div class="col-6">
								<input class="form-control form-control-sm" id="m_name"		name="m_name" 		value="<?=$marketdetail[0]['m_name']?>"	type="text" required>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-3 text-right">นามสกุล</div>
							<div class="col-6">
								<input class="form-control form-control-sm" id="m_lname"	name="m_lname" 		value="<?=$marketdetail[0]['m_lname']?>"	type="text" required>
							</div>
						</div><div class="row mt-3">
							<div class="col-3 text-right">ประเภท</div>
							<div class="col-6">
								<select class="form-control form-control-sm" name="m_shoptype">
									<option selected disabled>เลือกประเภทร้าน</option>
									<option value="1" <?php if ($marketdetail[0]['m_shoptype'] == 1):?><?='selected'?><?php endif; ?>>เสื้อผ้า</option>
									<option value="2" <?php if ($marketdetail[0]['m_shoptype'] == 2):?><?='selected'?><?php endif; ?>>อาหาร</option>
									<option value="3" <?php if ($marketdetail[0]['m_shoptype'] == 3):?><?='selected'?><?php endif; ?>>ของฝาก</option>
									<option value="4" <?php if ($marketdetail[0]['m_shoptype'] == 4):?><?='selected'?><?php endif; ?>>เครื่องใช้ไฟฟ้า</option>
									<option value="5" <?php if ($marketdetail[0]['m_shoptype'] == 5):?><?='selected'?><?php endif; ?>>ผลไม้</option>
								</select>
								<!-- <input class="form-control form-control-sm" id="mtype"		name="mtype" 		value="<?=$marketdetail[0]['m_shoptype']?>"	type="text" required> -->
							</div>
						</div>
						<div class="row my-3">
							<div class="col-3 text-right">รายละเอียด</div>
							<div class="col-6">
                            	<textarea class="form-control" name="m_shopdetail"><?php echo $marketdetail[0]['m_shopdetail'];?></textarea>
								<!-- <input class="form-control form-control-sm" id="mdetial"	name="mdetial"		value="<?=$marketdetail[0]['m_shopdetail']?>"	type="text" required> -->
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload Image">แก้ไข</button>
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
						</div>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>

<div class="modal fade" id="addgoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog top" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addgoodsLabel"><i class="fas fa-plus"></i> เพิ่มสินค้าแนะนำ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('admin/addgoods'); ?>" method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="m_id" value="<?=$marketdetail[0]['m_id']?>" required>
					<div class="modal-body">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-6">
								<img class="d-none" id="goodspreviewImg" src="" alt="Placeholder">
							</div>
						</div>
						<div class="row">
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
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editgoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editgoodLabel"><i class="fas fa-plus"></i> แก้ไขสินค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				<form action="<?php echo site_url('admin/editgoods'); ?>" method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="m_id" value="<?=$marketdetail[0]['m_id']?>" required>
					<input type="hidden" id="g_id" name="g_id" required>
					<div class="modal-body">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-6">
								<img class="addgoods mb-3" id="previewImgedit" src="" alt="Placeholder">
							</div>
						</div>
						<div class="row">
							<div class="col-3 text-right">รูปภาพ</div>
							<div class="col-6">
								<input type="file" name="picture1" id="fileToUpload1" onchange="previewFileedit(this);">
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-3 text-right">ชื่อสินค้า</div>
							<div class="col-6">
								<input class="form-control form-control-sm" id="g_name" name="g_name"  type="text" required>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-3 text-right">ราคา</div>
							<div class="col">
								<input class="form-control form-control-sm" id="g_price" name="g_price"  type="number" required>
							</div>
							<div class="col-3">บาท</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload Image">แก้ไข</button>
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
						</div>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>


<!-- Create a container for the map -->

<script>

	function marketpreviewProfile(input){
        var file= input.files[0];
		console.log(file)
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $("#previewProfile").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }

	function goodspreviewFile(input){
        var file= input.files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $("#goodspreviewImg").attr("src", reader.result);
                $("#goodspreviewImg").removeClass("d-none");
                $("#goodspreviewImg").addClass("addgoods mb-3");
            }
            reader.readAsDataURL(file);
        }
    }

	function previewFileedit(input){
        var file= input.files[0];
        var reader  = new FileReader();
        reader.addEventListener("load", function () {
            $("#previewImgedit").attr("src", reader.result);
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function showData(num) {
        // console.log(num)
        var url = '<?php echo site_url('admin/showgoods/'); ?>' + num;
		var req = new XMLHttpRequest();
		req.open('GET', url, true);
		req.onload = function() {
			var json = JSON.parse(req.response);
            // console.log(json)
            document.getElementById("previewImgedit").src   = "<?php echo site_url('assets/img/goods/');?>" + json[0]['g_img'];
            document.getElementById("g_name").value      = json[0]['g_name'];
            document.getElementById("g_price").value     = json[0]['g_price'];
            document.getElementById("g_id").value           = num;
		};
		req.send();
    }

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

