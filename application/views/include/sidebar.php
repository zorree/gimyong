<?php $seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2); ?>
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo site_url(); ?>">
		<div class="sidebar-brand-icon">
			<img src="<?php echo site_url('assets/img/logo/store.png'); ?>">
		</div>
		<div class="sidebar-brand-text mx-3">Gimyong</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item <?php echo $seg1 == '' || $seg1 == 'index' ? 'active' : ''; ?>">
		<a class="nav-link" href="<?php echo site_url(); ?>">
			<i class="fas fa-home" style="font-size: 18px;"></i>
			<span>หน้าแรก</span>
		</a>
	</li>
	<?php if($this->session->userdata('login')) { ?>
		<hr class="sidebar-divider">
		<div class="sidebar-heading">เมนูหลัก</div>
		<?php 
			if ($this->session->userdata('type') == 'admin') { 
		?>
				<li class="nav-item <?php echo $seg1 == 'admin' && $seg2 == 'market' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('admin/market'); ?>"  >
						<!-- <i class="fas fa-store-alt"></i> -->
						<i class="fas fa-ambulance" style="font-size: 16px;"></i>
						<span>ร้านค้า</span>
					</a>
				</li>
				<!-- <li class="nav-item <?php echo $seg1 == 'admin' && $seg2 == 'customer' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('admin/customer'); ?>"  >
						<i class="fas fa-user-alt"></i>
						<span>ลูกค้า</span>
					</a>
				</li> -->
				<li class="nav-item <?php echo $seg1 == 'admin' && $seg2 == 'customer' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('admin/customer'); ?>"  >
						<i class="fas fa-street-view" style="font-size: 20px;"></i>
						<span>ลูกค้า</span>
					</a>
				</li>
				<!-- <li class="nav-item <?php echo $seg1 == 'admin' && $seg2 == 'promotion' ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('admin/promotion'); ?>"  >
						<i class="fas fa-bullhorn" style="font-size: 16px;"></i>
						<span>โปรโมชั่น</span>
					</a>
				</li> -->
		<?php 
			} else if ($this->session->userdata('type') == 'market'){ 
		?>
				<li class="nav-item <?php echo $seg1 == 'market' && ($seg2 == 'profile' || $seg2 == 'marketedit') ? 'active' : ''; ?>">
					<a class="nav-link " href="<?php echo site_url('market/profile'); ?>"  >
						<i class="fas fa-file-signature" style="font-size: 18px;"></i>
						<span>โปรไฟล์</span>
					</a>
				</li>
				<li class="nav-item <?php echo $seg1 == 'market' && ($seg2 == 'goods') ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('market/goods'); ?>">
						<i class="fas fa-dolly" style="font-size: 18px;"></i>
						<span>สินค้าแนะนำ</span>
					</a>
				</li>
				<li class="nav-item <?php echo $seg1 == 'market' && ($seg2 == 'report') ? 'active' : ''; ?>">
					<a class="nav-link" href="<?php echo site_url('market/report'); ?>">
						<i class="fas fa-comment-alt" style="font-size: 20px;"></i>
						<span>ความคิดเห็น</span>
					</a>
				</li>
		<?php 
			} else { 
		?>
			<li class="nav-item <?php echo $seg1 == 'customer' && ($seg2 == '' || $seg2 == 'profile') ? 'active' : ''; ?>">
				<a class="nav-link " href="<?php echo site_url('customer/profile'); ?>">
					<i class="fas fa-file-signature" style="font-size: 16px;"></i>
					<span>โปรไฟล์</span>
				</a>
			</li>
			<li class="nav-item <?php echo $seg1 == 'customer' && ($seg2 == 'market' || $seg2 == 'marketdetail') ? 'active' : ''; ?>">
				<a class="nav-link" href="<?php echo site_url('customer/market'); ?>">
					<i class="fas fa-store" style="font-size: 16px;"></i>
					<span>ร้านค้า</span>
				</a>
			</li>
			<li class="nav-item <?php echo $seg1 == 'student' && ($seg2 == 'report') ? 'active' : ''; ?>">
				<a class="nav-link" href="<?php echo site_url('customer/report'); ?>">
					<i class="fas fa-history" style="font-size: 20px;"></i>
					<span>ความคิดเห็น</span>
				</a>
			</li>
		<?php 
			} 
		?>
			<hr class="sidebar-divider">
			<div class="sidebar-heading">บัญชีผู้ใช้</div>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo site_url('index/logout'); ?>">
					<i class="fas fa-sign-out-alt" style="font-size: 20px;"></i>
					<span>ออกจากระบบ</span>
				</a>
			</li>
	<?php } ?>
	<hr class="sidebar-divider">
	<span class="mx-2 font-weight-light text-center" style="font-size: 12px; z-index: 2;">GIMYONG WEBSITE V.1</span>
	<span class="mx-2 font-weight-light text-center" style="font-size: 12px">Creat by Nattawut Amad</span>
	<!-- <span class="mx-2 text-center">GIMYONG WEBSITE Creat by Nattawut Amad</span> -->
	
</ul>