<?php
	
	session_start();
	
	$redirectToHom = false;
	
	if(isset($_SESSION['user_id']) && isset($_SESSION['user_username']))
		include_once "Dashboard_Helper.php";
	else
		$redirectToHom = true;
?>

<!DOCTYPE html>
<html>

<head>
	<!--Import Google Icon Font-->
	<link href="materialize/css/icon.css" rel="stylesheet" />
	
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="materialize/jquery-2.1.1.min.js">
	</script>
	<script type="text/javascript" src="materialize/js/materialize.min.js">
	</script>
	
	<!-- Rediret to Home Page if user is not logged-in -->
	<?php
		if($redirectToHom)
			echo "<script type='text/javascript'>location.href = 'http://localhost/new';</script>";
	?>
	<!-- --------------------------------------------- -->
	
	<script type="text/javascript" src="dashboard.js"></script>
	
	<style type="text/css">
		body 
		{
			display: flex;
			min-height: 100vh;
			flex-direction: column;
		}
		main
		{
			flex: 1 0 auto;
		}
		
		header, main, footer 
		{
			padding-left: 300px;
		}

		@media only screen and (max-width : 992px) 
		{
			header, main, footer 
			{
				padding-left: 0;
			}
		}
	</style>
	
</head>


<body>

	<!-- Header -->
	<header>
		<div class="navbar">
			<nav class="teal">
				<div class="nav-wrapper">
					<a href="#!" class="brand-logo">Logo</a>
					
					<a href="#" data-activates="mobile-demo" id="mobile_menu" class="button-collapse" style="width: 60px">
						<i class="material-icons center">menu</i>
					</a>
					
					<a href="#" data-activates="userPanel" id="user_nav" class="button-collapse hide-on-large-only right" style="width: 60px">
						<i class="material-icons center">person</i>
					</a>
				  
					<ul class="right hide-on-med-and-down">
						<li><a href="#">Link-1</a></li>
						<li><a href="#">Link-2</a></li>
						<li><a href="#">Link-3</a></li>
						<li><a href="#">Link-4</a></li>
					</ul>
					<ul class="side-nav" id="mobile-demo">
						<li><a href="#">Link-1</a></li>
						<li><a href="#">Link-2</a></li>
						<li><a href="#">Link-3</a></li>
						<li><a href="#">Link-4</a></li>
					</ul>
				</div>
			</nav>
		</div>
    </header>

	<!-- Dashboard Side Navigation Panel -->
	<ul id="userPanel" class="side-nav fixed">
		<?php  getUserSideNav($_SESSION['user_id']); ?>
	</ul>
	
	<!-- Main Contents -->
	<main id="main" style="margin-left: 20px; margin-right: 20px">
		
		<!-- Dashboard Summery -->
		<div id="dashboard_div" class="row section"></div>
	
		<!-- CART -->
		<div  id="cart_section_div" class="row section">
			<!-- CART CONTENTS WILL GO HERE -->
			<div id="cart_div" class="col s12"></div>
			
			<!-- PAYMENT STATEMENT ! -->
			<div id="paymentDiv" class="row" style="display: none">
				
				<span id="adIdSpan" style="display:none"></span>
				
				<div class="divider"></div>
				<div class="col s8">
					<div class="col s12 input-field">
						<input id="couponCode" type="text">
						<label for="couponCode">Coupon Code</label>
					</div>
					<div class="col s12 center">
						<a class="btn-flat waves-effect waves-teal" onclick="requestCoupon()"><b>Use Coupon</b></a>
						<a class="btn teal">Make Payment</a>
					</div>
				</div>
				<div class="col s4">
					<div class="col s12 card center green-text">
						<div id="deductionDiv" style="display: none">
							<h6>
								&#8377;<span id="totlaAmount">3000</span> - &#8377;<span id="couponAmount">0</span>
							</h6>
							<div class="divider"></div>
						</div>
						<h1>&#8377;<span id="amountToPay">3000</span></h1>
						<div class="divider"></div>
						<h6><b>Amount To Pay</b></h6>
					</div>
				</div>
			</div>
		</div>
		
		<!-- OFFERS -->
		<div id="offers_div" class="row section"></div>
		
		<!-- COUPONS -->
		<div id="coupons_div" class="row section"></div>
	
		<!-- POSTED ADS -->
		<div id="myads_div" class="row section"></div>
	
		<!-- SAVED ADS -->
		<div id="savedad_div" class="row section"></div>
		
		<!-- My FILES -->
		<div  id="files_div" class="row section"></div>
		
		<!-- SETTINGS -->
		<div id="settings_div" class="row section"></div>
	
	
	</main>
	
	
	<!-- FOOTER -->
	<footer class="page-footer teal" style="height: 70px">
		<div class="row">
			<div class="col s12">
				<a class="right">
					<i class="material-icons white-text" style="font-size: 40px; margin-left: 6px; margin-right: 6px">save</i>	
				</a>
				<a href="#" data-activates="mobile-demo" id="mobile_menu" class="button-collapse hide-on-large-only right">
					<i class="material-icons white-text" style="font-size: 40px; margin-left: 6px; margin-right: 6px">menu</i>
				</a>
				<a href="#" data-activates="userPanel" class="button-collapse hide-on-large-only right">
					<i class="material-icons white-text" style="font-size: 40px; margin-left: 6px; margin-right: 6px">person</i>
				</a>
			</div>
		</div>
    </footer>
	
</body>
</html>