<?php
require_once "functions.php";

//$fields_to_get 	= array("id", "name");
//$transactionsStatus = getDataFromTable('transaction_status_master', $fields_to_get, 'name', 'Pending Approval');

$fields_to_get 	= '*';
$transactionsData 		= getDataFromTable('transactions', $fields_to_get, 'is_active', '1', ' ORDER BY transaction_status_id ASC,date_time DESC');
?>

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Editorial by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/form-process.js"></script>
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/form.css" />
		
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<a href="index.html" class="logo"><strong>SKK</strong> InfoBase</a>
									<ul class="icons">
										<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
										<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
										<li><a href="#" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
										<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li>
									</ul>
								</header>

							<!-- Banner -->
								<section id="banner">
									<div class="content">
									
										<div class="inner contact">
										
											<!-- Your Mail Message -->
											<!-- <div class="mail-message-area">
												
												<div>
													<strong>Thank You !</strong> Your data has been posted!
												</div>
											</div> -->
												
												
											<!-- Form Area -->
											<div class="contact-form">	
											<div class="6u$ 12u$(medium)">
													<ul class="actions fit small">
														<li><a href="#" class="button fit small" style="padding:0px 0px;">Pending Approvals</a></li>
														<li><a href="#" class="button fit small" style="padding:0px 0px;">High Deposits</a></li>
														<li><a href="#" class="button special fit small" style="padding:0px 0px;">Rejections</a></li>
													</ul>
											</div>
											
											<table width="100%" cellpadding="2" cellspacing="2">
												<thead>
													<tr>
														<th>Member</th>													
														<th>Recent Transfer</th>
														<th>Admin Action</th>
													</tr>
												</thead>
												<tbody>
												
													<?php
													if ( isset($transactionsData) && count($transactionsData) > 0) {
													foreach($transactionsData as $transactions) {													
													?>												
													<tr>
														<td>														
														<?php														
														$userId 		= $transactions['user_id'];
														$fields_to_get 	= 'name';
														$userData 		= getDataFromTable('users', $fields_to_get, 'is_active', 1, ' AND id = '.$userId);														
														echo $userData[0];														
														?>														
														</td>													
														<td>													
															<div class="6u 12u$(small)">
																<h4>Total Amount: <?php echo $transactions['amount']; ?></h4>
																
																<?php
																//if ()
																?>
																
																<ul>
																	<li>Case1: Rs. 500</li>
																	<li>Case2: Rs. 300</li>
																	<li>Deposit: Rs. 250</li>
																</ul>
															</div>													
														</td>
														<td>
														<?php
														$fields_to_get 	= array("id", "name");
														$transactionsStatus = getDataFromTable('transaction_status_master', $fields_to_get, 'name', 'Pending Approval');		
														
														if( $transactionsStatus[1]['id'] == $transactions['transaction_status_id']) { // Pending Approval
														?>
															<!-- Admin Actions -->
															<div id="admin-action-div">
															<input type="text" name="admin_action_text" id="admin_action_text" />
															<ul class="actions small">														
																<li><a href="#" class="button small" style="padding:0px 0px;" onclick="processPayments(5,112,'approve')">Approve</a></li>
																<li><a href="#" class="button special small" style="padding:0px 0px;" onclick="processPayments(5,112,'reject')">Reject</a></li>															
															</ul>	
															</div>
															<span id="target" style="display:none;"></span>
														<?php
														} else {
														?>
															<div id="admin-action-div">
														<?php
														$fields_to_get 				= "name";
														$transactionsStatusDetails 	= getDataFromTable('transaction_status_master', $fields_to_get, 'id', $transactions["transaction_status_id"]);		
														echo $transactionsStatusDetails[0];
														?>
															
															</div>
														<?php	
														}
														?>
														</td>
													</tr>
													<?php
													}
													}
													?>
													

											</tbody>
												
											</table>
		

											</div><!-- End Contact Form Area -->
										</div><!-- End Inner -->

									
									
									
										<!-- <header>
											<h1>Hi, I’m Editorial<br />
											by HTML5 UP</h1>
											<p>A free and fully responsive site template</p>
										</header>
										<p>Aenean ornare velit lacus, ac varius enim ullamcorper eu. Proin aliquam facilisis ante interdum congue. Integer mollis, nisl amet convallis, porttitor magna ullamcorper, amet egestas mauris. Ut magna finibus nisi nec lacinia. Nam maximus erat id euismod egestas. Pellentesque sapien ac quam. Lorem ipsum dolor sit nullam.</p>
										<ul class="actions">
											<li><a href="#" class="button big">Learn More</a></li>
										</ul> -->
									</div>
									<!-- <span class="image object">
										<img src="images/pic10.jpg" alt="" />
									</span> -->
								</section>





						</div>
					</div>

				<!-- Sidebar -->
				<?php require_once "sidebar.php"; ?>
				<!-- Sidebar -->

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>