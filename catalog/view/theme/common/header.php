<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title></title>
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
		
	</head>
	<body class="dark-sidenav">
		<?php if(get('route')!='home'){ ?>
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
						</ul>
					</li>
					<hr class="hr-dashed hr-menu">
				</ul>
			</div>
		</div>
		<!-- end left-sidenav-->
	<?php } ?>