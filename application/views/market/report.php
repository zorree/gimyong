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

    .comment {
		width: 70px;
        height: 70px;
	}

    @media screen and (max-width: 480px) {
		.comment {
			width: 50px;
			height: 50px;
		}
	}

</style>

<div class="col-12" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-2">
		<h1 class="h3 mb-0 text-gray-800">ความคิดเห็น</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item">ความคิดเห็น</a></li>
		</ol>
	</div>
    

	<div class="col-12 p-0">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h3 class="m-0 font-weight-bold text-primary">
                    ความคิดเห็น
				</h3>
			</div>
			<div class="card-body">
                <div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>รูปภาพ</th>
								<th>ความคิดเห็น</th>
							</tr>
						</thead>
						<tbody>
							<?php echo count($report) == 0 ? '<td colspan="5">-ไม่มีข้อมูล-</td>' : ''; ?>
							<?php $num = 0;
							foreach($report as $r){ ?>
								<tr>
                                    <td class="align-middle" style='width: 10%;'><?=++$num?></td>
                                    <td class="align-middle" style='width: 15%;'>
                                    <?php if ($r['c_img'] != ''): ?>
                                        <img src="<?php echo site_url('assets/img/customer/'.$r['c_img']); ?>" class="comment">
                                    <?php else: ?>
                                        <img src="<?php echo site_url('assets/img/boy.png'); ?>" class="comment">
                                    <?php endif; ?>    
                                    </td>
                                    <td class="align-middle"><?=$r['r_comment']?></td>
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
                <h5 class="modal-title" id="editgoodLabel"><i class="fas fa-plus"></i> แก้ไข</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">
            <form action="<?php echo site_url('market/editgoods'); ?>" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <img class="addgoods mb-3" id="previewImgedit" src="" alt="Placeholder">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 text-right">รูปภาพ</div>
                        <div class="col-6">
                            <input type="file" name="picture1" id="fileToUpload1" onchange="previewFileedit(this);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3 text-right">ชื่อสินค้า</div>
                        <div class="col-6">
                            <input class="form-control form-control-sm" id="goodsname" name="goodsname"  type="text" required>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-3 text-right">ราคา</div>
                        <div class="col">
                            <input class="form-control form-control-sm" id="goodsprice" name="goodsprice"  type="number" required>
                        </div>
                        <div class="col-3">บาท</div>
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

<script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
                $("#previewImg").removeClass("d-none");
                $("#previewImg").addClass("addgoods mb-3");
            }
 
            reader.readAsDataURL(file);
        }
    }

    function previewFileedit(input){
        var file= input.files[0];
        var reader  = new FileReader();
        reader.addEventListener("load", function () {
            $("#previewImgedit").attr("src", reader.result);
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function showData(num) {
        console.log(num)
        var url = '<?php echo site_url('market/showgoods/'); ?>' + num;
		var req = new XMLHttpRequest();
		req.open('GET', url, true);
		req.onload = function() {
			var json = JSON.parse(req.response);
            console.log(json)
            document.getElementById("previewImgedit").src   = "<?php echo site_url('assets/img/goods/');?>" + json[0]['g_img'];
            document.getElementById("goodsname").value      = json[0]['g_name'];
            document.getElementById("goodsprice").value     = json[0]['g_price'];
            document.getElementById("goodsprice").value     = json[0]['g_price'];
            document.getElementById("id").value             = json[0]['g_id'];
		};
		req.send();
    }
</script>
