<?php

	session_start();
	include_once "Dashboard_Helper.php";
	
	if(isset($_GET['table']) && isset($_GET['action']))
	{
		// handler GET requests here //
	}
	else if(isset($_GET['get_dashboard']))
	{
		getAccountSummery($_SESSION['user_id']);
	}
	else if(isset($_GET['get_cart']))
	{
		getCart($_SESSION['user_id']);
	}
	else if(isset($_GET['get_offers']))
	{
		getOffers();
	}
	else if(isset($_GET['get_coupons']))
	{
		getCoupons($_SESSION['user_id']);
	}
	else if(isset($_GET['get_posted_ads']))
	{
		getPostedAds($_SESSION['user_id']);
	}
	else if(isset($_GET['get_saved_ads']))
	{
		getSavedAds($_SESSION['user_id']);
	}
	else if(isset($_GET['get_my_files']))
	{
		getFiles($_SESSION['user_id']);
	}
	else if(isset($_GET['get_settings']))
	{
		getSettings($_SESSION['user_id']);
	}

	
	if(isset($_POST['table']) && isset($_POST['action']))
	{
		if(isset($_POST['coupon_code']))
		{
			// ---- user coupon ----
			$couponCode = $_POST["coupon_code"];
			$adId = $_POST['ad_id'];
			
			useCoupon($_SESSION["user_id"], $adId ,$couponCode);
		}
		else if($_POST["table"] == "user" && $_POST['action'] == "update_data" )
		{
			// ---- update user data ----
			$name = $_POST['full_name'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$address = $_POST['address']; 
			
			saveSettings($_SESSION['user_id'], $name, $email, $mobile, $city, $state, $address);
		}
	}
	else if(isset($_POST['delete_ad_from_cart']) && isset($_POST['id']))
	{
		deleteAdFromCart($_POST['id']);
	}
	else if(isset($_POST['delete_posted_ad']) && isset($_POST['id']))
	{
		deletePostedAd($_POST['id']);
	}
	else if(isset($_POST['delete_saved_ad']) && isset($_POST['id']))
	{
		deleteSavedAd($_POST['id']);
	}
	else if(isset($_POST['delete_file']) && isset($_POST['id']))
	{
		deleteFile($_POST['id']);
	}
	
?>