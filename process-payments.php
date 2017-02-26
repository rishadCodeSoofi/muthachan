<?php
require_once "functions.php";

//$fields_to_get 	= array("id", "name");
//$transactionsStatus = getDataFromTable('transaction_status_master', $fields_to_get, 'name', 'Pending Approval');

$fields_to_get 	= '*';
$usersFundData 		= getDataFromTable('users_fund', $fields_to_get, '', '', ' WHERE balance >= 100');

 //echo '<pre>';
 //print_r($usersFundData);
 //print_r($transactionsData);
 //exit;

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
											
													<h3>Process Deposits [February, 2017]</h3>
																														
													<form method="post" action="#">
													
														<span id="div-hide-search-form-div" style="display:none;"><a href="#" onclick="hideAndShowDiv('hide','search-form-div');">Hide Search Form</a></span>
														<span id="div-show-search-form-div"><a href="#" onclick="hideAndShowDiv('show','search-form-div');">Show Search Form</a></span>
														&nbsp;&nbsp;&nbsp;													
														<span id="div-hide-bulk_process_div" style="display:none;"><a href="#" onclick="hideAndShowDiv('hide','bulk_process_div');">Hide Bulk Process Form</a></span>
													    <span id="div-show-bulk_process_div"><a href="#" onclick="hideAndShowDiv('show','bulk_process_div');">Show Bulk Process Form</a></span>
														
														
														
														<div class="row uniform" id="search-form-div" style="display:none;">
														<div class="12u 12u$(small)">
															<h3>Filter Input</h3>
														</div>

															<!-- <div class="6u 12u$(xsmall)">
																<input type="text" name="demo-name" id="demo-name" value="" placeholder="Name" />
															</div>
															<div class="6u$ 12u$(xsmall)">
																<input type="email" name="demo-email" id="demo-email" value="" placeholder="Email" />
															</div> -->
															<!-- Break -->
															
															<div class="4u 12u$(small)">
																	<select name="year" id="year">
																		<option value="">- Year -</option>
																		<option value="2015">2015</option>
																		<option value="2016">2016</option>
																		<option value="2017">2017</option>
																	</select>
															</div>
															
															<div class="4u 12u$(small)">
																	<select name="month" id="month">
																		<option value="">- Month -</option>
																		<option value="jan">January</option>
																		<option value="feb">February</option>
																		<option value="mar">March</option>
																	</select>
															</div>
															
															<div class="4u 12u$(small)">
																	<select name="deposited_with" id="deposited_with">
																		<option value="">- Deposited With -</option>
																		<option value="ragesh">Ragesh</option>
																		<option value="subeesh">Subeesh</option>
																		<option value="all">All</option>
																	</select>
															</div>
															
															
															
															
															
															<!-- <div class="12u$">															
																<div class="select-wrapper">
																	<select name="demo-category" id="demo-category">
																		<option value="">- Deposited With -</option>
																		<option value="1">Ragesh</option>
																		<option value="1">Subeesh</option>
																		<option value="1">All</option>
																	</select>																
																</div>			
															</div> -->
															<!-- Break -->
															<div class="4u 12u$(small)">
																<input type="radio" id="demo-priority-low" name="demo-priority" checked>
																<label for="demo-priority-low">Low Deposit Onwards</label>
															</div>
															
															<div class="4u 12u$(small)">
																<input type="radio" id="demo-priority-normal" name="demo-priority">
																<label for="demo-priority-normal">Recent</label>
															</div>															

															<div class="4u$ 12u$(small)">
																<input type="radio" id="demo-priority-high" name="demo-priority">
																<label for="demo-priority-high">High Deposit Onwards</label>
															</div>
															

															
															<!-- Break -->
															<div class="6u 12u$(small)">
																<input type="checkbox" id="demo-copy" name="demo-copy" checked>
																<label for="demo-copy">Show Un-Paid</label>
																<input type="checkbox" id="demo-human" name="demo-human">
																<label for="demo-human">Show All</label>																
															</div>
															<!-- <div class="6u$ 12u$(small)">
																<input type="checkbox" id="demo-human" name="demo-human" checked>
																<label for="demo-human">I am a human</label>
															</div> -->
															<!-- Break -->
															<!-- <div class="12u$">
																<textarea name="demo-message" id="demo-message" placeholder="Enter your message" rows="6"></textarea>
															</div> -->
															<!-- Break -->
															<div class="12u$">
																<ul class="actions">
																	<li><input type="submit" value="Filter" class="special" /></li>
																	<li><input type="reset" value="Reset" /></li>
																</ul>
															</div>
														</div>
													</form>			

													
													
														


													<form method="post" action="#">
														<div id="bulk_process_div" class="row uniform" style="display:none;">
														<div class="12u 12u$(small)">
															<h3>Bulk Process</h3>
														</div>
														
															
															<div class="4u 12u$(small)">
																	<select name="member_group" id="member_group">
																		<option value="">- Member Group? -</option>
																		<option value="ragesh">Unpaid Members with deposit >= 100[Ragesh]</option>
																		<option value="ragesh">Members with deposit >= 100[Ragesh]</option>
																		<option value="subeesh">Unpaid Members with deposit >= 100[Subeesh]</option>
																		<option value="subeesh">Members with deposit >= 100[Subeesh]</option>
																		<option value="all">Unpaid Members with deposit >= 100[All]</option>
																		<option value="all">Members with deposit >= 100[All]</option>
																	</select>
															</div>
															
															<div class="4u 12u$(small)">
																<input type="text" name="demo-name" id="demo-name" value="" placeholder="Deduction" />
															</div>
															
															<div class="4u 12u$(small)">
																<ul class="actions">
																	<li><input type="submit" value="Process" class="special" style="width:350px;" /></li>

																</ul>
															</div>
															
														</div>
													</form>





											<h3>Individual Process</h3>																	

											<div id="pay_process_div" style="height:400px;overflow:auto;">
												<table width="100%" cellpadding="2" cellspacing="2">
													 <thead>
														<tr>
															<th>Member</th>													
															<th>Balance</th>
															<th>Amount</th>
															<th>Process</th>
														</tr>
													</thead>
													<tbody>
													<form>
													
														<tr style="background-color:PapayaWhip;">
															<td colspan="2">For all the selected members</td>															
															<td style="vertical-align:middle;">
																<input type="text" name="amount" id="amount" style="width:50%;"/>
															</td>
															<td>
																<ul class="actions">
																	<li><a href="#" class="button small" style="padding:0px 0px;">Process</a></li>
																</ul>
															</td>
														</tr>
														
													
													    <?php
														if ( isset($usersFundData) && count($usersFundData) > 0) {
															foreach($usersFundData as $usersFund) {
														?>
															<tr>
																<td><?php 
																	$userId = $usersFund['users_id'];
																	$userName = getDataFromTable('users', 'name', 'id', $userId); 
																	echo $userName[0];
																	?>														
																<input type="checkbox" style="opacity:1;z-index:999;float:none;"/>															
																</td>													
																<td>													
																	Rs. <?php echo $usersFund['balance']; ?> <br />
																	[With Subeesh]
																</td>
																<td style="vertical-align:middle;">
																	<input type="text" name="amount" id="amount" style="width:50%;"/>
																</td>
																<td>
																	<ul class="actions">
																		<li><a href="#" class="button small" style="padding:0px 0px;">Process</a></li>
																	</ul>
																</td>
															</tr>	
														<?php
															}
														}
														?>
														
																								
														
													</form>
												</tbody>													
												</table>
											</div>
		

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