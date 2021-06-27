<style>

	img.w {
		width: 350px;
	}

	.top {
        top:10%
    }

	.head {
        width: 300px;
        height: 300px;
    }

	.addcimg {
        width: 100%;
        height: 100px;
    }

	@media screen and (max-width: 480px) {
		.head {
            width: 150px;
            height: 150px;
        }
	}

</style>
<!-- <div class="container-fluid" id="container-wrapper"> -->
<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">รายละเอียดลูกค้า</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo site_url('admin/customer'); ?>">ลูกค้า</a></li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียดลูกค้า</li>
		</ol>
	</div>

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3">
				<h4 class="font-weight-bold text-primary">
                    รายละเอียดลูกค้า
				</h4>
			</div>
			<div class="card-body">
				<div class="row text-center">
                    <div class="col-sm">
						<?php if ($customerdetail[0]['c_img'] != ''): ?>
                            <img src="<?php echo site_url('assets/img/customer/'.$customerdetail[0]['c_img']); ?>" class="img-thumbnail head">
                        <?php else: ?>
                            <img src="<?php echo site_url('assets/img/boy.png'); ?>" class="img-thumbnail head">
                        <?php endif; ?>
					</div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-lg-5 d-flex justify-content-end">
                      	<b>ชื่อ :</b> 
                    </div>
					<div class="col">
                        <?=$customerdetail[0]['c_name']?> <?=$customerdetail[0]['c_lname']?>
                    </div>
                </div>
                
                <div class="row mt-3 text-center">
                    <div class="col">
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editgoodsModal">แก้ไขข้อมูล</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editgoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editgoodLabel"><i class="fas fa-plus"></i> แก้ไข</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				<form action="<?php echo site_url('admin/editcustomer'); ?>" method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="cid" value="<?=$customerdetail[0]['c_id']?>">
					<div class="modal-body">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-6">
								<?php if ($customerdetail[0]['c_img']) : ?>
								<img class="addcimg mb-3" id="previewImg" src="<?php echo site_url('assets/img/customer/'.$customerdetail[0]['c_img']); ?>" alt="Placeholder">
								<?php else : ?>
								<img class="addcimg mb-3" id="previewImg" src="" alt="Placeholder">
								<?php endif ?>
							</div>
						</div>
						<div class="row">
							<div class="col-3 text-right">รูปภาพ</div>
							<div class="col-6">
								<input type="file" name="picture" id="fileToUpload" onchange="previewFile(this);">
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-3 text-right">ชื่อ</div>
							<div class="col-6">
								<input class="form-control form-control-sm"	id="cname"	name="cname"	type="text"	value="<?=$customerdetail[0]['c_name']?>"	required>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-3 text-right">นามสกุล</div>
							<div class="col-6">
								<input class="form-control form-control-sm"	id="clname"	name="clname"	type="text"	value="<?=$customerdetail[0]['c_lname']?>"	required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload Image">แก้ไข</button>
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
						</div>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>

<script>

	function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }

</script>
