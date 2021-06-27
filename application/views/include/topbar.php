<style>
	.dropdown-menu {
		min-width: 16rem;
	}
</style>


<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
	<button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>
	<ul class="navbar-nav ml-auto">
		<?php if($this->session->userdata('login')) { ?>
			<li class="nav-item">
				<div class="nav-link">
					<img class="img-profile rounded-circle" src="<?php echo site_url('assets/img/boy.png'); ?>">
					<span class="ml-2 d-none d-inline text-white small"><?php echo $this->session->userdata('name'); ?></span>
				</div>
			</li>
		<?php } else { ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="ml-2 d-none d-inline text-white small">เข้าสู่ระบบ</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
					<form action="<?php echo site_url('index/login'); ?>" method="post">
						<div class="text-center m-2">
							<h5>เข้าสู่ระบบ</h5>
							<!-- <span>เข้าสู่ระบบ</span> -->
							<!-- <img src="<?php echo site_url('assets/img/psupassport.png'); ?>" alt="passport-logo" width="150"> -->
						</div>
						<!-- <div class="dropdown-item" style="background: initial !important;">
							<input class="form-control form-control-sm" id="username" name="username" placeholder="Username" required/>
							<input class="form-control" id="username" name="username" placeholder="Username" required/>
						</div>
						<div class="dropdown-item input-group" style="background: initial !important;">
							<input class="form-control form-control-sm" name="password" placeholder="Password" type="password" required/>
							<input class="form-control" name="password" placeholder="Password" type="password" required/>
						</div> -->
						<div class="dropdown-item" style="background: initial !important;">
							<!-- <button type="submit" class="btn btn-primary btn-block" name="submit" value="1">สำหรับนักท่องเที่ยว</button> -->
							<a href="<?php echo site_url("index/login/customer")?>" class="btn btn-primary btn-block">สำหรับนักท่องเที่ยว</a>
						</div>
						<div class="dropdown-item" style="background: initial !important;">
							<!-- <button type="submit" class="btn btn-warning btn-block" name="submit" value="1">สำหรับร้านค้า</button> -->
							<a href="<?php echo site_url("index/login/market")?>" class="btn btn-warning btn-block">สำหรับร้านค้า</a>
						</div>
						<div class="dropdown-item" style="background: initial !important;">
							<hr>
							<!-- <a href="<?php //echo site_url("index/register")?>" class="btn btn-sm btn-secondary btn-block">ลงทะเบียน</a> -->
							<a href="<?php echo site_url("index/register")?>" class="d-flex justify-content-center">ลงทะเบียน</a>
						</div>
					</form>
				</div>
			</li>
		<?php } ?>
	</ul>
</nav>
