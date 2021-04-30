<!DOCTYPE html>
<html lang="en" class="full-screen">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="<?php echo site_url('assets/img/logo/store.png'); ?>" rel="icon">
	<title>GIMYONG WEBSITE</title>
	<?php $this->load->view('include/meta'); ?>
</head>

<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php $this->load->view('include/sidebar'); ?>
		<!-- Sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- TopBar -->
				<?php $this->load->view('include/topbar'); ?>
				<!-- Topbar -->

				<!-- Container Fluid-->
				<?php $this->load->view($content); ?>
				<!---Container Fluid-->
			</div>
			<!-- Footer -->
			<?php //$this->load->view('include/footer'); ?>
			<!-- Footer -->
		</div>
	</div>

	<!-- Scroll to top -->
	<a class="scroll-to-top rounded pb-4 z-index-1" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<?php $this->load->view('include/script'); ?>

</body>

</html>