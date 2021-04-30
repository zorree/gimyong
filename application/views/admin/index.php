<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">รอบการทำงาน</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">รอบการทำงาน</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="regist-tab" data-toggle="tab" href="#regist" role="tab" aria-controls="regist" aria-selected="true">รอบการทำงาน</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="deptS-tab" data-toggle="tab" href="#deptS" role="tab" aria-controls="deptS" aria-selected="false">หน่วยงานพิเศษ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="studentS-tab" data-toggle="tab" href="#studentS" role="tab" aria-controls="studentS" aria-selected="false">นักศึกษาพิเศษ</a>
						</li>
					</ul>
				</h6>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
						<button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#addRegistModal"><i class="fas fa-plus"></i> เพิ่มรอบการทำงาน</button>
						<div class="table-responsive">
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th rowspan="2" width="1">รอบการทำงาน</th>
										<th rowspan="2" width="1">วันรับสมัคร</th>
										<th>หน่วยงาน</th>
										<th rowspan="2" width="1">วันเลือกหน่วยงาน</th>
										<th>นักศึกษา</th>
										<th rowspan="2" width="1"></th>
									</tr>
									<tr>
										<th>
											<div class="progress">
												<div style="width: 33%">รออนุมัติ</div>
												<div class="progress-bar bg-success" style="width: 33%">อนุมัติแล้ว</div>
												<div class="progress-bar bg-danger" style="width: 34%">ไม่อนุมัติ</div>
											</div>
										</th>
										<th>
											<div class="progress">
												<div style="width: 33%">รออนุมัติ</div>
												<!-- <div class="progress-bar bg-warning" style="width: 25%">เลือกหน่วยงานแล้ว</div> -->
												<div class="progress-bar bg-success" style="width: 33%">เข้าทำงาน</div>
												<div class="progress-bar bg-danger" style="width: 34%">ไม่อนุมัติ</div>
											</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php echo count($listRegist) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
									<?php foreach($listRegist as $r) { ?>
										<tr>
											<td><?php echo $r['regist_term'].'/'.($r['regist_year'] + 543); ?></td>
											<td class="<?php echo openDate(strtotime($r['regist_start']), strtotime($r['regist_stop'])); ?>">
												<?php echo displayDate(strtotime($r['regist_start']), strtotime($r['regist_stop'])); ?>
											</td>
											<td>
												<a href="<?php echo site_url('admin/dept/'.$r['regist_id']); ?>" class="progress" title="ดูรายชื่อหน่วยงาน">
													<?php $sumD = $r['totalD0'] + $r['totalD1'] + $r['totalD2'];
													if($sumD > 0) {
														$d0 = (int)(($r['totalD0'] / $sumD) * 100);
														$d1 = (int)(($r['totalD1'] / $sumD) * 100);
														$d2 = (int)(($r['totalD2'] / $sumD) * 100); ?>
															<div style="width: <?php echo "{$d1}%"; ?>"><?php echo $r['totalD1']; ?></div>
															<div class="progress-bar bg-success" style="width: <?php echo "{$d2}%"; ?>"><?php echo $r['totalD2']; ?></div>
															<div class="progress-bar bg-danger" style="width: <?php echo "{$d0}%"; ?>"><?php echo $r['totalD0']; ?></div>
													<?php } else { ?>
														<div class="progress-bar bg-secondary" style="width:100%">0</div>
													<?php } ?>
												</a>
											</td>
											<td class="<?php echo openDate(strtotime($r['dept_start']), strtotime($r['dept_stop'])); ?>">
												<?php echo displayDate(strtotime($r['dept_start']), strtotime($r['dept_stop'])); ?>
											</td>
											<td>
												<a href="<?php echo site_url('admin/student/'.$r['regist_id']); ?>" class="progress" title="ดูรายชื่อนักศึกษา">
													<?php //$sumS = $r['totalS0'] + $r['totalS1'] + $r['totalS2'] + $r['totalS3'];
													$sumS = $r['totalS0'] + $r['totalS1'] + $r['totalS3'];
													if($sumS > 0) {
														$s0 = (int)(($r['totalS0'] / $sumS) * 100);
														$s1 = (int)(($r['totalS1'] / $sumS) * 100);
														// $s2 = (int)(($r['totalS2'] / $sumS) * 100);
														$s3 = (int)(($r['totalS3'] / $sumS) * 100); ?>
														<div style="width: <?php echo "{$s1}%"; ?>"><?php echo $r['totalS1']; ?></div>
														<!-- <div class="progress-bar bg-warning" style="width: <?php //echo $s2; ?>%"><?php //echo $r['totalS2']; ?></div> -->
														<div class="progress-bar bg-success" style="width: <?php echo "{$s3}%"; ?>"><?php echo $r['totalS3']; ?></div>
														<div class="progress-bar bg-danger" style="width: <?php echo "{$s0}%"; ?>"><?php echo $r['totalS0']; ?></div>
													<?php } else { ?>
														<div class="progress-bar bg-secondary" style="width:100%">0</div>
													<?php } ?>
												</a>
											</td>
											<td>
												<button class="btn btn-warning btn-sm" onclick="editRegistModal('<?php echo $r['regist_id']; ?>');"><i class="far fa-edit"></i></button>
												<a href="<?php echo site_url("admin/deleteRegist/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบรอบการทำงานนี้หรือไม่?');" title="ลบรอบการทำงาน"><i class="far fa-trash-alt"></i>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="deptS" role="tabpanel" aria-labelledby="deptS-tab">
						<button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#addDeptsModal"><i class="fas fa-plus"></i> เพิ่มหน่วยงานพิเศษ</button>
						<div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th>จำนวนนักศึกษา</th>
										<th>ผู้ควบคุม</th>
										<th>หน่วยงาน</th>
										<th>ประเภทงาน</th>
										<th>ลักษณะงาน</th>
										<th>คุณสมบัติ</th>
										<th>เวลาทำงาน</th>
										<th>เพศ</th>
										<th>เบอร์โทร</th>
										<th></th>
									</tr>
								</thead>
								<tbody><?php //print_r($listDeptS); ?> 
									<?php echo count($listDeptS) == 0 ? '<td colspan="10">-ไม่มีข้อมูล-</td>' : ''; ?>
									<?php foreach($listDeptS as $r){ ?>
										<tr>
											<td>
												<a href="<?php echo site_url('admin/students/'.$r['dept_id']); ?>" class="btn btn-link text-primary"><u><?php echo $r['total'] > 0 ? $r['total'].' คน' : '-ไม่มีนักศึกษา-'; ?></u></a>
											</td>
											<td><?php echo $r['name']; ?></td>
											<td><?php echo $r['div_name'];?></th>
											<td><?php echo $r['job_name']; ?></td>
											<td><?php echo $r['dept_description']; ?></th>
											<td><?php echo $r['dept_property']; ?></td>
											<td><?php echo $r['dept_time'] == 0 ? 'ในเวลาราชการ' : ($r['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ'); ?></td>
											<td><?php echo $r['dept_gender'] == 'M' ? 'ชาย' : ($r['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง'); ?></td>
											<td><?php echo $r['dept_tel']; ?></td>
											<td>
												<button class="btn btn-warning btn-sm" onclick="editDeptsModal('<?php echo $r['dept_id']; ?>');"><i class="far fa-edit"></i></button>
												<a href="<?php echo site_url("admin/deleteDept/{$r['dept_id']}/{$r['dept_admin']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบหน่วยงานนี้หรือไม่?');" title="ลบหน่วยงาน"><i class="far fa-trash-alt"></i></a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="studentS" role="tabpanel" aria-labelledby="studentS-tab">
						<div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th></th>
										<th>รหัส</th>
										<th>ชื่อ</th>
										<th>คณะ</th>
										<th>หน่วยงาน</th>
									</tr>
								</thead>
								<tbody>
									<?php echo count($listStudentS) == 0 ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : ''; ?>
									<?php $num = 0;
									foreach($listStudentS as $r){ ?>
										<tr>
											<td><?php echo ++$num; ?></td>
											<td><a href="<?php echo site_url("admin/working/{$r['dept_id']}/{$r['student_id']}") ?>" class="btn btn-link text-primary"><?php echo $r['student_id']; ?></a></td>
											<td><?php echo $r['name']; ?></td>
											<td><?php echo $r['sdiv_name']; ?></td>
											<td><?php echo $r['ddiv_name']; ?></td>
										</tr>
									<?php } ?>
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






<?php function displayDate($start, $stop) {
	$m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
	$d1 = date('j', $start);
	$m1 = $m[date('n', $start) - 1];
	$y1 = (date('y', $start) + 43);

	$d2 = date('j', $stop);
	$m2 = $m[date('n', $stop) - 1];
	$y2 = (date('y', $stop) + 43);

	if($y1 != $y2) {
		return "{$d1} {$m1} {$y1} - {$d2} {$m2} {$y2}";
	} else {
		if($m1 != $m2) {
			return "{$d1} {$m1} - {$d2} {$m2} {$y2}";
		} else {
			if($d1 != $d2) {
				return "{$d1} - {$d2} {$m2} {$y2}";
			} else {
				return "ภายในวันที่ {$d2} {$m2} {$y2}";
			}
		}
	}
}
function openDate($start, $stop) {
	$stop = strtotime('+1 day', $stop);
	$now = time();
	return $now >= $start && $now < $stop  ? 'bg-success text-white' : ($now < $start ? 'text-warning' : 'text-fade');
}