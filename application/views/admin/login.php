<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?php echo site_url("assets/img/logo/store.png"); ?>" rel="icon">
  <title>GIMYONG WEBSITE</title>
  <?php $this->load->view('include/meta'); ?>

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <!-- <h1 class="h4 text-gray-900 mb-4">Login Admin <i class="fas fa-user-cog"></i></h1> -->
                    <h1 class="h4 text-gray-900 mb-4">เข้าสู่ระบบ Admin</h1>
                  </div>
                  <form action="<?php echo site_url("admin/login"); ?>" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                    </div>
                    <!-- <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">จำเอาไว้</label>
                      </div>
                    </div> -->
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" name="submit" value="admin">เข้าสู่ระบบ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <?php $this->load->view('include/script'); ?>
</body>

</html>