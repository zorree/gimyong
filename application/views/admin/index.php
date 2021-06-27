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
