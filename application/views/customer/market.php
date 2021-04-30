<!-- <div class="container-fluid" id="container-wrapper"> -->
<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">ร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">ร้านค้า</li>
		</ol>
	</div>

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
                    ร้านค้า
				</h6>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
                        <!-- <button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#addRegistModal"><i class="fas fa-plus"></i> เพิ่มรอบการทำงาน</button> -->
                        <div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th>#</th>
										<th>เจ้าของร้าน</th>
										<th>ชื่อร้านค้า</th>
										<th>ประเภท</th>
										<th>รายละเอียด</th>
									</tr>
								</thead>
								<tbody>
									<!-- <?php echo count($listmarket) == 0 ? '<td colspan="4">-ไม่มีข้อมูล-</td>' : ''; ?> -->
									<?php 
										$num = 0;
										foreach($listmarket as $r){ 
									?>
										<tr>
											<td><?php echo ++$num; ?></td>
											<td><?php echo $r['m_name'],' ',$r['m_lname'];?></td>
											<td><?php echo $r['m_shopname'];?></td>
											<td><?php echo $r['m_shoptype'];?></td>
											<form action="<?php echo site_url("customer/marketdetail") ?>" method="post">
												<input type="hidden" name="m_id" value="<?php echo $r['m_id'];?>">
												<td><button class="btn btn-link text-primary" type="submit">คลิกเพื่อดูรายละเอียด</button></td>
												<!-- <a href="<?php //echo site_url("admin/marketdetail/{$r['m_id']}") ?>" class="btn btn-link text-primary"><?php echo 'คลิกเพื่อดูรายละเอียด' ?></a></td> -->
											</form>
										</tr>
									<?php 
										} 
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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

