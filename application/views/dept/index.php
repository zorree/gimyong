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
			<div class="card-body">
			<div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>สถานะ</th>
								<th>นักศึกษา</th>
								<th>รอบการทำงาน</th>
								<th>วันรับสมัคร</th>
								<th>ผู้ควบคุม</th>
								<th>หน่วยงาน</th>
								<th>ประเภทงาน</th>
								<th>ลักษณะงาน</th>
								<th>คุณสมบัติ</th>
								<th>เวลาทำงาน</th>
								<th>เฉพาะคณะตัวเอง</th>
								<th>เพศ</th>
								<th>เบอร์โทร</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($listRegist) == 0 ? '<td colspan="13">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php foreach($listRegist as $r) { ?>
								<tr>
									<td>
										<?php $now = time();
										if($r['dept_id'] == null){
											$start = strtotime($r['regist_start']);
											$stop = strtotime('+1 day', strtotime($r['regist_stop']));
											if($now >= $start && $now < $stop) { ?>
												<button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addDeptModal" onclick="$('#addDeptRegistid').val('<?php echo $r['regist_id']; ?>');">แจ้งความจำนง</button>
											<?php } else { ?>
												<span class="text-fade">ปิดระบบ</span>
											<?php }
										} else {
											if($r['dept_status'] == 0) { ?>
												<span class="text-danger">ระบบไม่อนุมัติ</span>
											<?php } else if($r['dept_status'] == 1) { ?>
												<span class="text-warning">รอระบบอนุมัติ</span>
											<?php } else {
												if($r['student_id'] == null) {
													$stop = strtotime('+1 day', strtotime($r['dept_stop']));
													if($now < $stop) { ?>
														<span class="text-info">รอนักศึกษาเลือกหน่วยงาน</span>
													<?php } else { ?>
														<span class="text-danger">ไม่มีนักศึกษาเลือกหน่วยงานนี้</span>
													<?php }
												} else {
													if($r['student_status'] == 2) { ?>
														<span class="text-primary">รอระบบอนุมัตินักศึกษาเข้าทำงาน</span>
													<?php } else if($r['student_status'] == 3) { ?>
														<span class="text-success">อนุมัตินักศึกษาเข้าทำงานแล้ว</span>
													<?php } else { ?>
														<span class="text-danger">นักศึกษาไม่ผ่านการอนุมัติเข้าทำงาน</span>
													<?php }
												}
											}
										} ?>
									</td>
									<td>
										<?php if($r['student_id'] != null){?>
											<a href="<?php echo site_url("dept/working/{$r['dept_id']}/{$r['student_id']}") ?>" class="btn btn-link text-primary"><?php echo $r['student_id']; ?></a>
										<?php }else{
											echo '-';	
										}?>
											
									</td>
									<td><?php echo $r['regist_term'].'/'.($r['regist_year'] + 543); ?></td>
									<td class="<?php echo openDate(strtotime($r['regist_start']), strtotime($r['regist_stop'])); ?>">
										<?php echo displayDate(strtotime($r['regist_start']), strtotime($r['regist_stop'])); ?>
									</td>
									<?php if($r['dept_id'] == null) { ?>
										<td colspan="9">ไม่มีข้อมูล</td>
									<?php } else { ?>
										<td><?php echo $r['name']; ?></td>
										<td><?php echo $r['div_name'];?></th>
										<td><?php echo $r['job_name']; ?></td>
										<td><?php echo $r['dept_description']; ?></th>
										<td><?php echo $r['dept_property']; ?></td>
										<td><?php echo $r['dept_time'] == 0 ? 'ในเวลาราชการ' : ($r['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ'); ?></td>
										<td><?php echo $r['dept_fac'] == '0' ? '-' : '<i class="fas fa-check-circle"></i>'; ?></td>
										<td><?php echo $r['dept_gender'] == 'M' ? 'ชาย' : ($r['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง'); ?></td>
										<td><?php echo $r['dept_tel']; ?></td>
										<td>
											<button class="btn btn-warning btn-sm" onclick="editDeptModal('<?php echo $r['dept_id']; ?>');"><i class="far fa-edit"></i></button>
											<a href="<?php echo site_url("dept/deleteDept/{$r['dept_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบหน่วยงานนี้หรือไม่?');" title="ลบหน่วยงาน"><i class="far fa-trash-alt"></i>
										</td>
									<?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function editDeptModal(dept_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('dept/loadDeptid'); ?>",
			data: {
				dept_id: dept_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			result = result[0]
			$('#edit_dept_id').val(result['dept_id'])
			$('#edit_job_id').val(result['job_id'])
			$('#edit_dept_description').val(result['dept_description'])
			$('#edit_dept_property').val(result['dept_property'])
			$('#edit_dept_time' + result['dep_time']).prop('checked', true)
			$('#edit_dept_fac' + result['dept_fac']).prop('checked', true)
			$('#edit_dept_gender' + result['dept_gender']).prop('checked', true)
			$('#edit_dept_tel').val(result['dept_tel'])
		});
		$('#editDeptModal').modal('show')
	}
</script>

<div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog" aria-labelledby="editDeptLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editDeptLabel"><i class="far fa-edit"></i> แก้ไขหน่วยงาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('dept/editDept'); ?>" method="post">
				<input type="hidden" name="dept_id" id="edit_dept_id">
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
								<td>จำกัดคณะ</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_fac" id="edit_dept_fac0" value="0" checked>
										<label class="form-check-label" for="edit_dept_fac0"> ไม่จำกัดคณะ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_fac" id="edit_dept_fac1" value="1">
										<label class="form-check-label" for="edit_dept_fac1"> เฉพาะคณะของหน่วยงานนี้เท่านั้น</label>
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

<div class="modal fade" id="addDeptModal" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDeptLabel"><i class="fas fa-plus"></i> เพิ่มหน่วยงาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('dept/addDept'); ?>" method="post">
				<input type="hidden" id="addDeptRegistid" name="regist_id">
				<input type="hidden" name="dept_status" value="1">
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
								<td>จำกัดคณะ</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_fac" id="dept_fac0" value="0" checked>
										<label class="form-check-label" for="dept_fac0"> ไม่จำกัดคณะ</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="dept_fac" id="dept_fac1" value="1">
										<label class="form-check-label" for="dept_fac1"> เฉพาะคณะของหน่วยงานนี้เท่านั้น</label>
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
} ?>

