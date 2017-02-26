<?php
require_once "functions.php";
require_once "config.php";

$fields_to_get 	= array("id", "description");
$caseData 		= getDataFromTable('cases', $fields_to_get, 'case_status_id', 2);

$fields_to_get 	= array("id", "name");
$bankData 		= getDataFromTable('banks', $fields_to_get, 'is_active', 1);

$fields_to_get 			= "id";
$transactionStatusData 	= getDataFromTable('transaction_status_master', $fields_to_get, 'name', 'Pending Approval');

$fields_to_get 		= array("id", "name");
$transferTypeData 	= getDataFromTable('transfer_type_master', $fields_to_get, 'is_active', 1);

$fields_to_get 	= array("id", "name");
$userData 		= getDataFromTable('users', $fields_to_get, 'is_active', 1);


if (isset($_POST['submit'])) {

$conn = getDBConn();


/*echo '<pre>';
print_r($_POST);
exit;*/


//pepare and bind

$stmt1 = $conn->prepare("INSERT INTO transactions (
user_id, amount, transfer_type_id, transferred_to_id, description, is_active, transaction_status_id, reference)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt1->bind_param("idiisiis", 
$user_id, $amount, $transfer_type_id, $transferred_to_id, $description, $is_active, $transaction_status_id, $reference);

//set parameters
$user_id 				= $_POST['transferring_for']; // If for self, logged in user id and this field will be same. Otherwise transferring_for will be different
$amount 				= $_POST['total_transfer'];
$transfer_type_id 		= $_POST['transfer_type'];
$transferred_to_id 		= $_POST['transferred_to'];
$description 			= $_POST['comment'];
$is_active 				= $_POST['is_active'];
$transaction_status_id 	= $transactionStatusData[0]; // Approval status - By default "Pending Approval"
$reference 				= $_POST['reference']; // Bank reference for transaction

//execute
$status = $stmt1->execute();

// Transaction id from transactions table
$transactionInsertId = mysqli_insert_id($conn);

// Close
$stmt1->close();


$caseCount = 0;
if ($status) { // Only if transaction is successful
	if (isset($caseData) && count($caseData) > 0) {	

		foreach($caseData as $cases) {		
			$caseCount++;
			$id 				   = $cases['id'];		
			$name_of_the_variable  = "case$caseCount";				
			$$name_of_the_variable = $_POST['case'.$id];
			
			$amount 				= $_POST['case'.$id];
			if(trim($amount) == '' ||  trim($amount) <= 0) { // Skip this case as user didn't contribute on this
				continue;
			}			
			
			// prepare and bind
			$stmt = $conn->prepare("INSERT INTO case_transactions (
			case_id, user_id, amount, transactions_id, transfer_type_id, transfered_to_id, transaction_status_id, comment) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("iidiiiis", 
			$case_id, $user_id, $amount, $transactions_id, $transfer_type_id, $trasfered_to_id, $transaction_status_id, $comment);

			// set parameters
			$case_id 				= $id; // Which case
			$user_id 				= $_POST['transferring_for']; // If for self, logged in user id and this field will be same. Otherwise transferring_for will be different
			$amount 				= $_POST['case'.$id];
			$transactions_id 		= $transactionInsertId; // Last insert id from transactions table
			$transfer_type_id 		= $_POST['transfer_type']; // Direct, Bank etc.
			$trasfered_to_id 		= $_POST['transferred_to']; // Which bank account
			$transaction_status_id 	= $transactionStatusData[0]; // Approval status - By default "Pending Approval"
			$comment 				= $_POST['comment'];
			
			// execute
			$stmt->execute();		
		}
	}
}

// Update users_fund table - Balance
$fund_deposit = $_POST['deposit'];
processUserFund($user_id, $fund_deposit);

$conn->close();
}

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
												
												<!-- Form -->
												<form id="postinfo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
													<!-- Left Inputs -->
													<div class="col-xs-6 wow animated slideInLeft" data-wow-delay=".5s">		

													
														<!-- Current Balance - Read Only -->
														Current Balance
														<input type="text" name="current_balance" id="current_balance" class="form" value="10000" />													
														
														<!-- Transfer Type -->
														<select required="required" id="transfer_type" name="transfer_type" class="form">
														  <option value="">-Transfer type-</option>
														  
															<?php
															if(isset($transferTypeData) && count($transferTypeData) > 0 ) {
																foreach($transferTypeData as $transferType) {
																?>														  
																	<option value="<?php echo $transferType['id']; ?>"><?php echo $transferType['name']; ?></option>														 	
																<?php
																}
															}
															?>
														</select>	
														
														
														
														Amount to Transfer &nbsp;[Desired Split-Up]
														
														<div id="amount-transfer-div" style="border-style:solid;border-width:1px;padding:5px 5px 0px 5px;">
														
															<!-- <div class="4u 12u$(small)">
																<input type="radio" id="demo-priority-low" name="demo-priority" checked>
																<label for="demo-priority-low">New Deposit</label>
																<input type="radio" id="demo-priority-normal" name="demo-priority">
																<label for="demo-priority-normal">Deduct from my Balance</label>
															</div> -->				

															<!-- For Muthachan -->
															Total amount to <span id="transfer_or_deduct">transfer</span>? 
															<input type="text" name="total_transfer" id="total_transfer" required="required" class="form" />															
														
															<div> <b>How do you want to split the total amount transferred ? </b> 															
															</div> <br />
															
															<?php
															if(isset($caseData) && count($caseData) > 0 ) {
																foreach($caseData as $cases) {
																?>
																	<?php echo $cases['description']; ?> : Contribution for this case ?
																	<input type="text" name="case<?php echo $cases['id']; ?>" id="case<?php echo $cases['id']; ?>" class="form" />
																<?php
																}
															}
															?>		

															<!-- For Muthachan -->
															<!-- How much for Muthachan [Monthly Contribution]?
															<input type="text" name="to_muthachan" id="to_muthachan" required="required" class="form" value="Rs.100"/> -->
															
								
															
															<!-- Deposit -->
															Deposit to fund:
															<input type="text" name="deposit" id="deposit" required="required" class="form" readonly/>
													
														</div> <br />
														
														
														<!-- Deposited bank Reference or any reference for transfer -->
														<input type="text" name="reference" id="reference" required="required" class="form" placeholder="Deposited Reference" />	
													


														
														<!-- Transferring for -->
														<select required="required" id="transferring_for" name="transferring_for" class="form">
														  <option value="">-Transferring For-</option>
														  
															<?php
															
															// Current user id has to be taken from the logged in session id once the module is done
															$current_user_id = 1;
															
															if(isset($userData) && count($userData) > 0 ) {
																foreach($userData as $user) {
																	
																	if($current_user_id == $user['id']) {
																		$user['name'] = 'Self ['.$user['name'].']';
																		$selected = 'selected';
																	} else {
																		$selected = '';
																	}																	
																?>																
																	<option value="<?php echo $user['id'];  ?>" <?php echo  $selected; ?> ><?php echo $user['name'];  ?></option>														
																<?php
																		}
																	}
																?>
														</select>	
														

														<!-- Transferred to -->
														<select required="required" id="transferred_to" name="transferred_to" class="form">
															<option value="">-To Which account-</option>														
														<?php
														if (isset($bankData) && count($bankData) > 0) {
															foreach($bankData as $banks) {
															?>

															  <option value="<?php echo $banks['id']; ?>"><?php echo $banks['name']; ?></option>														 
																											    
															
															<?php
															}
														}
														?>
														</select>	
														
							

													</div><!-- End Left Inputs -->
													<!-- Right Inputs -->
													<div class="col-xs-6 wow animated slideInRight" data-wow-delay=".5s">
														<!-- Message -->
														<textarea name="comment" id="comment" class="form textarea"  placeholder="Any comments to Admin?"></textarea>
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