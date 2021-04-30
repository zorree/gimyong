<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">หน่วยงาน</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">หน่วยงาน</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addDeptsModal"><i class="fas fa-plus"></i> เพิ่มหน่วยงาน</button>
				</h6>
				
			</div>
			<!-- <?php //print_r($listDept); ?> -->
			<div class="card-body">
				<div class="table-responsive">	
					<table class="table table-nowrap table table-bordered text-center ">
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
						<tbody>
							<?php echo count($listDept) == 0 ? '<td colspan="10">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php foreach($listDept as $r){ ?>
								<tr>
									<td>
										<a href="<?php echo site_url('dept/students/'.$r['dept_id']); ?>" class="btn btn-link text-primary"><u><?php echo $r['total'] > 0 ? "{$r['total']} คน" : '-ไม่มีนักศึกษา-'; ?></u></a>
									</td>
									<td><?php echo $r['name']; ?></td>
									<td><?php echo $r['div_name'];?></td>
									<td><?php echo $r['job_name']; ?></td>
									<td><?php echo $r['dept_description']; ?></td>
									<td><?php echo $r['dept_property']; ?></td>
									<td><?php echo $r['dept_time'] == 0 ? 'ในเวลาราชการ' : ($r['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ'); ?></td>
									<td><?php echo $r['dept_gender'] == 'M' ? 'ชาย' : ($r['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง'); ?></td>
									<td><?php echo $r['dept_tel']; ?></td>
									<td>
										<button class="btn btn-warning btn-sm" onclick="editDeptsModal('<?php echo $r['dept_id']; ?>');"><i class="far fa-edit"></i></button>
										<a href="<?php echo site_url("dept/deleteDept/{$r['dept_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบหน่วยงานนี้หรือไม่?');" title="ลบหน่วยงาน"><i class="far fa-trash-alt"></i></a>
									</td>
									
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
	function editDeptsModal(dept_id) {
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
			$('#edit_dept_gender' + result['dept_gender']).prop('checked', true)
			$('#edit_dept_tel').val(result['dept_tel'])
		});
		$('#editDeptsModal').modal('show')
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

<div class="modal fade" id="addDeptsModal" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDeptLabel"><i class="fas fa-plus"></i> เพิ่มหน่วยงาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('dept/addDept'); ?>" method="post">
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

