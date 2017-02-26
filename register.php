<?php
require_once "functions.php";
if (isset($_POST['submit'])) {
$conn = getDBConn();
// prepare and bind
$stmt = $conn->prepare("INSERT INTO users (
name, address, location, email, password, phone, whatsapp, work, gender, suggested_by, is_admin, is_active, date_time) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssisss", 
$name, $address, $location, $email, $password, $phone, $whatsapp, $work, $gender, 
$suggested_by, $is_admin, $is_active, $date_time);

// set parameters and execute

$name 		= $_POST['name'];
$address 	= $_POST['address'];
$location 	= $_POST['location'];
$email 		= $_POST['email'];
$password   = encryptPassword($_POST['password']);
$phone 		= $_POST['phone'];
$whatsapp 	= $_POST['whatsapp'];
$work 		= $_POST['work'];
$gender 	= $_POST['gender'];
$suggested_by = $_POST['suggested_by'];
$is_admin 	= $_POST['is_admin'];
$is_active 	= $_POST['is_active'];

### Validating... ###
$errors 		= array();
$fields_to_get 	= 'email';
$emailData 		= getDataFromTable('users', $fields_to_get, 'email', $email);
if (isset($emailData) && count($emailData) > 0) {
	$errors['email'] = 'Error: Email '.$email.' already exists!';	
}
### Validating ends ###

if (count($errors) <= 0) {
	$stmt->execute();
	$success[] = 'Successfully Registered!';
}

$stmt->close();
$conn->close();
}

$fields_to_get 	= array("id", "name");
$userData 		= getDataFromTable('users', $fields_to_get, 'is_active', 1);
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
											<?php
											if (isset($success) && count($success) > 0) {
											?>
												<div class="12u$" style="border-style:solid;border-width:1px;border-color:green;margin-bottom:6px;padding-left:4px;color:green;">
												<?php echo $success[0]; ?>
												</div>
											<?php
											}
											?>
											
											<?php
											if (isset($errors) && count($errors) > 0) {
											?>
												<div class="12u$" style="border-style:solid;border-width:1px;border-color:red;margin-bottom:6px;padding-left:4px;color:red;">
												<?php												
												foreach($errors as $error) {
													echo $error.'<br />';
												}												
												?>
												</div>			
											<?php
											}
											?>
												
												
											<!-- Form Area -->
											<div class="contact-form">						
												
												<!-- Form -->
												<form id="postinfo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
													<!-- Left Inputs -->
													<div class="col-xs-6 wow animated slideInLeft" data-wow-delay=".5s">													
													
														<!-- Name -->
														<input type="text" name="name" id="name" required="required" class="form" placeholder="Name" />
														
														<!-- Address -->
														<input type="text" name="address" id="address" required="required" class="form" placeholder="Address" />

														<!-- Location -->
														<input type="text" name="location" id="location" required="required" class="form" placeholder="Current Location" />

														<!-- Email -->
														<input type="text" name="email" id="email" required="required" class="form" placeholder="Email" />
														
														
														<!-- Password -->
														<input type="password" name="password" id="password" required="required" class="form" placeholder="Password" />														

														<!-- Phone -->
														<input type="text" name="phone" id="phone" class="form" placeholder="Phone" />
														

														<input type="checkbox" id="whatsapp_phone" name="whatsapp_phone" value="1" style="opacity:1;margin-right:0px;z-index:10;"> 
														&nbsp;WhatsApp# Same as Phone#
														<!-- WhatsApp -->
														<input type="text" name="whatsapp" id="whatsapp" class="form" placeholder="WhatsApp" />		
														
  

  
  

														<!-- Work -->
														<input type="text" name="work" id="work" class="form" placeholder="Work" />	

						
														<select required="required" name="gender" class="form">
														  <option value="">-Gender-</option>														 
														  <option value="male">Male</option>  
														  <option value="female">Female</option>														    
														</select>	
													
														<select required="required" name="suggested-by" class="form">
														  <option value="">-Referred By-</option>  
														  <option value="0">Self</option>
														<?php
														
														if( isset($userData) && count($userData)) {
															foreach($userData as $user) {
															?>
															<option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>  
															<?php
															}															
														}														
														?>
														</select>
														

													</div><!-- End Left Inputs -->
													<!-- Right Inputs -->
													<div class="col-xs-6 wow animated slideInRight" data-wow-delay=".5s">
														<!-- Message -->
														<textarea name="content" id="content" class="form textarea"  placeholder="Any comments to Admin?"></textarea>
													</div><!-- End Right Inputs -->
													
														<!-- Hidden -->
														<input type="hidden" name="suggested_by" id="suggested_by" value="5" />
														<input type="hidden" name="is_admin" id="is_admin" value="0" />
														<input type="hidden" name="is_active" id="is_active" value="1" />
														
													<!-- Bottom Submit -->
													<div class="relative fullwidth col-xs-12">
														<!-- Send Button -->
														<button type="submit" id="submit" name="submit" class="form-btn semibold">Submit</button> 
													</div><!-- End Bottom Submit -->
													<!-- Clear -->
													<div class="clear"></div>
												</form>

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