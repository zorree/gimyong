<style>

    .top {
        top:10%
    }

    .goods {
        width: 50px;
        height: 50px;
    }

    .addgoods {
        width: 100%;
        height: 100px;
    }

</style>

<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">สินค้าแนะนำ</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item">สินค้าแนะนำ</a></li>
		</ol>
	</div>
    

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h3 class="m-0 font-weight-bold text-primary">
                    สินค้าแนะนำ
				</h3>
			</div>
			<div class="card-body">
                <div class="my-3"><h5 id="addHow">สินค้าแนะนำ</h5></div>
                <div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>รูปภาพ</th>
								<th>ชื่อสินค้า</th>
                                <th>ราคา</th>
							</tr>
						</thead>
						<tbody id="Rgoods">
							<?php echo count($Rgoods) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($Rgoods as $r){ ?>
								<tr>
                                    <td class="align-middle"><?php echo ++$num;?></td>
                                    <td class="align-middle"><img src="<?php echo site_url('assets/img/goods/'.$r['g_img']); ?>" class="rounded goods"></td>
                                    <td class="align-middle"><?=$r['g_name'];?></td>
									<td class="align-middle"><?=$r['g_price'];?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
                <div class="my-3"><h5>สินค้าธรรมดา</h5></div>
                <div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead id="tgoods">
							<tr>
								<th>#</th>
								<th>รูปภาพ</th>
								<th>ชื่อสินค้า</th>
                                <th>ราคา</th>
							</tr>
						</thead>
						<tbody id="goods">
							<?php echo count($goods) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($goods as $r){ ?>
								<tr>
                                    <td class="align-middle"><?php echo ++$num;?></td>
                                    <td class="align-middle"><img src="<?php echo site_url('assets/img/goods/'.$r['g_img']); ?>" class="rounded goods"></td>
                                    <td class="align-middle"><?=$r['g_name'];?></td>
									<td class="align-middle"><?=$r['g_price'];?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>