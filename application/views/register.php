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
  .container i {
    margin-left: -30px;
    cursor: pointer;
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
                    <h1 class="h4 mb-4">Register </h1>
                  </div>
                  <div class="col-12 px-0 mt-0 mb-4 d-flex justify-content-around">
                    <button class="btn btn-outline-primary col-5 active" id="btCustomer"   onclick="showCustomerdiv()">ทั่วไป</button>
                    <button class="btn btn-outline-warning col-5" id="btMarket"     onclick="showMarketdiv()">ร้านค้า</button>
                  </div>
                  <form action="<?php echo site_url("index/registerCheck");?>" method="post" class="" id="formCustomer">
                    <div class="text-center">
                      <h1 class="h5">ทั่วไป</h1>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" onkeyup="checkCustomerUser(this.value)" required>
                    </div>
                    <div class="form-group m-0 text-right">
                      <label class="form-group d-none m-0" id="outUsername"></label>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <!-- <input type="password" class="form-control" name="password" id="password" placeholder="Password" onkeyup="checkCustomerPassword()" required> -->
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <!-- <input type="password" class="form-control" name="conPassword" id="conPassword" placeholder="Confirm Password" onkeyup="checkCustomerPassword()" required> -->
                    </div>
                    <div class="form-group m-0 text-right">
                      <label class="form-group d-none m-0" id="outPassword"></label>
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showCustomerPassword()">
                      <label class="form-check-label" for="exampleCheck1">Show Password</label>
                    </div>
                    <div class="form-group">
                      <label>First Name</label>
                      <!-- <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter First Name" required> -->
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <!-- <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Last Name" required> -->
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <!-- <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" required> -->
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" id="submit" name="submit" value="1" disabled>Register</button>
                    </div>
                    <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a>
                  </form>
                  <form action="<?php echo site_url("index/registerCheck");?>" method="post" class="d-none" id="formMarket">
                    <div class="text-center">
                      <h1 class="h5">ร้านค้า</h1>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" id="mUsername" placeholder="Username" onkeyup="checkMarketuser(this.value)" required>
                    </div>
                    <div class="form-group m-0 text-right">
                      <label class="form-group d-none m-0" id="moutUsername"></label>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <!-- <input type="password" class="form-control" name="password" id="mpassword" placeholder="Password" onkeyup="checkMarketPassword()" required> -->
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <!-- <input type="password" class="form-control" name="conPassword" id="mconPassword" placeholder="Confirm Password" onkeyup="checkMarketPassword()" required> -->
                    </div>
                    <div class="form-group m-0 text-right">
                      <label class="form-group d-none m-0" id="moutPassword"></label>
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showMarketPassword()">
                      <label class="form-check-label" for="exampleCheck1">Show Password</label>
                    </div>
                    <div class="form-group">
                      <label>First Name</label>
                      <!-- <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter First Name" required> -->
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <!-- <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Last Name" required> -->
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <!-- <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" required> -->
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" id="submit" name="submit" value="2">Register</button>
                    </div>
                    <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="<?php echo site_url(""); ?>">Already have an account?</a>
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
  var btCustomer    = document.getElementById("btCustomer");
  var btMarket      = document.getElementById("btMarket");
  // id form
  var formCustomer  = document.getElementById("formCustomer");
  var formMarket    = document.getElementById("formMarket");
  // id customer from detail
  var username      = document.getElementById("username");
  var outUsername   = document.getElementById("outUsername");
  var password      = document.getElementById("password");
  var conPassword   = document.getElementById("conPassword");
  var outPassword   = document.getElementById("outPassword");
  // id market from detail
  var mUsername     = document.getElementById("mUsername");
  var moutUsername  = document.getElementById("moutUsername");
  var mpassword     = document.getElementById("mpassword");
  var mconPassword  = document.getElementById("mconPassword");
  var moutPassword  = document.getElementById("moutPassword");

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
      outUsername.className = "form-group d-none m-0";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText === "") {
            outUsername.innerHTML = this.responseText;
            outUsername.classList.add("d-none");
            username.classList.remove("is-invalid");
            username.classList.add("is-valid");
            document.getElementById('submit').disabled = false;
          } else {
            outUsername.innerHTML = this.responseText;
            outUsername.classList.remove("d-none");
            outUsername.classList.add("text-danger");
            username.classList.remove("is-valid");
            username.classList.add("is-invalid");
            document.getElementById('submit').disabled = true;
          }
        } else {
          outUsername.innerHTML = "no connect";
          username.classList.remove("is-valid");
          username.classList.remove("is-invalid");
          outUsername.classList.add("d-none");
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
      return;
    } else {
      if (password.value.length >= 8) {
        if (conPassword.value.length == 0) {
          conPassword.className = "form-control";
        } else {
          if (password.value == conPassword.value) {
            password.className    = "form-control is-valid";
            conPassword.className = "form-control is-valid";
          } else {
            password.className    = "form-control is-invalid";
            conPassword.className = "form-control is-invalid";
          }
        }
      } else {
        password.className    = "form-control is-invalid";
        conPassword.className = "form-control";
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
      moutUsername.className = "form-group d-none m-0";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText === "") {
            moutUsername.innerHTML = this.responseText;
            moutUsername.classList.add("d-none");
            mUsername.classList.remove("is-invalid");
            mUsername.classList.add("is-valid");
          } else {
            moutUsername.innerHTML = this.responseText;
            moutUsername.classList.remove("d-none");
            moutUsername.classList.add("text-danger");
            mUsername.classList.remove("is-valid");
            mUsername.classList.add("is-invalid");
          }
        } else {
          moutUsername.innerHTML = "no connect";
          mUsername.classList.remove("is-valid");
          mUsername.classList.remove("is-invalid");
          moutUsername.classList.add("d-none");
        }
      }
      xmlhttp.open("GET", "<?php echo site_url("index/usercheck/"); ?>" + str , true);
      xmlhttp.send();
    }
  }

  function checkMarketPassword() {
    if (mpassword.value.length == 0 && mconPassword.value.length == 0) {
      mpassword.className    = "form-control";
      mconPassword.className = "form-control";
      return;
    } else {
      if (mpassword.value.length >= 8) {
        if (mconPassword.value.length == 0) {
          mconPassword.className = "form-control";
        } else {
          if (mpassword.value == mconPassword.value) {
            mpassword.className    = "form-control is-valid";
            mconPassword.className = "form-control is-valid";
          } else {
            mpassword.className    = "form-control is-invalid";
            mconPassword.className = "form-control is-invalid";
          }
        }
      } else {
        mpassword.className    = "form-control is-invalid";
        mconPassword.className = "form-control";
        moutUsername.innerHTML = "no connect";
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
