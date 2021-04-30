<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">รายงานงบประมาณประจำงวด</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">รายงานงบประมาณประจำงวด</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header y-2 text-center">
				<h3 class="panel-title" id="header"></h3>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
						<form id="exportExcel" target="_blank" method="post" action="<?php echo site_url('report/excelround/'); ?>">
							<div class="d-flex justify-content-between">
								<div>
									<button type="submit" class="btn btn-outline-success btn-sm text-success">นำออก Excel <i class="far fa-file-excel"></i></button>
								</div>
								<div>
									<div class="form-inline">
										<select name="regist_year" id="regist_year" class="mr-2 form-control form-control-sm" onchange="loadTerm();">
											<option value="">ทุกปี</option>
											<?php $num = 0;
											foreach ($year as $r){ ?>
												<option value="<?php echo $r['regist_year']; ?>" <?php echo $num++ > 0 ?: 'selected'; ?>><?php echo 'ปีการศึกษา '.($r['regist_year'] + 543); ?></option>
											<?php }?>
										</select>
										<select name="regist_term" id="regist_term" class="mr-2 form-control form-control-sm" onchange="loadRound();"></select>
										<select name="round_id" id="round_id" class="mr-2 form-control form-control-sm" onchange="loadReport();"></select>
									</div>
								</div>
							</div>
						</form>
						<div class="table-responsive my-3">
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th>ลำดับ</th>
										<th>รหัสนักศึกษา</th>
										<th>ชื่อ-สกุล</th>
										<th>เลขที่บัญชี</th>
										<th>จำนวนเงิน</th>
									</tr>
								</thead>
								<tbody id="listReport"></tbody>	
								<tfoot id="tfooter"></tfoot>	
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		loadTerm();
	})
	function loadTerm() {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('report/loadTerm'); ?>",
			data: {
				regist_year: $('#regist_year').val()
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			// console.log(result)
			let text = '';
			text += '<option value="">ทุกเทอม</option>';
			$.each( result, function(i) {
				text += '<option value="' + result[i]['regist_term'] + '">เทอม ' + result[i]['regist_term'] + '</option>';
			})
			$('#regist_term').html(text)
			loadRound();
		});
	}
	function loadRound() {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('report/loadRound'); ?>",
			data: {
				regist_year: $('#regist_year').val(),
				regist_term: $('#regist_term').val()
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			// console.log(result)
			let text = '';
			text += '<option value="">ทุกงวด</option>';
			$.each( result, function(i) {
				text += '<option value="' + result[i]['round_id'] + '">งวดที่ ' + result[i]['round_num'] + '</option>';
			})
			$('#round_id').html(text)
			loadReport()
		});
	}
	function loadReport() {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('report/loadReportRound'); ?>",
			data: {
				regist_year: $('#regist_year').val(),
				regist_term: $('#regist_term').val(),
				round_id: $('#round_id').val()
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			console.log(result)
			let text = '';
			let num = 0;
			let sum = 0;

			$.each( result, function(i) {
				sum += result[i]['sum'] * 40;
				text += '<tr>';
				text +=		'<td>' + (++num) + '</td>';
				text +=		'<td>' + result[i]['student_id'] + '</td>';
				text +=		'<td>' + result[i]['name'] + '</td>';
				text +=		'<td>' + result[i]['bank'] + '</td>';

				text +=		'<td>' + (result[i]['sum'] * 40) +'</td>';
				text +=		'</tr>';
			})
			if(result.length > 0 ){
				$('#tfooter').html('<tr><td colspan="4" align="right">รวม</td><td>' + sum + '</td></tr>')
			}else{
				$('#tfooter').html('')
				text = '<tr><td colspan="5">-ไม่มีข้อมูล-</td></tr>';
			}
			let header = 'รายชื่อนักศึกษาทุนทำงานแลกเปลี่ยน ประจำ';
			header += $('#round_id').val() != '' ? $('#round_id option:selected').text() + ' ' : '';
			header += $('#regist_term').val() != '' ? 'ภาคเรียนที่ ' + $('#regist_term').val() + '/' : 'ปีการศึกษา ';
			header += (parseInt($('#regist_year').val()) + 543);
			$('#header').html(header)
			$('#listReport').html(text)
		});
	}
</script>