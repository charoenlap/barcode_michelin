<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Michelin Barcode</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
		<meta content="" name="description">
		<meta content="" name="author">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- App favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">
		<!-- jvectormap -->
		<link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
		<!-- App css -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="assets/css/jquery-ui.min.css" rel="stylesheet">
		<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
		<link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css">
		<link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">
		<link href="assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
		<link href="assets/css/app.min.css" rel="stylesheet" type="text/css">

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/metismenu.min.js"></script>
		<!-- <script src="assets/js/waves.js"></script> -->
		<script src="assets/js/feather.min.js"></script>
		<script src="assets/js/simplebar.min.js"></script>
		<script src="assets/js/jquery-ui.min.js"></script>
		<script src="assets/js/moment.js"></script>
		<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
		<script src="assets/plugins/select2/select2.min.js"></script>

		<!-- <script src="assets/pages/jquery.forms-advanced.js"></script> -->
		
	</head>
	<body class="dark-sidenav">
		<?php if(get('route')!='home' AND get('route')!=''){ ?>
		<!-- Left Sidenav -->
		<div class="left-sidenav">
			<!-- LOGO -->
			<div class="brand">
				<a href="#" class="logo">
					<span class="text-info">
						Michelin
					</span>
				</a>
			</div>
			<!--end logo-->
			<div class="menu-content h-100" data-simplebar>
				<ul class="metismenu left-sidenav-menu">
					<li class="menu-label mt-0">Main</li>
					<li>
						<a href="<?php echo route('dashboard'); ?>">
							<i data-feather="home" class="align-self-center menu-icon"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="<?php echo route('barcode/association'); ?>">
							<i data-feather="home" class="align-self-center menu-icon"></i>
							<span>Barcode Association</span>
						</a>
					</li>
					<li>
						<a href="javascript: void(0);">
							<i data-feather="grid" class="align-self-center menu-icon">
							</i>
							<span>Barcode</span>
							<span class="menu-arrow">
								<i class="mdi mdi-chevron-right"></i>
							</span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<a href="<?php echo route('barcode'); ?>">
									<i class="ti-control-record"></i>List 
								</a>
							</li>
							<li>
								<a href="<?php echo route('barcode/listGroup'); ?>">
									<i class="ti-control-record"></i>List Group
								</a>
							</li>
							<li>
								<a href="<?php echo route('purchase'); ?>">
									<i class="ti-control-record"></i>Add (Purchease)
								</a>
							</li>
						</ul>
					</li>
					<!-- <li>
						<a href="javascript: void(0);">
							<i data-feather="grid" class="align-self-center menu-icon">
							</i>
							<span>Product</span>
							<span class="menu-arrow">
								<i class="mdi mdi-chevron-right"></i>
							</span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<a href="#">
									<i class="ti-control-record"></i>Import product 
								</a>
							</li>
						</ul>
					</li> -->
					<li>
						<a href="javascript: void(0);">
							<i data-feather="grid" class="align-self-center menu-icon">
							</i>
							<span>User</span>
							<span class="menu-arrow">
								<i class="mdi mdi-chevron-right"></i>
							</span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<a href="<?php echo route('user'); ?>">
									<i class="ti-control-record"></i>List 
								</a>
							</li>
							<li>
								<a href="<?php echo route('user/group'); ?>">
									<i class="ti-control-record"></i># User group 
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="javascript: void(0);">
							<i data-feather="grid" class="align-self-center menu-icon">
							</i>
							<span>Config</span>
							<span class="menu-arrow">
								<i class="mdi mdi-chevron-right"></i>
							</span>
						</a>
						<ul class="nav-second-level" aria-expanded="false">
							<li>
								<a href="<?php echo route('setting'); ?>">
									<i class="ti-control-record"></i># Setting 
								</a>
							</li>
							<li>
								<a href="<?php echo route(''); ?>">
									<i class="ti-control-record"></i># Backup DB
								</a>
							</li>
							<li>
								<a href="<?php echo route('config/update'); ?>">
									<i class="ti-control-record"></i>Update Software
								</a>
							</li>
						</ul>
					</li>
					<hr class="hr-dashed hr-menu">
				</ul>
			</div>
		</div>
		<!-- end left-sidenav-->
	<?php } ?>