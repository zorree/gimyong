<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo "นักศึกษา รอบ {$regist[0]['regist_term']}/".($regist[0]['regist_year'] + 543); ?></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active"><a href="<?php echo site_url('admin'); ?>">รอบการทำงาน</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo "นักศึกษา รอบ {$regist[0]['regist_term']}/".($regist[0]['regist_year'] + 543); ?></li>
		</ol>
	</div>
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				
				<button class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="#addDeptsModal">นำออกใบส่งตัว</button>
				<div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center table-sm">
						<thead>
							<tr>
								<th></th>
								<th>การอนุมัติ/หน่วยงาน</th>
								<th>รหัส</th>
								<th>ชื่อ</th>
								<th>คณะ</th>
								<th>GPA</th>
								<th>หน่วยงาน</th>
								
							</tr>
						</thead>
						<tbody>
							<?php echo count($student) == 0 ? '<td colspan="7">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($student as $r){ ?>
								<tr class="<?php echo $r['student_status'] == 0 ? 'tr-disabled' : ''; ?>">
									<td><?php echo ++$num; ?></td>
									<td>
										<?php if($r['student_status'] == 0){ ?>
											<span class="text-dark"><?php echo $r['dept_id'] != null ? 'ไม่อนุมัติเข้าทำงาน' : 'ไม่อนุมัติ'; ?></span>
										<?php } else if($r['student_status'] == 1) {?>
											<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/2/{$r['regist_id']}"); ?>" class="btn btn-warning btn-sm" title="อนุมัติให้เลือกหน่วยงาน"><i class="fas fa-check"></i></a>
											<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/0/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการไม่อนุมัติหรือไม่?');" title="ไม่อนุมัติ"><i class="fas fa-times"></i></a>
										<?php } else if($r['student_status'] == 2) {
											if($r['dept_id'] == null){ ?>
												<span class="text-warning">รอเลือกหน่วยงาน</span>
												<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/0/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการไม่อนุมัติหรือไม่?');" title="ไม่อนุมัติ"><i class="fas fa-times"></i></a>
											<?php } else{ ?>
												<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/3/{$r['regist_id']}"); ?>" class="btn btn-success btn-sm" title="อนุมัติให้เข้าทำงาน"><i class="fas fa-check-double"></i></a>
												<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/0/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการไม่อนุมัติหรือไม่?');" title="ไม่อนุมัติ"><i class="fas fa-times"></i></a>
											<?php }
										} else { ?>
											<span class="text-success">เข้าทำงานแล้ว</span>
											<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/2/{$r['regist_id']}"); ?>" class="btn btn-warning btn-sm" onclick="return confirm('ต้องการยกเลิกอนุมัติเข้าทำงานหรือไม่?');" title="ยกเลิกอนุมัติเข้าทำงาน"><i class="fas fa-long-arrow-alt-left"></i></a>
										<?php } ?>
									</td>
									<td><?php if($r['dept_id'] != null){ ?>
										<a href="<?php echo site_url("admin/working/{$r['dept_id']}/{$r['student_id']}") ?>" class="btn btn-link text-primary"><?php echo $r['student_id']; ?></a>
									<?php } else{
										echo $r['student_id'];
										
									}?>
									<td><?php echo $r['sname']; ?></td>
									<td><?php echo $r['sdiv_name']; ?></td>
									<td><?php echo $r['student_GPA']; ?></td>
									<td>
										<?php if($r['dept_id'] == null) {
											echo '-';
										} else {
											echo $r['ddiv_name'];
											if($r['student_status'] != 3) { ?>
												<a href="<?php echo site_url("admin/studentDeleteDept/{$r['student_id']}/{$r['dept_id']}/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบออกจากหน่วยงานหรือไม่?');" title="ลบออกจากหน่วยงาน"><i class="fas fa-trash-alt"></i></a>
											<?php } ?>
										<?php } ?>
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

<div class="modal fade" id="addDeptsModal" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDeptLabel"><i class="fas fa-plus"></i> เพิ่มรายละเอียดใบส่งตัว</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('admin/tranfer'); ?>" method="post" target="_blank">
				<input type="hidden" name="regist_id" value="<?php echo $regist[0]['regist_id']; ?>">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-borderless">
							<tr>
								<td>วันที่</td>
								<td>
									<input type="date" name="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" required/>
								</td>
							</tr>
							<tr>
								<td>เลขที่</td>
								<td>
									<div class="form-inline">
										มอ 052/<input type="text" name="no" class="form-control form-control-sm" required/>
									</div>
								</td>
							</tr>
							<tr>
								<td>นักศึกษา</td>
								<td>
									<select name="student_id" class="form-control form-control-sm">
										<option value="1">ทั้งหมด</option>
										<?php foreach ($studentWorking as $r) { ?>
											<option value="<?php echo $r['student_id']; ?>"><?php echo $r['student_id']; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>ลงชื่อ</td>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="director" id="director" value="1" onclick="checkDirector();" checked>
										<label class="form-check-label" for="director"> ผู้อำนวยการ</label>
									</div>
									<input type="text" class="form-control form-control-sm" name="name" value="นายคมกริช ชนะศรี" placeholder="-ชือ สกุล-" disabled required/>
									<input type="text" class="form-control form-control-sm" name="position" value="ผู้อำนวยการกองกิจการนักศึกษา" placeholder="-ตำแหน่ง-" disabled required/>
								</td>
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

<script>
	function checkDirector(){
		if($('#director').is(':checked')) {
			$('input[name="name"]').val('นายคมกริช ชนะศรี')
			$('input[name="position"]').val('ผู้อำนวยการกองกิจการนักศึกษา')
			$('input[name="name"]').prop('disabled', true)
			$('input[name="position"]').prop('disabled', true)
		} else {
			$('input[name="name"]').val('')
			$('input[name="position"]').val('รักษาการแทนผู้อำนวยการกองกิจการนักศึกษา')
			$('input[name="name"]').prop('disabled', false)
			$('input[name="position"]').prop('disabled', false)
		}
	}
</script>


