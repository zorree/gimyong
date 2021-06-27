<!-- <div class="container-fluid" id="container-wrapper"> -->
<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">ลูกค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">ลูกค้า</li>
		</ol>
	</div>

	<div class="col-12 pl-0 pr-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
                    ข้อมูลลูกค้า
				</h6>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="col p-0 mb-2">
						<input type="text" class="col col-lg-4 border border-primary form-control" placeholder="ใส่ชื่อลูกค้า" onkeyup="showMarket(this);">
					</div>
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
                        <!-- <button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#addRegistModal"><i class="fas fa-plus"></i> เพิ่มรอบการทำงาน</button> -->
                        <div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th>#</th>
										<!-- <th>รหัสลูกค้า</th> -->
                                        <th>ชื่อ - นามสกุล</th>
										<!-- <th>เพศ</th> -->
										<th>รายละเอียด</th>
									</tr>
								</thead>
								<tbody id="showText">
									<?php echo count($listcustomer) == 0 ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : ''; ?>
									<?php $num = 0;
									foreach($listcustomer as $r){ ?>
										<tr>
                                            <td><?php echo ++$num; ?></td>
                                            <!-- <td><?php echo $r['c_id'] ?></td> -->
											<td><?php echo $r['c_name'],' ',$r['c_lname'];?></td>
                                            <!-- <td><?php echo 'ชาย / หญิง' ?></td> -->
											<td><a href="<?php echo site_url("admin/customerdetail/{$r['c_id']}")?>" class="btn btn-link text-primary">คลิกเพื่อดูรายละเอียด</a></td>
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

<script>
	function editDeptsModal(dept_id) {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('admin/loadDeptid'); ?>",
			data: {
				dept_id: dept_id
			}
		})
		.done(function(result) {
			result = JSON.parse(result)
			result = result[0]
			$('#edit_dept_id').val(result['dept_id'])
			$('#edit_dept_admin').html(result['dept_admin'])
			$('#edit_div_name').html(result['div_name'])
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

<script>

	function showMarket(name) {
		// console.log(name.value)
		var url = '<?php echo site_url("admin/showcustomer");?>' ;
		var req = new XMLHttpRequest();
		req.open('POST', url, true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.onload = function() {
			var json = JSON.parse(req.response);
			console.log(json)
			if (json.length != 0) {
				var num = 0
				var text = ''
				for (i = 0; i < json.length; i++) {
					text += 
						"<tr>" +
						"<td>" + (++num) + "</td>" +
						"<td>" + json[i]['c_name'] + ' ' + json[i]['c_lname'] + "</td>" +
						"<td><a href='<?=site_url("admin/marketdetail/")?>" + json[i]['c_id'] + "'>คลิก</a></td>"
					;
				}
				document.getElementById("showText").innerHTML = text
			} else {
				document.getElementById("showText").innerHTML = "<td colspan='3'>-ไม่มีข้อมูล-</td>";
			}
		}
		if (name.value) {
			req.send("data="+name.value);
		} else {
			req.send();
		}
	}
</script>
