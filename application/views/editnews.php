<script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">แก้ไขข่าว</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item active" aria-current="page">แก้ไขข่าว</li>
		</ol>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h5 class="panel-title">แก้ไขข่าว</h5>
			</div>
			<hr/>
			<div class="card-body">
				<form method="post" action="<?php site_url('index/editNews'); ?>">
					<textarea class="form-control" id="news" name="news"><?php echo file_get_contents(site_url('assets/file/news.html')); ?></textarea>
					<button type="submit" class="mt-1 btn btn-warning btn-block btn-lg">แก้ไขข่าว</button>
				</form>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<div class="form-inline panel-title">

					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="form-control btn-outline-primary" id="file" name="file" />
							<button type="submit" class="ml-2 btn btn-outline-primary" onclick="uploadFile();">อัพโหลดไฟล์</button>
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-nowrap table-sm table-hover">
						<thead class="bg-primary text-light">
							<tr>
								<td align="center" colspan="3">
									<span class="badge badge-light" id="fileNum"></span>
									<b>รายการไฟล์ที่อัพโหลด</b>
								</td>
							</tr>
						</thead>
						<tbody id="loadFile" class="text-primary"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	let num = 5;
	let all = 0;
	let listFile = [];
	$(function() {
		loadFile();
	})
	CKEDITOR.replace('news');
	function CKupdate() {
		for (instance in CKEDITOR.instances)
			CKEDITOR.instances[instance].updateElement();
	}
	function loadFile() {
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('index/loadFile'); ?>",
		})
		.done(function(result) {
			listFile = JSON.parse(result)
			console.log(listFile)
			randerFile();
		});
	}
	function randerFile() {
		all = listFile.length;
		console.log(listFile)
		let text = '';
		$.each(listFile, function(i) {
			if(i < num) {
				text += '<tr>';
				text += '<td width="1"><a href="#" onclick="deleteFile(\'' + listFile[i] + '\', ' + i + ')" class="text-danger" title="ลบไฟล์"><i class="fas fa-trash-alt"></i></a></td>';
				text += '<td width="1"><button id="btnCopy' + i + '" onclick="copyLink(' + i + ')" class="btnCopy btn btn-outline-primary btn-sm"">คัดลอกลิงก์</button></td>';
				text += '<td id="' + i + '">' + listFile[i] + '</td>';
				text += '</tr>';
			}
		})
		text += text != '' && num < all ? '<tr><td colspan="3"><button class="btn btn-sm btn-block" onclick="plusNum();">...more...</button></td></tr>' : '';
		$('#fileNum').html(all.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' ไฟล์')
		$('#loadFile').html(text != '' ? text : '<tr><td align="center" colspan="3">-ไม่มีข้อมูล-</td></tr>')
	}

	function copyLink(id) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val('<?php echo site_url('assets/file/upload/'); ?>' + $('#' + id).html()).select();
		document.execCommand("copy");
		$temp.remove();

		$('.btnCopy').removeClass('btn-primary');
		$('.btnCopy').addClass('btn-outline-primary');
		$('.btnCopy').html('คัดลอกลิงก์');

		$('#btnCopy' + id).removeClass('btn-outline-primary');
		$('#btnCopy' + id).addClass('btn-primary');
		$('#btnCopy' + id).html('คัดลอกลิงก์แล้ว');
	}
	function uploadFile() {
		var fd = new FormData();
		var files = $('#file')[0].files[0];
		fd.append('file',files);
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('index/uploadFile'); ?>",
			data: fd,
			contentType: false,
			processData: false,
		}).done(function(result) {
			// console.log(result)
			if(result != 0) {
				alert('อัพโหลดไฟล์เรียบร้อยแล้ว');
				loadFile();
			}
			$('#file').val('')
		})
	}
	function plusNum() {
		num += 5;
		randerFile();
	}
	function deleteFile(name, i) {
		if(confirm('ต้องการลบไฟล์นี้หรือไม่?')) {
			$.ajax({
				method: "POST",
				url: "<?php echo site_url('index/deleteFile'); ?>",
				data: {
					name: name
				}
			}).done(function(result) {
				if(result == 1) {
					listFile.splice(i, 1);
					num	-= 1;
					randerFile();
				} else {
					alert('ลบไม่สำเร็จ');
				}
			})
		}
	}
</script>