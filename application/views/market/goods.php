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
            <div class="card-header py-3 d-flex justify-content-center justify-content-xl-start">
				<h6 class="m-0">
					<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#addgoodsModal"><i class="fas fa-plus"></i> เพิ่มสินค้าแนะนำ</button>
				</h6>
			</div>
			<div class="card-body">
                <div class="my-3"><h5 id="addHow">สินค้าแนะนำ เพิ่มได้อีก <?=10-count($Rgoods)?> ชิ้น</h5></div>
                <div class="table-responsive">	
					<table class="table table-nowrap table-bordered text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>รูปภาพ</th>
								<th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th style="width:10%">ลบออกจากสินค้าแนะนำ</th>
								<th>แก้ไข</th>
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
									<td class="align-middle">
                                        <button type="button" class="btn btn-sm btn-warning" onclick="daleteRgoods(<?=$r['g_id']?>)"><i class="fas fa-minus-circle"></i></button>
                                    </td>
									<td class="align-middle">
                                        <div class='d-flex justify-content-center'>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(<?=$r['g_id']?>)">แก้ไข</button>
                                            <form action="<?php echo site_url('market/deletegoods');?>" method="post">
                                                <button type="submit" class="btn btn-sm btn-danger ml-2" name="submit" value="<?=$r['g_img']?>" onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">ลบ</button>
                                            </form>
                                        </div>
                                    </td>
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
                                <?php if(count($Rgoods) < 10) : ?>
                                    <th style="width:10%">เพิ่มเป็นสินค้าแนะนำ</th>
                                <?php endif ?>
								<th>แก้ไข</th>
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
                                    <?php if(count($Rgoods) < 10) : ?>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-sm btn-warning" onclick="addRgoods(<?=$r['g_id']?>)"><i class="fas fa-plus-circle"></i></button>
                                        </td>
                                    <?php endif ?>
									<td class="align-middle">
                                        <div class='d-flex justify-content-center'>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(<?=$r['g_id']?>)">แก้ไข</button>
                                            <form action="<?php echo site_url('market/deletegoods');?>" method="post">
                                                <button type="submit" class="btn btn-sm btn-danger ml-2" name="submit" value="<?=$r['g_img']?>" onclick="return confirm('ต้องการลบสินค้านี้หรือไม่?');">ลบ</button>
                                            </form>
                                        </div>
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

<div class="modal fade" id="addgoodsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addgoodsLabel"><i class="fas fa-plus"></i> เพิ่มสินค้าแนะนำ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('market/addgoods'); ?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <img class="d-none" id="previewImg" src="" alt="Placeholder">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 text-right">รูปภาพ</div>
                            <div class="col-6">
                                <input type="file" name="picture" id="fileToUpload" onchange="previewFile(this);" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3 text-right">ชื่อสินค้า</div>
                            <div class="col-6">
                                <input class="form-control form-control-sm" name="goodsname"  type="text" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-3 text-right">ราคา</div>
                            <div class="col">
                                <input class="form-control form-control-sm" name="goodsprice"  type="number" required>
                            </div>
                            <div class="col-3">บาท</div>
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

    function addRgoods(input){
        console.log(input)
        var url = '<?php echo site_url('market/addRgoods/'); ?>';
		var req = new XMLHttpRequest();
		req.open('POST', url, true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.onload = function() {
			var json = JSON.parse(req.response);
            Rgoods(json.Rgoods)
            goods(json)
            if (json.Rgoods.length === 10) {
                document.getElementById("addHow").innerHTML = 'สินค้าแนะนำ เต็มแล้ว'
            } else {
                document.getElementById("addHow").innerHTML = 'สินค้าแนะนำ เพิ่มได้อีก ' + (10-json.Rgoods.length) + ' ชิ้น'
            }
		};
		req.send("data="+input);
    }

    function daleteRgoods(input){
        console.log(input)
        var url = '<?php echo site_url('market/daleteRgoods/'); ?>';
		var req = new XMLHttpRequest();
		req.open('POST', url, true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.onload = function() {
			var json = JSON.parse(req.response);
            Rgoods(json.Rgoods)
            goods(json)
            if (json.Rgoods.length === 10) {
                document.getElementById("addHow").innerHTML = 'สินค้าแนะนำ เต็มแล้ว'
            } else {
                document.getElementById("addHow").innerHTML = 'สินค้าแนะนำ เพิ่มได้อีก ' + (10-json.Rgoods.length) + ' ชิ้น'
            }
		};
		req.send("data="+input);
    }

    function Rgoods(input){
        console.log(input)
        if (input.length != 0) {
				var num = 0
				var type
				var text = ''
				for (i = 0; i < input.length; i++) {

					text += 
                        '<tr>' +
                            '<td class="align-middle">' + (++num) + '</td>' +
                            '<td class="align-middle"><img src="<?php echo site_url('assets/img/goods/'); ?>' + input[i]['g_img'] + '" class="rounded goods"></td>' +
                            '<td class="align-middle">' + input[i]['g_name'] + '</td>' +
							'<td class="align-middle">' + input[i]['g_price'] + '</td>' +
							'<td class="align-middle">' +
                                '<button type="button" class="btn btn-sm btn-warning" onclick="daleteRgoods(' + input[i]['g_id'] + ')"><i class="fas fa-minus-circle"></i></button>' +
                            '</td>' +
							'<td class="align-middle">' +
                                '<div class="d-flex justify-content-center">' +
                                    '<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(' + input[i]['g_id'] + ')">แก้ไข</button>' +
                                    '<form action="<?php echo site_url('market/deletegoods');?>" method="post">' +
                                        '<button type="submit" class="btn btn-sm btn-danger ml-2" name="submit" value="' + input[i]['g_id'] + '" onclick="return confirm("ต้องการลบสินค้านี้หรือไม่?");">ลบ</button>' + 
                                    '</form>' +
                                '</div>' +
                            '</td>' +
						'</tr>'
					;
				}
				document.getElementById("Rgoods").innerHTML = text
			} else {
				document.getElementById("Rgoods").innerHTML = "<td colspan='6'>-ไม่มีข้อมูล-</td>";
		}
    }

    function goods(input){
        console.log(input)
        if (input.goods.length != 0) {
				var num = 0
				var type
				var text = ''
                var addButton

                if (input.Rgoods.length < 10) {
                    document.getElementById("tgoods").innerHTML = '<tr><th>#</th><th>รูปภาพ</th><th>ชื่อสินค้า</th><th>ราคา</th><th style="width:10%">เพิ่มเป็นสินค้าแนะนำ</th><th>แก้ไข</th></tr>'
                } else {
                    document.getElementById("tgoods").innerHTML = '<tr><th>#</th><th>รูปภาพ</th><th>ชื่อสินค้า</th><th>ราคา</th><th>แก้ไข</th></tr>'
                }
                
				for (i = 0; i < input.goods.length; i++) {
                    if (input.Rgoods.length < 10) {
                        addButton = '<td class="align-middle">' +
                                        '<button type="button" class="btn btn-sm btn-warning" onclick="addRgoods(' + input.goods[i]['g_id'] + ')"><i class="fas fa-plus-circle"></i></button>'
                                    '</td>'
                    } else {
                        addButton = ''
                    }
					text += 
                        '<tr>' +
                            '<td class="align-middle">' + (++num) + '</td>' +
                            '<td class="align-middle"><img src="<?php echo site_url('assets/img/goods/'); ?>' + input.goods[i]['g_img'] + '" class="rounded goods"></td>' +
                            '<td class="align-middle">' + input.goods[i]['g_name'] + '</td>' +
							'<td class="align-middle">' + input.goods[i]['g_price'] + '</td>' +
                            addButton +
							'<td class="align-middle">' +
                                '<div class="d-flex justify-content-center">' +
                                    '<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editgoodsModal" onclick="showData(' + input.goods[i]['g_id'] + ')">แก้ไข</button>' +
                                    '<form action="<?php echo site_url('market/deletegoods');?>" method="post">' +
                                        '<button type="submit" class="btn btn-sm btn-danger ml-2" name="submit" value="' + input.goods[i]['g_id'] + '" onclick="return confirm("ต้องการลบสินค้านี้หรือไม่?");">ลบ</button>' + 
                                    '</form>' +
                                '</div>' +
                            '</td>' +
						'</tr>'
					;
				}
				document.getElementById("goods").innerHTML = text
			} else {
				document.getElementById("goods").innerHTML = "<td colspan='6'>-ไม่มีข้อมูล-</td>";
		}
    }

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
