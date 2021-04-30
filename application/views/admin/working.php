<?php 
// print_r($round);
// print_r($regist);
// print_r($student);
// print_r($listWorking);
?>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">ข้อมูลนักศึกษา <?php echo $student[0]['student_id']; ?></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active"><a href="<?php echo site_url('admin'); ?>">รอบการทำงาน</a></li>
			<li class="breadcrumb-item active" aria-current="page">ข้อมูลนักศึกษา <?php echo $student[0]['student_id']; ?></li>

		</ol>
	</div>
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row mt-2 mb-4">
					<div class="col-md-6"><b>รหัสนักศึกษา : </b><?php echo $student[0]['student_id']; ?></div>
					<div class="col-md-6"><b>ชื่อ : </b><?php echo $student[0]['name']; ?></div>
					<div class="col-md-6"><b>คณะ : </b><?php echo $student[0]['div_name']; ?></div>
					<?php if($dept[0]['regist_id'] != null){ ?>
						<div class="col-md-6"><a href="<?php  echo site_url('admin/apply/'.$dept[0]['regist_id'].'/'.$student[0]['student_id']); ?>">ใบสมัคร</a></div>
					<?php } ?>
					<hr>
					<div class="col-md-6"><b>หน่วยงาน : </b><?php echo $dept[0]['div_name']; ?></div>
					<div class="col-md-6"><b>ผู้ควบคุม : </b><?php echo $dept[0]['name']; ?></div>
				</div>
				<div class="table-responsive">
					<table class="table table-nowrap table-bordered text-center table-sm">
						<thead>
							<tr>
								<th width="1"></th>
								<th>วันทำงาน</th>
								<th>เวลา มา-กลับ</th>
								<th>รวมเวลา</th>
								<th>งานที่ทำ</th>
								<th>อนุมัติ</th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($listWorking) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $i=0 ; $m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
							$sumH = 0; $sumM = 0;
							$min0 = 0; $min1 = 0; $min2 = 0; $minR = [];
							foreach($listWorking as $r){
								$start = strtotime($r['working_start']);
								$stop = strtotime($r['working_stop']);
							?>
							<tr>
								<td><?php echo ++$i; ?></td>
								<td><?php echo date('j', $start).' '.$m[date('n', $start) - 1].' '.(date('y', $start) + 43); ?></td>
								<td><?php echo date('H:i', $start).' - '.date('H:i', $stop)?></td>
								<td>
									<?php $hour = (int)$r['total'];
									$minute = abs($r['total'] - round($r['total']));
									$minute = ($minute > 0 ? '30' : '0');
									$sumH += $hour;
									$sumM += $minute;

									echo $hour.':'.$minute.($minute < 10 ? '0' : ''); ?>
								</td>
								<td><?php echo $r['working_detail'];?></td>
								<td>
									<?php if($r['working_status'] == 0){
										$min0 += ($hour*60) + $minute; ?>
										<span class="text-danger">ไม่อนุมัติ</span>
									<?php } else if($r['working_status'] == 1){
										$min1 += ($hour*60) + $minute; ?>
										<a href="<?php echo site_url("admin/updateWorking/{$r['dept_id']}/{$r['student_id']}/{$r['working_id']}/2"); ?>" class="btn btn-success btn-sm" title="อนุมัติเวลาทำงาน"><i class="fas fa-check"></i></a>
										<a href="<?php echo site_url("admin/updateWorking/{$r['dept_id']}/{$r['student_id']}/{$r['working_id']}/0"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการไม่อนุมัติหรือไม่?');" title="ไม่อนุมัติเวลาทำงาน"><i class="fas fa-times"></i></a>
									<?php } else {
										if($r['round_id'] == null){
										$min2 += ($hour*60) + $minute; ?>
										<button type="button" class="btn btn-outline-success btn-sm" onclick="addRoundModal('<?php echo $r['working_id']; ?>');">อนุมัติเบิกจ่าย</button>
									<?php } else {
										$index = $r['round_num'].($dept[0]['regist_id'] == null ? ' ('.$r['regist_term'].'/'.($r['regist_year'] + 543 - 2500).')' : '');
										$minR[$index] = isset($minR[$index]) ? $minR[$index] : 0;
										$minR[$index] += ($hour*60) + $minute; ?>
										<span class="text-fade"><?php echo "เบิกจ่ายงวดที่ {$index}"; ?> แล้ว</span>
										<a href="<?php echo site_url("admin/cancelRound/{$r['working_id']}/{$r['dept_id']}/{$r['student_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการยกเลิกงวดเบิกจ่ายนี้หรือไม่?');" title="ยกเลิกงวดเบิกจ่าย"><i class="fas fa-times"></i></a>
									<?php } ?>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
						<tfooter>
							<?php if(count($listWorking) == 0) { ?>
								<tr><td colspan="7">-ไม่มีข้อมูล-</td></tr>
							<?php } else { ?>
									<?php if($min2 > 0) { ?>
										<tr>
											<td colspan="3" align="right" class="text-success">อนุมัติแล้ว</td>
											<td>
												<?php echo (int)($min2 / 60).':'.(int)($min2%60).(($min2%60) < 10 ? '0' : ''); ?>
											</td>
											<td colspan="3"></td>
										</tr>
									<?php }
									if($min1 > 0) { ?>
										<tr>
											<td colspan="3" align="right" class="text-warning">รออนุมัติ</td>
											<td>
												<?php echo (int)($min1 / 60).':'.(int)($min1%60).(($min1%60) < 10 ? '0' : ''); ?>
											</td>
											<td colspan="3"></td>
										</tr>
									<?php }
									if($min0 > 0) { ?>
										<tr>
											<td colspan="3" align="right" class="text-danger">ไม่อนุมัติ</td>
											<td>
												<?php echo (int)($min0 / 60).':'.(int)($min0%60).(($min0%60) < 10 ? '0' : ''); ?>
											</td>
											<td colspan="3"></td>
										</tr>
									<?php }
										foreach($minR AS $k => $r) { ?>
											<tr>
												<td colspan="3" align="right" class="text-fade"><?php echo "เบิกจ่ายงวดที่ {$k}"; ?></td>
												<td>
													<?php echo (int)($r / 60).':'.(int)($r%60).(($r%60) < 10 ? '0' : ''); ?>
												</td>
												<td colspan="3"></td>
											</tr>
										<?php } ?>
									<tr>
										<td colspan="3" align="right"><b>รวม</b></td>
										<td>
											<?php $sumH += ($sumM/60); $sumM = ($sumM%60);
											echo (int)$sumH.':'.$sumM.($sumM < 10 ? '0' : ''); ?>
										</td>
										<td colspan="3"></td>
									</tr>
							<?php } ?>
						</tfooter>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	function addRoundModal(working_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('admin/loadWorkingBefore'); ?>",
			data: {
				working_id: working_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			let m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
			let sumH = 0;
			let sumM = 0;
			$.each(result, function(i) {
				hour = parseInt(result[i]['total']);
				minute = Math.abs(result[i]['total'] - parseInt(result[i]['total']));
				minute = (minute > 0 ? 30 : 0);
				sumH += hour;
				sumM += minute;
				
			});
			start = result[0];
			stop = result[result.length - 1];
			$('#roundWorking_stop').val(stop['working_stop'])
			$('#roundStudent_id').val(stop['student_id'])

			$('#roundNum').html(result.length + ' ครั้ง')
			$('#roundStart').html(displayDate(start))
			$('#roundStop').html(displayDate(stop))
			sumH += parseInt(sumM/60); sumM = parseInt(sumM%60);
			
			$('#roundHour').html(sumH + ':' + sumM + (sumM < 10 ? '0' : '') + ' ชม.')
		});
		$('#addRoundModal').modal('show')
	}

	function displayDate(date) {
		var m	= ['ม.ค.','ก.พ','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		dateStart	= new Date(date['working_start'])
		dateStop	= new Date(date['working_stop'])

		let text = dateStart.getDate() + ' ' + m[dateStart.getMonth()] + ' ' + (parseInt(dateStart.getFullYear()) + 543 - 2500);
		text += ' | ' + dateStart.getHours() + ':' + (dateStart.getMinutes() < 10 ? '0' + dateStart.getMinutes() : dateStart.getMinutes());
		text += ' - ' + dateStop.getHours() + ':' + (dateStop.getMinutes() < 10 ? '0' + dateStop.getMinutes() : dateStop.getMinutes());
		return text;
	}
</script>



<div class="modal fade" id="addRoundModal" tabindex="-1" role="dialog" aria-labelledby="addRoundModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoundModalLabel"><i class=""></i> เบิกจ่าย</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('admin/addRound'); ?>" method="post">
				<input type="hidden" id="roundWorking_stop" name="working_stop">
				<input type="hidden" id="roundStudent_id" name="student_id">
				<input type="hidden" name="dept_id" value="<?php echo $dept[0]['dept_id']; ?>">
				<div class="modal-body">
					<div class="table-responsive table-borderless">
						<table class="table">
							<tr>
								<td>จำนวน</td>
								<td id="roundNum"></td>
							</tr>
							<tr>
								<td>จากวันที่</td>
								<td id="roundStart"></td>
							</tr>
							<tr>
								<td>ถึงวันที่</td>
								<td id="roundStop"></td>
							</tr>
							<tr>
								<td>จำนวน</td>
								<td id="roundHour"></td>
							</tr>
							<tr>
								<td>เบิกจ่าย</td>
								<td>
									<select class="form-control form-control-sm" name="round_id" required>
										<?php if($dept[0]['regist_id'] != null) {
											$num = 0; ?>
											<optgroup label="<?php echo 'รอบ '.$dept[0]['regist_term'].'/'.($dept[0]['regist_year'] + 543); ?>">
												<option value="<?php echo $dept[0]['regist_term'].'/'.$dept[0]['regist_year']; ?>" class="text-fade">
													<?php echo 'งวดที่ '.(count($round) + 1).' (ใหม่)'; ?>
												</option>
												<?php foreach($round AS $r) { ?>
													<option value="<?php echo $r['round_id']; ?>" <?php echo $num++ > 0 ?: 'selected'; ?>>
														<?php echo "งวดที่ {$r['round_num']}"; ?>
													</option>
												<?php } ?>
											</optgroup>
										<?php } else {
											if(count($regist) > 0) {
												$num = 0;
												foreach($regist AS $r) {
													$round = $this->AdminModel->loadRoundRegistid($r['regist_id']);
													if($num != 0) { ?>
														<option value="" disabled></option>
													<?php } ?>
													<optgroup label="<?php echo 'รอบ '.$r['regist_term'].'/'.($r['regist_year'] + 543); ?>">
														<option value="<?php echo $r['regist_term'].'/'.$r['regist_year']; ?>" class="text-fade">
															<?php echo 'งวดที่ '.(count($round) + 1).' (ใหม่)'; ?>
														</option>
														<?php foreach($round AS $r2) { ?>
															<option value="<?php echo $r2['round_id']; ?>" <?php echo $num++ > 0 ?: 'selected'; ?>>
																<?php echo "งวดที่ {$r2['round_num']}"; ?>
															</option>
														<?php } ?> 
													</optgroup>
												<?php }
											} else { ?>
												<option value="" disabled selected>ไม่มีรอบการทำงาน (กรุณาเพิ่มรอบการทำงานก่อน)</option>
											<?php }
										} ?>
									</select>
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


