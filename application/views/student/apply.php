<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">ใบสมัครรอบ <?php echo $regist[0]['regist_term'].'/'.($regist[0]['regist_year'] + 543);?></h1>
		<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">หน้าแรก</a></li>
			<li class="breadcrumb-item"><a href="<?php echo site_url('student/history'); ?>">ประวัติการทำงาน</a></li>
			<li class="breadcrumb-item"><a href="<?php echo site_url('student/working/'.$student[0]['dept_id']); ?>">ข้อมูลนักศึกษา <?php echo $student[0]['student_id']; ?></a></li>
			<li class="breadcrumb-item active" aria-current="page">ใบสมัครรอบ <?php echo $regist[0]['regist_term'].'/'.($regist[0]['regist_year'] + 543);?></li>
		</ol>
	</div>
	<div class="col-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">แบบฟอร์มขอรับทุนการศึกษา</h3>
					</div>
					<hr>
					<div class="panel-body">
                        <div class="table-responsive text-dark">
                            <table class="table table-borderless table-sm table-nowrap">
                                <tr><td colspan="3"><b>ข้อมูลนักศึกษา</b></td></tr>
                                <tr>
                                    <td><?php echo "รหัสนักศึกษา : {$this->session->userdata('username')}"; ?></td>
                                    <td colspan="2"><?php echo "ชื่อ-สกุล : {$this->session->userdata('name')}"; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo "ภาควิชา : วิศวกรรมคอมพิวเตอร์"; ?></td>
                                    <td colspan="2"><?php echo "คณะ : วิศวกรรมศาสตร์"; ?></td>
                                </tr>
                                <tr>
                                    <td width="33%"><?php echo "(GPA) ล่าสุด ภาคการศึกษาที่ : 4.00"; ?></td>
                                    <td width="33%"><?php echo "ปีการศึกษา : 2563"; ?></td>
                                    <td width="33%"><?php echo "เกรดเฉลี่ยสะสม : 3.80"; ?></td>
                                </tr>
                                <tr>
                                    <td class="pt-4">
                                        <label for="mobile">มือถือ:</label>
                                        <input type="text" id="mobile" name="profile[mobile]" maxlength="10" minlength="10" placeholder="0987654321" required>
                                    </td>
                                    <td class="pt-4">
                                        <label for="email">อีเมลล์:</label>
                                        <input type="email" id="email" name="profile[email]" placeholder="email@example.com" required>
                                    </td>
                                    <td class="pt-4">
                                        <label for="bank">เลขบัญชี:</label>
                                        <input type="text" id="bank" name="profile[bank]" placeholder="เลขบัญชี" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="houseno">ภูมิลำเนาบ้านเลขที่:</label>
                                        <input type="text" id="houseno" name="address[houseno]" placeholder="123/4" required size="10">
                                        <label for="moo">หมู่ที่:</label>
                                        <input type="text" id="moo" name="address[moo]" placeholder="-" required size="5">
                                    </td>
                                    <td>
                                        <label for="road">ถนน:</label>
                                        <input type="text" id="road" name="address[road]" placeholder="ถนน" required>
                                    </td>
                                    <td>
                                        <label for="soi">ซอย:</label>
                                        <input type="text" id="soi" name="address[soi]" placeholder="ซอย" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <label for="addrSearch">ตำบล|อำเภอ|จังหวัด|รหัสไปรษณีย์:</label>
                                    </td>
                                    <td colspan="2">
                                        <div class="search-box">
                                            <input type="text" id="addrSearch" class="form-control form-control-sm" placeholder="กรอกชื่อตำบล, อำเภอ, จังหวัด หรื่อ รหัสไปรษณีย์" required autocomplete="off">
                                            <div class="result"></div>
                                            <input type="hidden" name="address[district_id]" id="district_id"/>
                                        </div>
                                </tr>
                                <tr><td colspan="3"><hr/><b>ที่อยู่ปัจจุบันขณะกำลังศึกษาอยู่ในมหาวิทยาลัยสงขลานครินทร์</b></td></tr>
                                <tr>
                                    <td>
                                        <input type="radio" id="rest_id1" name="address[rest_id]" value="1" checked/>
                                        <label for="rest_id1">หอพักมหาวิทยาลัย</label>
                                    </td>
                                    <td>
                                        <input type="radio" id="rest_id2" name="address[rest_id]" value="2"/>
                                        <label for="rest_id2">หอพักคณะพยาบาลศาสตร์</label>
                                    </td>
                                    <td>
                                        <input type="radio" id="rest_id3" name="address[rest_id]" value="3"/>
                                        <label for="rest_id3">หอพักคณะแพทยศาสตร์</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="dorm_name" class="pl-5">ชื่อหอพัก</label>
                                        <input type="text" id="dorm_name" name="address[dorm_name]">
                                        <label for="dorm_room">ห้อง</label>
                                        <input type="text" id="dorm_room" name="address[dorm_room]">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input type="radio" id="rest_id4" name="address[rest_id]" value="4"/>
                                        <label for="rest_id4">หอพักเอกชน</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="pdorm_name" class="pl-5">ชื่อหอพัก</label>
                                        <input type="text" id="pdorm_name" name="address[pdorm_name]">
                                        <label for="pdorm_room">ห้อง</label>
                                        <input type="text" id="pdorm_room" name="address[pdorm_room]">
                                        <label for="pdorm_tel">โทรศัพท์</label>
                                        <input type="text" id="pdorm_tel" maxlength="10" minlength="10" name="address[pdorm_tel]">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input type="radio" id="rest_id5" name="address[rest_id]" value="5"/>
                                        <label for="rest_id5">อื่นๆ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="rest_id5" class="pl-5">(โปรดระบุ)</label>
                                        <input type="text" id="other_rest" name="address[other_rest]" size="100"/>
                                    </td>
                                </tr>
                                <tr><td colspan="3"><hr/><b>รายละเอียดเกี่ยวกับอาชีพและรายได้ของบิดา/มารดา/ผู้อุปการะ</b></td></tr>
                                <tr>
                                    <td>
                                        <label for="fname">บิดา ชื่อ-สกุล</label>
                                        <input type="text" id="fname" name="parent[fname]">
                                    </td>
                                    <td>
                                        <label for="fage">อายุ</label>
                                        <input type="text" id="fage" name="parent[fage]" size="5">
                                        <label for="fage">ปี</label>
                                        <label for="fcareer" class="ml-2">อาชีพ</label>
                                        <input type="text" id="fcareer" name="parent[fcareer]">
                                    </td>
                                    <td>
                                        <label for="fincome">รายได้</label>
                                        <input type="text" id="fincome" name="parent[fincome]">
                                        <label for="fincome"> / ปี</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="mname">มารดา ชื่อ-สกุล</label>
                                        <input type="text" id="mname" name="parent[mname]">
                                    </td>
                                    <td>
                                        <label for="mage">อายุ</label>
                                        <input type="text" id="mage" name="parent[mage]" size="5">
                                        <label for="mage">ปี</label>
                                        <label for="mcareer" class="ml-2">อาชีพ</label>
                                        <input type="text" id="mcareer" name="parent[mcareer]">
                                    </td>
                                    <td>
                                        <label for="mincome">รายได้</label>
                                        <input type="text" id="fincome" name="parent[fincome]">
                                        <label for="fincome"> / ปี</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="pname">ผู้อุปการะ ชื่อ-สกุล</label>
                                        <input type="text" id="pname" name="parent[pname]">
                                    </td>
                                    <td>
                                        <label for="page">อายุ</label>
                                        <input type="text" id="page" name="parent[page]" size="5">
                                        <label for="page">ปี</label>
                                        <label for="pcareer" class="ml-2">อาชีพ</label>
                                        <input type="text" id="pcareer" name="parent[pcareer]">
                                    </td>
                                    <td>
                                        <label for="pincome">รายได้</label>
                                        <input type="text" id="pincome" name="parent[pincome]">
                                        <label for="pincome"> / ปี</label>
                                    </td>
                                </tr>
                                <tr><td colspan="3"><hr/><b>สภาพครอบครัวของบิดา-มารดา</b></td></tr>
                                <tr>
                                    <td>
                                        <input type="radio" id="parent_status1" name="parent[parent_status]"  value="1" checked/>
                                        <label for="parent_status1">อยู่ด้วยกัน</label>
                                    </td>
                                    <td colspan="2">
                                        <input type="radio" id="parent_status2" name="parent[parent_status]"  value="2"/>
                                        <label for="parent_status2">หย่าขาดจากกัน</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" id="parent_status3" name="parent[parent_status]"  value="3"/>
                                        <label for="parent_status3">บิดาถึงแก่กรรม</label>
                                    </td>
                                    <td>
                                        <input type="radio" id="parent_status4" name="parent[parent_status]"  value="4"/>
                                        <label for="parent_status4">มารดาถึงแก่กรรม</label>
                                    </td>
                                    <td>
                                        <input type="radio" id="parent_status5" name="parent[parent_status]"  value="5"/>
                                        <label for="parent_status5">บิดา-มารดาถึงแก่กรรม</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" id="parent_status6" name="parent[parent_status]"  value="6"/>
                                        <label for="parent_status6">แยกกันอยู่ เพราะความจำเป็นเกี่ยวกันอาชีพ</label>
                                    </td>
                                    <td colspan="2">
                                        <input type="radio" id="parent_status7" name="parent[parent_status]"  value="7"/>
                                        <label for="parent_status7">แยกกันอยู่ เพราะสาเหตุอื่น</label>
                                    </td>
                                </tr>
                                <tr><td colspan="3"><hr><b>ที่อยู่อาศัยปัจจุบันของบิดา-มารดา</b></td></tr>
                                <tr>
                                    <td colspan="3">
                                        <input type="radio" id="parent_address1" name="parent[parent_address]" value="1" checked/>
                                        <label for="parent_address1">เป็นของตนเอง</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" id="parent_address2" name="parent[parent_address]" value="2">
                                        <label for="parent_address2">บ้านเช่า</label>
                                    </td>
                                    <td colspan="2">
                                        <input type="radio" id="parent_address3" name="parent[parent_address]" value="3">
                                        <label for="parent_address3">บ้านเช่าซื้อ</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="parent_rent" class="pl-5">อัตราเช่าเดือนละ</label>
                                        <input name="parent[parent_rent]" type="text" id="parent_rent">
                                        <label for="parent_rent">บาท</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <input type="radio" id="parent_address4" name="parent[parent_address]" value="4"/>
                                        <label for="parent_address4">อาศัยผู้อื่นอยู่</label>
                                        (ระบุ) 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="parent_other" class="pl-5">(โปรดระบุ)</label>
                                        <input type="text" id="parent_other" name="parent[parent_other]">		
                                    </td>
                                </tr>
                                <tr><td colspan="3"><hr/><b>นักศึกษาได้รับเงินจาก</b></td></tr>
                                <tr>
                                    <td>1. บิดา-มารดา</td>
                                    <td colspan="2">
                                        <label for="parent_money">เดือนละ</label>
                                        <input type="text" id="parent_money" name="address[parent_money]">
                                        <label for="parent_money">บาท</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2. ผู้อุปการะ</td>
                                    <td colspan="2">
                                        <label for="patron_money">เดือนละ</label>
                                        <input type="text" id="patron_money" name="address[patron_money]">
                                        <label for="patron_money">บาท</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3. เงินกู้ยืมกองทุนรัฐบาล</td>
                                    <td colspan="2">
                                        <label for="loan_money">เดือนละ</label>
                                        <input type="text" id="loan_money" name="address[loan_money]">
                                        <label for="loan_money">บาท</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4. ทำงานพิเศษและอื่นๆ</td>
                                    <td colspan="2">
                                        <label for="extra_money">เดือนละ</label>
                                        <input type="text" id="extra_money" name="address[extra_money]">
                                        <label for="extra_money">บาท</label>
                                    </td>
                                </tr>
                                <tr><td colspan="3"><hr/><b>เหตุผลความจำเป็นที่ขอรับทุนทำงานแลกเปลี่ยน</b></td></tr>
                                <tr>
                                    <td colspan="3">
                                        <textarea id="reason" class="form-control" rows="5" name="address[reason]"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
					</div>
				</div>	  
			</div>	
		</div>	
	</div>
</div>
<?php //print_r($regist); ?>
<?php function displayDate($start, $stop) {
	$m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
	$d1 = date('j', $start);
	$m1 = $m[date('n', $start) - 1];
	$y1 = (date('y', $start) + 43);

	$d2 = date('j', $stop);
	$m2 = $m[date('n', $stop) - 1];
	$y2 = (date('y', $stop) + 43);

	if($y1 != $y2) {
		return "{$d1} {$m1} {$y1} - {$d2} {$m2} {$y2}";
	} else {
		if($m1 != $m2) {
			return "{$d1} {$m1} - {$d2} {$m2} {$y2}";
		} else {
			if($d1 != $d2) {
				return "{$d1} - {$d2} {$m2} {$y2}";
			} else {
				return "ภายในวันที่ {$d2} {$m2} {$y2}";
			}
		}
	}
} ?>
<style type="text/css">
	.search-box{
		position: relative;
		width: 100%;
	}
	.result{
		top: 100%;
		left: 0;
		width: 100%;
		background-color: white;
		position: absolute;
		z-index: 999;
	}
	/* Formatting result items */
	.result p{
		margin: 0;
		padding: 7px 10px;
		border: 1px solid #CCCCCC;
		border-top: none;
		cursor: pointer;
	}
	.result p:hover{
		background: #f2f2f2;
	}
</style>
<script type="text/javascript">
	var afterClick	= false;
	$(document).ready(function(){
		$('#addrSearch').on('keyup', function(e){
			afterClick ? $('#addrSearch').val('') : '';
			$('#addrSearch').addClass('is-invalid')
			afterClick	= false;
			$('#district_id').val('')
			var addr = $(this).val();
			var resultDropdown = $(this).siblings('.result');
			if(addr.length){
				$.get('<?php echo site_url('student/addrSearch'); ?>', {
					addr: addr,
				}).done(function(data){
				 // Display the returned data in browser
				 resultDropdown.html(data);
				});
			} else{
				resultDropdown.empty();
			}
		});
		// Set search input value on click of result item
		$(document).on('click', '.result p', function(){
			afterClick	= true;
			$('#addrSearch').removeClass('is-invalid')
			var str			= $(this).text()
			var addr		= $.trim(str.substring(0, str.lastIndexOf('('))).split(' >> ')
			$('#addrSearch').val('ตำบล' + addr[0] + ' อำเภอ' + addr[1] + ' จังหวัด' + addr[2] + (addr[3] != '-' ? ' ' + addr[3] : ''));
			$(this).parent('.result').empty();
			$('#district_id').val(str.substring(str.lastIndexOf('(') + 1, str.lastIndexOf(')')))
		})
	});
	$('form input').keydown(function (e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			return false;
		}
	});
	$(document).ready(function(){
		var profile	= JSON.parse('<?php echo json_encode($profile); ?>')
		var address	= JSON.parse('<?php echo json_encode($address); ?>')
		var parent	= JSON.parse('<?php echo json_encode($parent); ?>')
		
		if(profile.length > 0) {
			$('#mobile').val(profile[0]['mobile'])
			$('#email').val(profile[0]['email'])
			$('#bank').val(profile[0]['bank'])
		}
			
		if(address.length > 0) {
			$.each(address = address[0], function(i, v) {
				$('#' + i).val(v)
			})
			$('#rest_id' + address['rest_id']).prop('checked', true)
			$('#addrSearch').val('ตำบล' + address['district_name'] + ' อำเภอ' + address['amphure_name'] + ' จังหวัด' + address['province_name'] + (address['zip_code'] != null ? ' ' + address['zip_code'] : ' -'))
		}

		if(parent.length > 0) {
			$.each(parent = parent[0], function(i, v) {
				$('#' + i).val(v)
			})
			$('#parent_status' + parent['parent_status']).prop('checked', true)
			$('#parent_address' + parent['parent_address']).prop('checked', true)
		}
	})
</script>