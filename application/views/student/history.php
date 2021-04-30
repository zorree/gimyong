<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">ประวัติการทำงาน</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">ประวัติการทำงาน</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="table-responsive">	
					<table class="table table-bordered text-center table-nowrap">
						<thead>
							<tr>
								<th>สถานะ</th>
								<th>รอบการทำงาน</th>
								<th>วันเลือกหน่วยงาน</th>
								<th>ผู้ควบคุม</th>
								<th>หน่วยงาน</th>
								<th>ประเภทงาน</th>
								<th>ลักษณะงาน</th>
								<th>คุณสมบัติ</th>
								<th>เวลาทำงาน</th>
								<th>เพศ</th>
								<th>เบอร์โทร</th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($history) == 0 ? '<td colspan="11">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php foreach($history as $r) { ?>
								<tr>
									<td>
										<?php $now = time();
										if($r['regist_id'] != null && $r['student_status'] != 4){
											if($r['student_status'] == 0){
												if($r['dept_id'] == null){ ?>
													<span class="text-danger">ไม่อนุมัติ</span>
												<?php }else{ ?>
													<span class="text-danger">ไม่อนุมัติเข้าทำงาน</span>
												<?php }
											} else if($r['student_status'] == 1){ ?>
												<span class="text-warning">รออนุมัติเลือกหน่วยงาน</span>
											<?php } else if($r['student_status'] == 2){
												$start = strtotime($r['dept_start']);
												$stop = strtotime('+1 day', strtotime($r['dept_stop']));
												if($r['dept_id'] == null){
													if($now >= $start && $now < $stop) { ?>
														<button type="button" class="btn btn-outline-primary btn-sm" onclick="addDeptModal('<?php echo $r['regist_id']; ?>');">เลือกหน่วยงาน</button>
													<?php } else{ ?>
														<span class="text-fade">ปิดเลือกหน่วยงาน</span>
													<?php }
												} else { ?>
													<span class="text-warning">รออนุมัติเข้าทำงาน</span>
													<?php if($now >= $start && $now < $stop){ ?>
														<a href="<?php echo site_url("student/deleteDept/{$r['regist_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการยกเลิกหน่วยงานแล้วเลือกใหม๋หรือไม่?');" title="ยกเลิกหน่วยงานแล้วเลือกใหม๋"><i class="far fa-trash-alt"></i></a>
													<?php } ?>
												<?php }
											} else if($r['student_status'] == 3){ ?>
												<a href="<?php echo site_url("student/working/{$r['dept_id']}") ?>" class="btn btn-link text-success">เข้าทำงานแล้ว</a>
											<?php }
										} else { ?>
											<a href="<?php echo site_url("student/working/{$r['dept_id']}") ?>" class="btn btn-link text-success">นักศึกษาพิเศษ</a>
										<?php } ?>
									</td>
									<?php if($r['regist_id'] != null) { ?>
										<td>
											<?php echo $r['regist_term'].'/'.($r['regist_year'] + 543); ?>
										</td>
										<td class="<?php echo openDate(strtotime($r['dept_start']), strtotime($r['dept_stop'])); ?>">
											<?php echo displayDate(strtotime($r['dept_start']), strtotime($r['dept_stop'])); ?>
										</td>
									<?php } else { ?>
										<td colspan="2">-</td>
									<?php } ?>
									<?php if($r['dept_id'] == null) { ?>
										<td colspan="9">ไม่มีข้อมูล</td>
									<?php } else { ?>
										<td><?php echo $r['name']; ?></td>
										<td><?php echo $r['div_name'];?></th>
										<td><?php echo $r['job_name'];?></th>
										<td><?php echo $r['dept_description']; ?></th>
										<td><?php echo $r['dept_property']; ?></td>
										<td><?php echo $r['dept_time'] == 0 ? 'ในเวลาราชการ' : ($r['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ'); ?></td>
										<td><?php echo $r['dept_gender'] == 'M' ? 'ชาย' : ($r['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง'); ?></td>
										<td><?php echo $r['dept_tel']; ?></td>
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

<div class="modal fade" id="addDeptModal" tabindex="-1" role="dialog" aria-labelledby="addDeptLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addDeptLabel"><i class="fas fa-hand-pointer"></i> เลือกหน่วยงาน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form action="<?php echo site_url('admin/addAdmin'); ?>" method="post">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table text-center table-borderless table-nowrap">
							<thead>
								<th></th>
								<th>เลือก</th>
								<th>ผู้ควบคุม</th>
								<th>หน่วยงาน</th>
								<th>ประเภทงาน</th>
								<th>ลักษณะงาน</th>
								<th>คุณสมบัติ</th>
								<th>เวลาทำงาน</th>
								<th>เฉพาะคณะตัวเอง</th>
								<th>เพศ</th>
								<th>เบอร์โทร</th>
							</thead>
							<tbody id="listAddDept">
							</tbody>
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
	function addDeptModal(regist_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('student/loadDeptRegistid'); ?>",
			data: {
				regist_id: regist_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			let text = '';
			$.each( result, function(i) {
				text += '<tr>';
				text += '<td>' + (i + 1) + '</td>';
				text += '<td>';
					if(result[i]['student_id'] != null) {
						text += '<span class="text-danger">เต็ม</span>';
					} else {
						text += '<a href="<?php echo site_url('student/selectDept/'); ?>' + result[i]['dept_id'] + '/' + result[i]['regist_id'] + '" class="btn btn-outline-success btn-sm">เลือก</a>';
					}
				text += '</td>'
				text += '<td>' + result[i]['name'] + '</td>';
				text += '<td>' + result[i]['div_name'] + '</td>';
				text += '<td>' + result[i]['job_name'] + '</td>';
				text += '<td>' + result[i]['dept_description'] + '</td>';
				text += '<td>' + result[i]['dept_property'] + '</td>';
				text += '<td>' + (result[i]['dept_time']  == 0 ? 'ในเวลาราชการ' : (result[i]['dept_time'] == 1 ? 'นอกเวลาราชการ' : 'ในและนอกเวลาราชการ')) + '</td>';
				text += '<td>' + (result[i]['dept_fac']  == 0 ? '-' : '<i class="fas fa-check-circle"></i>') + '</td>';
				text += '<td>' + (result[i]['dept_gender']  == 'M' ? 'ชาย' : (result[i]['dept_gender'] == 'F' ? 'หญิง' : 'ทั้งสอง')) + '</td>';
				text += '<td>' + result[i]['dept_tel'] + '</td>';
				text += '</tr>';
			});
			$('#listAddDept').html(text)
			// console.log(text);
		});
		$('#addDeptModal').modal('show')
	}
</script>

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