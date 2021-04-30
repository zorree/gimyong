<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">แอดมิน</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">แอดมิน</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">
					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addRegistModal"><i class="fas fa-plus"></i> เพิ่มแอดมิน</button>
				</h6>
			</div>
			<div class="card-body">
				<!-- <?php print_r($listAdmin); ?> -->
				<div class="table-responsive">	
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th scope="col">Username</th>
								<th scope="col">ชื่อ</th>
								<th scope="col">ระดับผู้ใช้งาน</th>
								<th scope="col">สถานะ</th>
								<th scope="col">ลบ</th>
							</tr>
						</thead>
						<tbody>
						<?php echo count($listAdmin) == 0 ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : ''; ?>
						<?php foreach($listAdmin as $r): ?>
							<tr class="<?php echo $r['enabled'] == 0 ? 'tr-disabled' : ''; ?>">
								<td scope="row"><?php echo $r['admin_id'];?></td>
								<td></td>
								<td class="<?php echo $r['admin_level']==0 ? 'text-primary' : ''; ?>">
									<?php if($r['admin_level']==0):?>
											ผู้ดูแลระบบ
									<?php elseif($r['admin_level']==1):?>
											ผู้ควบคุมพิเศษ
									<?php endif?>
								</td>
								<td>
									<?php if($r['enabled']==0): ?>
										<a href="<?php echo site_url("admin/toggleEnabled/{$r['admin_id']}/{$r['enabled']}"); ?>" class="text-dark btn-lg" title="ปิดการใช้งาน"><i class="fas fa-toggle-off"></i></a>ปิดการใช้งาน
									<?php elseif($r['enabled']==1): ?>
										<a href="<?php echo $this->session->userdata('username') != $r['admin_id'] ? site_url("admin/toggleEnabled/{$r['admin_id']}/{$r['enabled']}") : '#'; ?>" class="text-success btn-lg" title="เปิดการใช้งาน"><i class="fas fa-toggle-on"></i></a>เปิดการใช้งาน
									<?php endif ?>
								</td>
								<td>
									<?php if($this->session->userdata('username') != $r['admin_id']){ ?>
										<a href="<?php echo site_url("admin/deleteAdmin/{$r['admin_id']}"); ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบผู้ใช้งานนี้หรือไม่?');" title="ลบผู้ใช้งาน"><i class="far fa-trash-alt"></i>
									<?php } ?>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="modal fade" id="addRegistModal" tabindex="-1" role="dialog" aria-labelledby="addRegistLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRegistLabel"><i class="fas fa-plus"></i> เพิ่มผู้ใช้งาน</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form action="<?php echo site_url('admin/addAdmin'); ?>" method="post">
				<div class="modal-body">
					<div class="table-responsive table-borderless">
						<table class="table">
							<tr>
								<td><input type="text" class="form-control form-control-sm" name="admin_id" placeholder="Username" required></td>
								<td>
									<select class="form-control form-control-sm" name="admin_level">
										<option value="0" class="text-primary">ผู้ดูแลระบบ</option>
										<option value="1" selected>ผู้ควบคุมพิเศษ</option>
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


