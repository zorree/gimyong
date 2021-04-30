<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">นักศึกษาหน่วยงานพิเศษ</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active"><a href="<?php echo site_url('dept/depts'); ?>">หน่วยงาน</a></li>
			<li class="breadcrumb-item active" aria-current="page">นักศึกษาหน่วยงานพิเศษ</li>
		</ol>
	</div>
	<div class="col-12">
		<div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addStudentModal"><i class="fas fa-plus"></i> เพิ่มนักศึกษา</button>
				</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th></th>
								<th>รหัส</th>
								<th>ชื่อ</th>
								<th>คณะ</th>
								<th>หน่วยงาน</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($listStudent) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($listStudent as $r){ ?>
								<tr>
									<td><?php echo ++$num; ?></td>
									<td><a href="<?php echo site_url("dept/working/{$r['dept_id']}/{$r['student_id']}") ?>" class="btn btn-link text-primary"><?php echo $r['student_id']; ?></a></td>
									<td><?php echo $r['name']; ?></td>
									<td><?php echo $r['sdiv_name']; ?></td>
									<td><?php echo $r['ddiv_name']; ?></td>
									<td>
									<a href="<?php echo site_url("dept/deleteStudentS/{$r['dept_id']}/{$r['student_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบนักศึกษานี้หรือไม่?');" title="ลบหน่วยงาน"><i class="far fa-trash-alt"></i></a>
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
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRegistLabel"><i class="fas fa-plus"></i> เพิ่มนักศึกษา</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form action="<?php echo site_url('dept/addStudentS'); ?>" method="post">
				<input type="hidden" name="dept_id" value="<?php echo $dept[0]['dept_id']; ?>">
				<div class="modal-body">
					<div class="table-responsive table-borderless">
						<table class="table">
							<tr>
								<td><input type="text" class="form-control form-control-sm" name="student_id" placeholder="รหัสนักศึกษา" required></td>
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


