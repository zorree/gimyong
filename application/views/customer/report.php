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
		<h1 class="h3 mb-0 text-gray-800">คอมเมนต์</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item">คอมเมนต์</a></li>
		</ol>
	</div>
    

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h3 class="m-0 font-weight-bold text-primary">
                    คอมเมนต์
				</h3>
			</div>
			<div class="card-body">
                <div class="my-3"><h5 id="addHow">คอมเมนต์</h5></div>
                <div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>ร้านค้า</th>
								<th>คอมเมนต์</th>
                                <th>แก้ไข</th>
							</tr>
						</thead>
						<tbody id="Rgoods">
							<?php echo count($report) == 0 ? '<td colspan="6">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($report as $r){ ?>
								<tr>
                                    <td class="align-middle"><?php echo ++$num;?></td>
                                    <td class="align-middle">
                                        <?php if ($r['m_img'] != ''): ?>
                                            <img src="<?php echo site_url('assets/img/market/'.$r['m_img']); ?>" class="rounded goods">
                                        <?php else: ?>
                                            <img src="<?php echo site_url('assets/img/logo/store.png'); ?>" class="rounded goods">
                                        <?php endif; ?>
                                        <br>
                                        <?=$r['m_shopname'];?>
                                    </td>
									<td class="align-middle text-left"><?=$r['r_comment'];?></td>
									<td class="align-middle">
                                        <form action="<?php echo site_url('customer/deletereport');?>" method="post">
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(<?=$r['r_id']?>)">แก้ไข</button>
                                            <button type="submit" class="btn btn-sm btn-danger" name="submit" value="<?=$r['r_id']?>" onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">ลบ</button>
                                        </form>
                                    </td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editgoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addgoodsLabel">แก้ไขคอมเมนต์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('customer/editreport'); ?>" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3 text-right">ร้าน</div>
                            <div class="col-6">
                                <span id="shopname"></span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-3 text-right">คอมเมนต์</div>
                            <div class="col-6">
                                <textarea class="form-control" id="comment" rows="5" name="comment" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload Image">บันทึก</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showData(num) {
        console.log(num)
        var url = '<?php echo site_url('customer/showreport/'); ?>' + num;
		var req = new XMLHttpRequest();
		req.open('GET', url, true);
		req.onload = function() {
			var json = JSON.parse(req.response);
            console.log(json.report)
            document.getElementById("id").value         = json.report[0]['r_id'];
            document.getElementById("shopname").innerHTML   = json.report[0]['m_shopname'];
            document.getElementById("comment").value    = json.report[0]['r_comment'];
		};
		req.send();
    }
</script>