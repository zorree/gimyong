<!-- <div class="container-fluid" id="container-wrapper"> -->
<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">ร้านค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">ร้านค้า</li>
		</ol>
	</div>

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
                    ร้านค้า
				</h6>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="col p-0 mb-2">
						<input type="text" class="col col-lg-4 border border-primary form-control" placeholder="ใส่ชื่อร้านค้า" onkeyup="showMarket(this);">
					</div>
					<div class="tab-pane fade show active" id="regist" role="tabpanel" aria-labelledby="regist-tab">
                        <!-- <button type="button" class="btn btn-outline-success mb-3" data-toggle="modal" data-target="#addRegistModal"><i class="fas fa-plus"></i> เพิ่มรอบการทำงาน</button> -->
                        <div class="table-responsive">	
							<table class="table table-nowrap table-bordered text-center">
								<thead>
									<tr>
										<th>#</th>
										<th>เจ้าของร้าน</th>
										<th>ชื่อร้านค้า</th>
										<th>ประเภท</th>
										<th>รายละเอียด</th>
									</tr>
								</thead>
								<tbody  id="showText">
									<?php echo count($listmarket) == 0 ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : ''; ?>
									<?php 
										$num = 0;
										foreach($listmarket as $r){ 
									?>
										<tr>
											<td><?php echo ++$num; ?></td>
											<td><?php echo $r['m_name'],' ',$r['m_lname'];?></td>
											<td><?php echo $r['m_shopname'];?></td>
											<td>
												<?php 
													if ($r['m_shoptype'] == 1) {
														echo 'เสื้อผ้า';
													} else if ($r['m_shoptype'] == 2) {
														echo 'อาหาร';
													} else if ($r['m_shoptype'] == 3) {
														echo 'ของฝาก';
													} else if ($r['m_shoptype'] == 4) {
														echo 'เครื่องใช้ไฟฟ้า';
													} else {
														echo 'ผลไม้';
													}
												?>
											</td>
											<td>
												<a href="<?=site_url("customer/marketdetail/{$r['m_id']}")?>">คลิกเพื่อดูรายละเอียด</a>
											</td>
										</tr>
									<?php 
										} 
									?>
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

	function showMarket(name) {
		// console.log(name.value)
		var url = '<?php echo site_url("customer/showmarket");?>' ;
		var req = new XMLHttpRequest();
		req.open('POST', url, true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.onload = function() {
			var json = JSON.parse(req.response);
			console.log(json)
			if (json.length != 0) {
				var num = 0
				var type
				var text = ''
				for (i = 0; i < json.length; i++) {
					if (json[i]['m_shoptype'] == 1) {
						type = 'เสื้อผ้า';
					} else if (json[i]['m_shoptype'] == 2) {
						type = 'อาหาร';
					} else if (json[i]['m_shoptype'] == 3) {
						type = 'ของฝาก';
					} else if (json[i]['m_shoptype'] == 4) {
						type = 'เครื่องใช้ไฟฟ้า';
					} else {
						type = 'ผลไม้';
					}

					text += 
						"<tr>" +
							"<td>" + (++num) + "</td>" +
							"<td>" + json[i]['m_name'] + ' ' + json[i]['m_lname'] + "</td>" +
							"<td>" + json[i]['m_shopname'] + "</td>" +
							"<td>" + type + "</td>" +
							"<td>" +
								"<a href='<?=site_url("customer/marketdetail/")?>" + json[i]['m_id'] + "'>คลิกเพื่อดูรายละเอียด</a>" +
							"</td>" +
						"</tr>"
					;
				}
				document.getElementById("showText").innerHTML = text
			} else {
				document.getElementById("showText").innerHTML = "<td colspan='5'>-ไม่มีข้อมูล-</td>";
			}
		}
		if (name.value) {
			req.send("data="+name.value);
		} else {
			req.send();
		}
	}

</script>