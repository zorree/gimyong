<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="./../assets/img/logo/store.png" rel="icon">
  <title>GIMYONG WEBSITE</title>
  <?php $this->load->view('include/meta'); ?>

</head>

<style>

  #map {
    height: 300px;
  }

</style>

<body class="bg-gradient-login">
  <!-- Register Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <!-- <h1 class="h4 mb-4">Register </h1> -->
                    <h1 class="h4 mb-4">ลงทะเบียน <i class="fas fa-user-plus"></i></h1>
                  </div>
                  <div class="col-12 px-0 mt-0 mb-4 d-flex justify-content-around">
                    <button class="btn btn-outline-primary col-5 active" id="btCustomer"   onclick="showCustomerdiv()">ผู้ซื้อ</button>
                    <button class="btn btn-outline-warning col-5" id="btMarket"     onclick="showMarketdiv()">ผู้ขาย</button>
                  </div>
                  <form action="<?php echo site_url("index/registerCheck");?>" method="post" class="" id="formCustomer">
                    <div class="text-center">
                      <h1 class="h5">สำหรับผู้ซื้อ <i class="fas fa-street-view"></i></h1>
                    </div>
                    <div class="form-group">
                      <!-- <label>Username</label> -->
                      <label>ชื่อผู้ใช้งาน</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" onkeyup="checkCustomerUser(this.value)" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="outUsername"></small>
                    </div>
                    <div class="form-group">
                      <!-- <label>Password</label> -->
                      <label>รหัสผ่าน</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" onkeyup="checkCustomerPassword()" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="outPassword"></small>
                    </div>
                    <div class="form-group">
                      <!-- <label>Confirm Password</label> -->
                      <label>ยืนยันรหัสผ่าน</label>
                      <input type="password" class="form-control" name="conPassword" id="conPassword" placeholder="Confirm Password" onkeyup="checkCustomerPassword()" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="outCPassword"></small>
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showCustomerPassword()">
                      <!-- <label class="form-check-label" for="exampleCheck1">Show Password</label> -->
                      <label class="form-check-label" for="exampleCheck1">แสดงรหัสผ่าน</label>
                    </div>
                    <div class="form-group">
                      <label>ชื่อ</label>
                      <input type="text" class="form-control" name="cname"  required>
                    </div>
                    <div class="form-group">
                      <label>นามสกุล</label>
                      <input type="text" class="form-control" name="clname" required>
                    </div>
                    <!-- <div class="form-group">
                      <label>First Name</label>
                      <input type="text" class="form-control" id="exampleInputFirstName" name="firstname" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" class="form-control" id="exampleInputLastName" name="lastname" placeholder="Enter Last Name" required>
                    </div> -->
                    <!-- <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" required>
                    </div> -->
                    <div class="form-group">
                      <!-- <button type="submit" class="btn btn-primary btn-block" id="Csubmit" name="submit" value="1" disabled>Register</button> -->
                      <button type="submit" class="btn btn-primary btn-block" id="Csubmit" name="submit" value="1" disabled>ลงทะเบียน</button>
                    </div>
                    <!-- <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a> -->
                  </form>
                  <form action="<?php echo site_url("index/registerCheck");?>" method="post" class="d-none" id="formMarket" name="level" value="1">
                    <div class="text-center">
                      <h1 class="h5">สำหรับผู้ขาย <i class="fas fa-store"></i></h1>
                    </div>
                    <div class="form-group">
                      <label>ชื่อผู้ใช้งาน</label>
                      <input type="text" class="form-control" name="username" id="mUsername" placeholder="Username" onkeyup="checkMarketuser(this.value)" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="moutUsername"></small>
                    </div>
                    <div class="form-group">
                      <label>รหัสผ่าน</label>
                      <input type="password" class="form-control" name="password" id="mpassword" placeholder="Password" onkeyup="checkMarketPassword()" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="moutPassword"></small>
                    </div>
                    <div class="form-group">
                      <label>ยืนยันรหัสผ่าน</label>
                      <input type="password" class="form-control" name="conPassword" id="mconPassword" placeholder="Confirm Password" onkeyup="checkMarketPassword()" required>
                      <small class="d-flex justify-content-end text-danger pt-2" id="moutCPassword"></small>
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showMarketPassword()">
                      <label class="form-check-label" for="exampleCheck1">แสดงรหัสผ่าน</label>
                    </div>
                    <div class="form-group">
                      <label>ชื่อเจ้าของร้าน</label>
                      <input type="text" class="form-control" name="mname" id="mname" required>
                    </div>
                    <div class="form-group">
                      <label>นามสกุล</label>
                      <input type="text" class="form-control" name="mlname" id="mlname" required>
                    </div>
                    <div class="form-group">
                      <label>ชื่อร้าน</label>
                      <input type="text" class="form-control" name="mmarketname" id="mmarketname" equired>
                    </div>
                    <div class="form-group">
                      <label>ประเภทร้าน</label>
                      <select class="form-control" name="mtype">
                        <option selected disabled>เลือกประเภทร้าน</option>
                        <option value="1" >เสื้อผ้า</option>
                        <option value="2" >อาหาร</option>
                        <option value="3" >ของฝาก</option>
                        <option value="4" >เครื่องใช้ไฟฟ้า</option>
                        <option value="5" >ผลไม้</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>พิกัตร้าน</label>
                      <div class="bg-dark">
                        <div class="border border-dark rounded" id="map">
                          <div class="position-relative d-flex justify-content-center p-2" style="z-index: 1;">
                            <button type="button" class="btn-sm btn-success form-control" id="markgps">GPS</button>
                            <button type="button" class="ml-2 btn-sm btn-primary form-control" id="markchoose">เลือกจุดเอง</button>
                            <button type="button" class="d-none" id="mychoose">เลือกจุดนี้</button>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex">
                        <input type="text" class="form-control" name="mlong"  id="mlong"  required>
                        <input type="text" class="form-control" name="mlat"   id="mlat"   required>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" id="Msubmit" name="submit" value="2" disabled>ลงทะเบียน</button>
                    </div>
                    <!-- <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a> -->
                  </form>
                  <hr>
                  <div class="text-center">
                    <!-- <a class="font-weight-bold small" href="<?php echo site_url(""); ?>">Already have an account?</a> -->
                    <a class="font-weight-bold small" href="<?php echo site_url(""); ?>">มีบัญชีอยู่แล้ว ?</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Register Content -->
  <?php $this->load->view('include/script'); ?>
  
</body>
</html>

<script>
  // id buttom
  var btCustomer      = document.getElementById("btCustomer");
  var btMarket        = document.getElementById("btMarket");
  // id form
  var formCustomer    = document.getElementById("formCustomer");
  var formMarket      = document.getElementById("formMarket");
  // id customer from detail
  var username        = document.getElementById("username");
  var outUsername     = document.getElementById("outUsername");
  var password        = document.getElementById("password");
  var outPassword     = document.getElementById("outPassword");
  var conPassword     = document.getElementById("conPassword");
  var outCPassword    = document.getElementById("outCPassword");
  // id market from detail
  var mUsername       = document.getElementById("mUsername");
  var moutUsername    = document.getElementById("moutUsername");
  var mpassword       = document.getElementById("mpassword");
  var moutPassword    = document.getElementById("moutPassword");
  var mconPassword    = document.getElementById("mconPassword");
  var moutCPassword   = document.getElementById("moutCPassword");

  // id choose marker
  var markgps         = document.getElementById("markgps");
  var markchoose      = document.getElementById("markchoose");
  var mychoose        = document.getElementById("mychoose");
  var mlong           = document.getElementById("mlong");
  var mlat            = document.getElementById("mlat");
  var choosecheck     = false;

  // var long 	= 100.800128
	// var lat 	= 6.942084
  var long 	= 100.469789
	var lat 	= 7.008181
  mapboxgl.accessToken = 'pk.eyJ1Ijoiem9ycmVlbmF0IiwiYSI6ImNrOW84Y2FteTA5b3MzbXA3cWN0eHVoemcifQ.yIvdBJcVxhwb3Yn3h5vYJQ';
	var map = new mapboxgl.Map({
		container: 'map', // container ID
		style: 'mapbox://styles/mapbox/streets-v11', // style URL
		center: [long, lat], // starting position [lng, lat]
		zoom: 16.5,
		testMode: true
	});

	var markercheck	= new mapboxgl.Marker({color: '#66bb6a'})

  markgps.onclick = function() {
		navigator.geolocation.getCurrentPosition(function (position) {
			map.setCenter([position.coords.longitude, position.coords.latitude]);
			markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
      mlong.value      = map.getCenter().lng.toFixed(6)
      mlat.value       = map.getCenter().lat.toFixed(6)
		})
	}

  markchoose.onclick = function() {
		choosecheck = !choosecheck;
    if(choosecheck) {
      markgps.className       = "d-none";
      markchoose.className    = "d-none";
      mychoose.className      = "btn-sm btn-success form-control mx-5";
      markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)]).addTo(map)
    }
	}

  mychoose.onclick = function() {
		choosecheck = !choosecheck;
    markgps.className       = "btn-sm btn-success form-control";
    markchoose.className    = "ml-2 btn-sm btn-primary form-control";
    mychoose.className      = "d-none";
	}

  map.on('load', function () {
		// Add a data source containing GeoJSON data.
		map.addSource('maine', {
			'type': 'geojson',
			'data': '<?php echo site_url("assets/map/gimyong.geojson"); ?>'
		})

		// Add a new layer to visualize the polygon.
		map.addLayer({
			'id': 'maine',
			'type': 'fill',
			'source': 'maine', // reference the data source
			'layout': {},
			'paint': {
				'fill-color': '#0080ff', // blue color fill
				'fill-opacity': 0.5
			}
		});

		// Add a black outline around the polygon.
		map.addLayer({
			'id': 'outline',
			'type': 'line',
			'source': 'maine',
			'layout': {},
			'paint': {
				'line-color': '#000',
				'line-width': 1
			}
		});
	})

  map.on('move', (e) => {
    if (choosecheck){
      mlong.value      = map.getCenter().lng.toFixed(6)
      mlat.value        = map.getCenter().lat.toFixed(6)
      markercheck.setLngLat([map.getCenter().lng.toFixed(6), map.getCenter().lat.toFixed(6)])
    }
  });


  // customer detail
  function showCustomerdiv() {
    formMarket.classList.add("d-none");
    formCustomer.classList.remove("d-none");
    btCustomer.classList.add("active");
    btMarket.classList.remove("active");
  }

  function checkCustomerUser(str) {
    if (str.length == 0) {
      username.className    = "form-control";
      outUsername.innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText === "") {
            outUsername.innerHTML = this.responseText;
            username.classList.remove("is-invalid");
            username.classList.add("is-valid");
            document.getElementById('Csubmit').disabled = false;
          } else {
            outUsername.innerHTML = this.responseText;
            username.classList.remove("is-valid");
            username.classList.add("is-invalid");
            document.getElementById('Csubmit').disabled = true;
          }
        } else {
          username.classList.remove("is-valid");
          username.classList.remove("is-invalid");
        }
      }
      xmlhttp.open("GET", "<?php echo site_url("index/usercheck/"); ?>" + str , true);
      xmlhttp.send();
    }
  }

  function checkCustomerPassword() {
    if (password.value.length == 0 && conPassword.value.length == 0) {
      password.className    = "form-control";
      conPassword.className = "form-control";
      outPassword.innerHTML = "";
      outCPassword.innerHTML = "";
      return;
    } else {
      if (password.value.length >= 8) {
        if (conPassword.value.length == 0) {
          conPassword.className = "form-control";
          password.classList.remove("is-invalid");
          outPassword.innerHTML = "";
        } else {
          if (password.value == conPassword.value) {
            password.className    = "form-control is-valid";
            conPassword.className = "form-control is-valid";
            outCPassword.innerHTML = "";
            outPassword.innerHTML = "";
            document.getElementById('Csubmit').disabled = false;
          } else {
            password.className    = "form-control is-invalid";
            conPassword.className = "form-control is-invalid";
            outCPassword.innerHTML = "กรอกรหัสผ่านให้ตรงกัน";
            document.getElementById('Csubmit').disabled = true;
          }
        }
      } else {
        password.className    = "form-control is-invalid";
        conPassword.className = "form-control";
        outPassword.innerHTML = "รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร";
        document.getElementById('Csubmit').disabled = true;
      }  
    }
  }

  function showCustomerPassword() {
    if (password.type === "password" && conPassword.type === "password") {
      password.type = "text";
      conPassword.type = "text";
    } else {
      password.type = "password";
      conPassword.type = "password";
    }
  }

  function showMarketdiv() {
    formCustomer.classList.add("d-none");
    formMarket.classList.remove("d-none");
    btCustomer.classList.remove("active");
    btMarket.classList.add("active");
  }

  function checkMarketuser(str) {
    if (str.length == 0) {
      mUsername.className    = "form-control";
      moutUsername.innerHTML = ""
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText === "") {
            moutUsername.innerHTML = this.responseText;
            mUsername.classList.remove("is-invalid");
            mUsername.classList.add("is-valid");
            document.getElementById('Msubmit').disabled = false;
          } else {
            moutUsername.innerHTML = this.responseText;
            mUsername.classList.add("is-invalid");
            document.getElementById('Msubmit').disabled = true;
          }
        } else {
          mUsername.classList.remove("is-valid");
          mUsername.classList.remove("is-invalid");
        }
      }
      xmlhttp.open("GET", "<?php echo site_url("index/musercheck/"); ?>" + str , true);
      xmlhttp.send();
    }
  }

  function checkMarketPassword() {
    if (mpassword.value.length == 0 && mconPassword.value.length == 0) {
      mpassword.className    = "form-control";
      mconPassword.className = "form-control";
      moutPassword.innerHTML = ""
      moutCPassword.innerHTML = ""
      return;
    } else {
      if (mpassword.value.length >= 8) {
        if (mconPassword.value.length == 0) {
          mconPassword.className = "form-control";
          mpassword.classList.remove("is-invalid");
          moutPassword.innerHTML = ""
        } else {
          if (mpassword.value == mconPassword.value) {
            mpassword.className    = "form-control is-valid";
            mconPassword.className = "form-control is-valid";
            moutCPassword.innerHTML = ""
            moutPassword.innerHTML = ""
            document.getElementById('Msubmit').disabled = false;
          } else {
            mpassword.className    = "form-control is-invalid";
            mconPassword.className = "form-control is-invalid";
            moutCPassword.innerHTML = "กรอกรหัสผ่านให้ตรงกัน";
            document.getElementById('Msubmit').disabled = true;
          }
        }
      } else {
        mpassword.className    = "form-control is-invalid";
        mconPassword.className = "form-control";
        moutPassword.innerHTML = "รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร";
        document.getElementById('Msubmit').disabled = true;
      }  
    }
  }

  function showMarketPassword() {
    if (mpassword.type === "password" && mconPassword.type === "password") {
      mpassword.type = "text";
      mconPassword.type = "text";
    } else {
      mpassword.type = "password";
      mconPassword.type = "password";
    }
  }
  
</script>
