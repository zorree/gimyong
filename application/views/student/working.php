<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">ข้อมูลนักศึกษา <?php echo $student[0]['student_id']; ?></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item"><a href="<?php echo site_url('student/history/'); ?>">ประวัติการทำงาน</a></li>
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
						<div class="col-md-6"><a href="<?php  echo site_url('student/apply/'.$dept[0]['regist_id']); ?>">ใบสมัคร</a></div>
					<?php } ?>
					<hr>
					<div class="col-md-6"><b>หน่วยงาน : </b><?php echo $dept[0]['div_name']; ?></div>
					<div class="col-md-6"><b>ผู้ควบคุม : </b><?php echo $dept[0]['name']; ?></div>
				</div>
				<div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center table-sm">
						<thead>
							<tr>
								<th width="1%">
									<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addWorkingModel"><i class="fas fa-plus"></i></button>
								</th>
								<th>วันทำงาน</th>
								<th>เวลา มา-กลับ</th>
								<th>รวมเวลา</th>
								<th>งานที่ทำ</th>
								<th>อนุมัติ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
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
										<span class="text-warning">รออนุมัติ</span>
									<?php } else { ?>
										<?php if($r['round_id'] == null ){
											$min2 += ($hour*60) + $minute; ?>
											<span class="text-success">อนุมัติแล้ว</span>
										<?php } else {
											$index = $r['round_num'].($dept[0]['regist_id'] == null ? ' ('.$r['regist_term'].'/'.($r['regist_year'] + 543 - 2500).')' : '');
											$minR[$index] = isset($minR[$index]) ? $minR[$index] : 0;
											$minR[$index] += ($hour*60) + $minute; ?>
											<span class="text-fade"><?php echo "เบิกจ่ายงวดที่ {$index}"; ?> แล้ว</span>
										<?php } ?>
									<?php } ?>
								</td>
								<td>
									<?php if($r['working_status'] != 2) {?>
										<a href="<?php echo site_url("student/deleteWorking/{$r['working_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบวันเวลาที่ทำงานนี้หรือไม่?');" title="ลบวันเวลาที่ทำงาน"><i class="far fa-trash-alt"></i></a>
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
											<td colspan="3" align="right" class="text-success">
												<span class="float-left">
													<a href="<?php echo site_url('student/exportPDF/'.$dept[0]['dept_id']); ?>" class="btn btn-outline-success btn-sm text-success" target="_blank">นำออก PDF <i class="far fa-file-pdf"></i></a>
												</span>
												อนุมัติแล้ว
											</td>
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

<div class="modal fade" id="addWorkingModel" tabindex="-1" role="dialog" aria-labelledby="addWorkingModelLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addWorkingModelLabel"><i class=""></i> เพิ่มชั่วโมงการทำงาน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('student/addWorking'); ?>" method="post">
				<input type="hidden" name="dept_id" value="<?php echo $dept[0]['dept_id']; ?>">
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-borderless">
							<tr>
								<td>วันที่</td>
								<td>
									<input name="date" type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" required>
								</td>
							</tr>
							<tr>
								<td>เวลามา<br/>เวลากลับ</td>
								<td>
									<div class="input-group input-group-sm">
										<select name="startH" class="form-control" required>
											<option value="" disabled selected>ชม.</option>
											<?php for($i = 0; $i < 24; $i++) {
												$h = $i < 10 ? "0{$i}" : $i; ?>
												<option value="<?php echo $h; ?>"><?php echo $h; ?></option>
											<?php } ?>
										</select>
										<div class="input-group-prepend">
											<div class="input-group-text">:</div>
										</div>
										<select name="startM" class="form-control" required>
											<option value="" disabled selected>น.</option>
											<option value="00">00</option>
											<option value="30">30</option>
										</select>
									</div>
									<div class="input-group input-group-sm">
										<select name="stopH" class="form-control" required>
											<option value="" disabled selected>ชม.</option>
											<?php for($i = 0; $i < 24; $i++) {
												$h = $i < 10 ? "0{$i}" : $i; ?>
												<option value="<?php echo $h; ?>"><?php echo $h; ?></option>
											<?php } ?>
										</select>
										<div class="input-group-prepend">
											<div class="input-group-text">:</div>
										</div>
										<select name="stopM" class="form-control" required>
											<option value="" disabled selected>น.</option>
											<option value="00">00</option>
											<option value="30">30</option>
										</select>
									</div>
								</td>
							</tr>
							<!-- <tr>
								<td>เวลากลับ</td>
								<td><input name="working_stop" type="text" class="form-control form-control-sm" required></td>
							</tr> -->
							<tr>
								<td>งานที่ทำ</td>
								<td><textarea name="working_detail" class="form-control form-control-sm" required></textarea></td>
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
