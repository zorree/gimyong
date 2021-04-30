<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo "ข้อมูลหน่วยงาน รอบ {$regist[0]['regist_term']}/".($regist[0]['regist_year'] + 543); ?></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active"><a href="<?php echo site_url('admin'); ?>">รอบการทำงาน</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo "ข้อมูลหน่วยงาน รอบ {$regist[0]['regist_term']}/".($regist[0]['regist_year'] + 543); ?></li>
		</ol>
	</div>
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>การอนุมัติ</th>
								<th>นักศึกษา</th>
								<th>ผู้ควบคุม</th>
								<th>หน่วยงาน</th>
								<th>ประเภทงาน</th>
								<th>ลักษณะงาน</th>
								<th>คุณสมบัติ</th>
								<th>เวลาทำงาน</th>
								<th>เฉพาะคณะตัวเอง</th>
								<th>เพศ</th>
								<th>เบอร์โทร</th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($listDept) == 0 ? '<td colspan="10">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php foreach($listDept as $r){ ?>
								<tr class="<?php echo $r['dept_status'] == 0 ? 'tr-disabled' : ''; ?>">
									<td>
										<?php if($r['dept_status'] == 0) { ?>
											<span class="text-dark">ไม่อนุมัติ</span>
										<?php } else if($r['dept_status'] == 1) { ?>
											<a href="<?php echo site_url("admin/approveDept/{$r['dept_id']}/2/{$r['regist_id']}"); ?>" class="btn btn-success btn-sm" title="อนุมัติหน่วยงาน"><i class="fas fa-check"></i></a>
											<a href="<?php echo site_url("admin/approveDept/{$r['dept_id']}/0/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" title="ไม่อนุมัติ" onclick="return confirm('ต้องการไม่อนุมัติหรือไม่?');"><i class="fas fa-times"></i></a>

										<?php } else { ?>
											<span class="text-success">อนุมัติแล้ว</span>
										<?php } ?>
									</td>
									<td>
										<?php if($r['student_id'] != null) { ?>
											<a href="<?php echo site_url("admin/working/{$r['dept_id']}/{$r['student_id']}") ?>" class="btn btn-link text-primary"><?php echo $r['student_id']; ?></a>
											<a href="<?php echo site_url("admin/approveStudent/{$r['student_id']}/2/{$r['regist_id']}/true"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบนักศึกษาออกจากหน่วยงานนี้หรือไม่?');" title="ลบนักศึกษา"><i class="fas fa-trash-alt"></i></a>
										<?php } else { 
											echo '-ไม่มีนักศึกษา-';
										} ?>
									</td>
									<td><?php echo $r['name']; ?></td>
									<td><?php echo $r['div_name'];?></th>
									<td><?php echo $r['job_name']; ?></td>
									<td><?php echo $r['dept_description']; ?></th>
									<td><?php echo $r['dept_property']; ?></td>
									<td><?php echo $r['dept_time'] == 0 ? 'ในเวลาราชการ' : ($r['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ'); ?></td>
									<td><?php echo $r['dept_fac'] == '0' ? '-' : '<i class="fas fa-check-circle"></i>'; ?></td>
									<td><?php echo $r['dept_gender'] == 'M' ? 'ชาย' : ($r['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง'); ?></td>
									<td><?php echo $r['dept_tel']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


