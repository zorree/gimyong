	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css' rel='stylesheet' />

  <!-- <style>

    #map {
      position: relative;
      top: 0;
      bottom: 0;
	  width: 100%;
	  min-height: 100px;
    }
  </style> -->

<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">รายละเอียดร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=site_url()?>">หน้าแรก</a></li>
			<li class="breadcrumb-item"><a href="<?=site_url("admin/market")?>">ร้านค้า</a></li>
			<li class="breadcrumb-item active" aria-current="page">รายละเอียดร้านค้า</li>
		</ol>
	</div>

	<div class="col-12 pl-0 pr-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row">
				<h3 class="m-0 font-weight-bold text-primary">
                    รายละเอียดร้านค้า
				</h3>
			</div>
			<div class="card-body">
                <div class="row text-center">
                    <div class="col-sm">
                        <img src="https://images.thaiza.com/119/119_20190116100624..jpg" class="img-thumbnail" alt="" width="400" height="400">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm">
                        ชื่อร้าน : <?=$marketdetail[0]['m_shopname']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        เจ้าของร้าน : <?=$marketdetail[0]['m_name']?> <?=$marketdetail[0]['m_lname']?>
                    </div>
                    <div class="col-sm">
                        ประเภท : <?=$marketdetail[0]['m_shoptype']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        รายละเอียดร้าน : <?=$marketdetail[0]['m_shopdetail']?>
                    </div>
                </div>
                <div class="row my-3 text-center bg-danger">
                    <div class="col-sm-12">
                        <h4>สินค้าแนะนำ</h4> 
                    </div>
                </div>
                <div class="row my-3 text-center bg-danger justify-content-lg-around">
					<?php foreach($goods as $r): ?>	
                    <div class="col-sm-3 mb-2">
                        <div class="card">
                            <img src="https://amvata.com/images/detailed/107/22038_2172.jpg" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?=$r['g_name']?></h5>
                                <p class="card-text"><?=$r['g_price']?> บาท</p>
                                <!-- <a href="<?=site_url("admin/goodsdetail/{$r['g_id']}")?>" class="btn btn-sm btn-primary">ดูรายละเอียดเพิ่มเติม</a> -->
                            </div>
                        </div>
					</div>
					<?php endforeach ?>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm-12">
                        <h4>ภาพแผนที่ตั้งร้าน</h4>
                    </div>
                </div>
                <div class="row mt-3 text-center">
                    <div class="col-sm p-0">
						<div id='map'></div>
                    </div>
                </div>
				<div class="row mt-5 text-right">
					<div class="col-sm">
						<a href="<?=site_url("admin/marketedit/{$marketdetail[0]['m_id']}")?>"  class="btn btn-sm btn-success">แก้ไขข้อมูล</a>
					</div>
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
		zoom: 18, // Specify the starting zoom
	});

	var marker = new mapboxgl.Marker()
		.setLngLat([<?php echo $marketdetail[0]['m_lng'];?>, <?php echo $marketdetail[0]['m_lat'];?>])
		.addTo(map);
	
	map.on('load', function () {
		map.addSource('floorplan', {
			'type': 'geojson',
			'data':
			'<?php echo site_url('assets/map/mapg.geojson');?>'
		});
		map.addLayer({
			'id': 'room-extrusion',
			'type': 'fill',
			'source': 'floorplan',
			'paint': {
				"fill-color": "#00ffff"
			}
		});
		map.addLayer({
			'id': 'room-extrusions',
			'type': 'line',
			'source': 'floorplan',
			'paint': {
				"line-color": "#000000"
			}
		});
	});
	
</script>

<!-- <script>
	var map = L.map('map').setView([51.505, -0.09], 13);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	L.marker([51.5, -0.09]).addTo(map)
		.bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
		.openPopup();
</script> -->


<script>
	function editDeptsModal(dept_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('admin/loadDeptid'); ?>",
			data: {
				dept_id: dept_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			result = result[0]
			$('#edit_dept_id').val(result['dept_id'])
			$('#edit_dept_admin').html(result['dept_admin'])
			$('#edit_div_name').html(result['div_name'])
			$('#edit_job_id').val(result['job_id'])
			$('#edit_dept_description').val(result['dept_description'])
			$('#edit_dept_property').val(result['dept_property'])
			$('#edit_dept_time' + result['dep_time']).prop('checked', true)
			$('#edit_dept_gender' + result['dept_gender']).prop('checked', true)
			$('#edit_dept_tel').val(result['dept_tel'])
		});
		$('#editDeptsModal').modal('show')
	}
</script>

<script>
	function editRegistModal(regist_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('admin/loadRegistid'); ?>",
			data: {
				regist_id: regist_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			result = result[0]
			// console.log(result['regist_start'].substring(0, 9))
			$('#edit_regist_id').val(result['regist_id'])
			$('#edit_regist_term').val(result['regist_term'])
			$('#edit_regist_year').val(result['regist_year'])
			$('#edit_regist_start').val(result['regist_start'].substring(0, 10))
			$('#edit_regist_stop').val(result['regist_stop'].substring(0, 10))
			$('#edit_dept_start').val(result['dept_start'].substring(0, 10))
			$('#edit_dept_stop').val(result['dept_stop'].substring(0, 10))
		});
		$('#editRegistModal').modal('show')
	}
</script>

<div class="modal fade" id="editDeptsModal" tabindex="-1" role="dialog" aria-labelledby="editDeptsLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editDeptsLabel"><i class="far fa-edit"></i> แก้ไขหน่วยงาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('admin/editDept'); ?>" method="post">
				<input type="hidden" name="dept_id" id="edit_dept_id">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-borderless">
							<tr>
								<td>ผู้ควบคุม</td>
								<td><span id="edit_dept_admin"></span></td>
							</tr>
							<tr>
								<td>หน่วยงาน</td>
								<td><span id="edit_div_name"></span></td>
							</tr>
							<tr>
								<td>ประเภทงาน</td>
								<td>
									<select id="edit_job_id" name="job_id" class="form-control form-control-sm" required>
										<option value="" disabled selected>เลือกประเภทงาน</option>
										<?php foreach($job as $r){?>
											<option value="<?php echo $r['job_id'];?>"><?php echo $r['job_name'];?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>ลักษณะงาน</td>
								<td><textarea id="edit_dept_description" name="dept_description" class="form-control form-control-sm" required></textarea></td>
							</tr>
							<tr>
								<td>คุณสมบัติ</td>
								<td><textarea id="edit_dept_property" name="dept_property" class="form-control form-control-sm" required></textarea></td>
							</tr>
							<tr>
								<td>เวลาทำงาน</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="edit_dept_time0" value="0" checked>
										<label class="form-check-label" for="dept_time0"> ในเวลาราชการ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="edit_dept_time1" value="1">
										<label class="form-check-label" for="dept_time1"> นอกเวลาราชการ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="edit_dept_time2" value="2">
										<label class="form-check-label" for="dept_time2"> ในและนอกเวลาราชการ</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>เพศ</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="edit_dept_genderM" value="M" checked>
										<label class="form-check-label" for="dept_genderM"> ชาย</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="edit_dept_genderF" value="F">
										<label class="form-check-label" for="dept_genderF"> หญิง</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="edit_dept_genderB" value="B">
										<label class="form-check-label" for="dept_genderB"> ทั้งสอง</label>
									</div>
								</td>
							</tr>
							<tr>
								<td rowspan="">เบอร์โทร</td>
								<td><input id="edit_dept_tel" type="text" class="form-control form-control-sm" name="dept_tel" required></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" name="btnSubmit">บันทึก</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="editRegistModal" tabindex="-1" role="dialog" aria-labelledby="editRegistLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editRegistLabel"><i class="far fa-edit"></i> แก้ไขรอบการทำงาน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form action="<?php echo site_url('admin/editRegist'); ?>" method="post">
				<input type="hidden" name="regist_id" id="edit_regist_id">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>เทอม/ปีการศึกษา</td>
								<td>
									<select id="edit_regist_term" name="regist_term" class="form-control form-control-sm" required>
										<option value="1">เทอม 1</option>
										<option value="2">เทอม 2</option>
										<option value="3">เทอม 3</option>
									</select>
								</td>
								<td>
									<select id="edit_regist_year" name="regist_year" class="form-control form-control-sm" required>
										<?php for($i = date('Y'); $i >= 2019; $i--) { ?> 
											<option value="<?php echo $i; ?>">ปีการศึกษา <?php echo $i + 543; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td rowspan="2">วันรับสมัคร</td>
								<td>เปิด</td>
								<td><input id="edit_regist_start" type="date" class="form-control form-control-sm" name="regist_start" required></td>
							</tr>
							<tr>
								<td>ปิด</td>
								<td><input id="edit_regist_stop" type="date" class="form-control form-control-sm" name="regist_stop" required></td>
							</tr>
							<tr>
								<td rowspan="2">วันเลือกหน่วยงาน</td>
								<td>เปิด</td>
								<td><input id="edit_dept_start" type="date" class="form-control form-control-sm" name="dept_start" required></td>
							</tr>
							<tr>
								<td>ปิด</td>
								<td><input id="edit_dept_stop" type="date" class="form-control form-control-sm" name="dept_stop" required></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
					<button type="submit" class="btn btn-primary btn-sm" name="btnSubmit">แก้ไข</button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="addRegistModal" tabindex="-1" role="dialog" aria-labelledby="addRegistLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRegistLabel"><i class="fas fa-plus"></i> เพิ่มรอบการทำงาน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form action="<?php echo site_url('admin/addRegist'); ?>" method="post">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>เทอม/ปีการศึกษา</td>
								<td>
									<select name="term" class="form-control form-control-sm" required>
										<option value="1">เทอม 1</option>
										<option value="2">เทอม 2</option>
										<option value="3">เทอม 3</option>
									</select>
								</td>
								<td>
									<select name="year" class="form-control form-control-sm" required>
										<?php for($i = date('Y'); $i >= 2019; $i--) { ?> 
											<option value="<?php echo $i; ?>">ปีการศึกษา <?php echo $i + 543; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td rowspan="2">วันรับสมัคร</td>
								<td>เปิด</td>
								<td><input type="date" class="form-control form-control-sm" name="regist_start" value="<?php echo date('Y-m-d'); ?>" required></td>
							</tr>
							<tr>
								<td>ปิด</td>
								<td><input type="date" class="form-control form-control-sm" name="regist_stop" value="<?php echo date('Y-m-d'); ?>" required></td>
							</tr>
							<tr>
								<td rowspan="2">วันเลือกหน่วยงาน</td>
								<td>เปิด</td>
								<td><input type="date" class="form-control form-control-sm" name="dept_start" value="<?php echo date('Y-m-d'); ?>" required></td>
							</tr>
							<tr>
								<td>ปิด</td>
								<td><input type="date" class="form-control form-control-sm" name="dept_stop" value="<?php echo date('Y-m-d'); ?>" required></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
					<button type="submit" class="btn btn-primary btn-sm" name="btnSubmit">เพิ่ม</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="addDeptsModal" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDeptLabel"><i class="fas fa-plus"></i> เพิ่มหน่วยงานพิเศษ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('admin/addDept'); ?>" method="post">
				<input type="hidden" name="dept_status" value="3">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-borderless">
							<tr>
								<td>ผู้ควบคุม</td>
								<td><?php echo $this->session->userdata('name');?></td>
							</tr>
							<tr>
								<td>หน่วยงาน</td>
								<td><?php echo $this->session->userdata('dept_name');?></td>
							</tr>
							<tr>
								<td>ประเภทงาน</td>
								<td>
									<select name="job_id" class="form-control form-control-sm" required>
										<option value="" disabled selected>เลือกประเภทงาน</option>
										<?php foreach($job as $r){?>
											<option value="<?php echo $r['job_id'];?>"><?php echo $r['job_name'];?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>ลักษณะงาน</td>
								<td><textarea name="dept_description" class="form-control form-control-sm" required></textarea></td>
							</tr>
							<tr>
								<td>คุณสมบัติ</td>
								<td><textarea name="dept_property" class="form-control form-control-sm" required></textarea></td>
							</tr>
							<tr>
								<td>เวลาทำงาน</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="dept_time0" value="0" checked>
										<label class="form-check-label" for="dept_time0"> ในเวลาราชการ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="dept_time1" value="1">
										<label class="form-check-label" for="dept_time1"> นอกเวลาราชการ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_time" id="dept_time2" value="2">
										<label class="form-check-label" for="dept_time2"> ในและนอกเวลาราชการ</label>
									</div>
								</td>
							</tr>
							<tr>
								<td>เพศ</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="dept_genderM" value="M" checked>
										<label class="form-check-label" for="dept_genderM"> ชาย</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="dept_genderF" value="F">
										<label class="form-check-label" for="dept_genderF"> หญิง</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_gender" id="dept_genderB" value="B">
										<label class="form-check-label" for="dept_genderB"> ทั้งสอง</label>
									</div>
								</td>
							</tr>
							<tr>
								<td rowspan="">เบอร์โทร</td>
								<td><input type="text" class="form-control form-control-sm" name="dept_tel" required></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm" name="btnSubmit">บันทึก</button>
				</div>
			</form>
		</div>
	</div>
</div>

