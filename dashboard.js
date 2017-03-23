// ---- REGRESH DIVISIONS ---- // 
// ----------------------------//
function refreshDashboard()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_dashboard: ""
	}, 
	function(data, status)
	{
		$('#dashboard_div').html(data);
		$('#dashboard_div').hide();
		$('#dashboard_div').fadeIn();
	});
}

function refreshCart()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_cart: ""
	}, 
	function(data, status)
	{
		$('#cart_div').hide();
		$('#cart_div').html(data);
		$('#cart_div').fadeIn();
	});
}

function refreshOffers()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_offers: ""
	}, 
	function(data, status)
	{
		$('#offers_div').hide();
		$('#offers_div').html(data);
		$('#offers_div').fadeIn();
	});
}

function refreshCoupons()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_coupons: ""
	}, 
	function(data, status)
	{
		$('#coupons_div').hide();
		$('#coupons_div').html(data);
		$('#coupons_div').fadeIn();
	});
}

function refreshPostedAds()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_posted_ads: ""
	}, 
	function(data, status)
	{
		$('#myads_div').hide();
		$('#myads_div').html(data);
		$('#myads_div').fadeIn();
	});
}

function refreshSavedAds()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_saved_ads: ""
	}, 
	function(data, status)
	{
		$('#savedad_div').hide();
		$('#savedad_div').html(data);
		$('#savedad_div').fadeIn();
	});
}

function refreshMyFiles()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_my_files: ""
	}, 
	function(data, status)
	{
		$('#files_div').hide();
		$('#files_div').html(data);
		$('#files_div').fadeIn();
	});
}

function refreshSettings()
{
	$.get("Dashboard_Rquests.php", 
	{
		get_settings: ""
	}, 
	function(data, status)
	{
		$('#settings_div').hide();
		$('#settings_div').html(data);
		$('#settings_div').fadeIn();
	});
}
// ----------------------------//


function hideAll()
{
	$('#dashboard_div').hide();
	$('#cart_div').hide();
	$('#offers_div').hide();
	$('#coupons_div').hide();
	$('#myads_div').hide();
	$('#savedad_div').hide();
	$('#files_div').hide();
	$('#settings_div').hide();
	
	$('#cart_section_div').hide();
	$('#paymentDiv').hide();
}


function heightlightButton(e)
{ 
	if(e == null) return;
	
	$('#userPanel a').removeClass("teal lighten-2");
	
	var classes = e.getAttribute("class") + " teal lighten-2";
	e.setAttribute("class", classes);
}


function showDashboard(e)
{
	hideAll();
	heightlightButton(e)
	refreshDashboard();
}

function showCart(e)
{
	hideAll();
	heightlightButton(e)
	$('#cart_section_div').fadeIn();
	refreshCart();
}

function showMyOffers(e)
{
	hideAll();
	heightlightButton(e)
	refreshOffers();
}

function showCoupons(e)
{
	hideAll();
	heightlightButton(e)
	refreshCoupons();
}

function showMyAds(e)
{
	hideAll();
	heightlightButton(e)
	refreshPostedAds();
}

function showSavedAds(e)
{
	hideAll();
	heightlightButton(e)
	refreshSavedAds();
}

function showMyFiles(e)
{
	hideAll();
	heightlightButton(e)
	refreshMyFiles();
}

function showSettings(e)
{
	hideAll();
	heightlightButton(e)
	refreshSettings();
}

function logout()
{
	$.post("logout.php", 
	{
		logout: "logout"
	}, 
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);

			if(json.status == "success")
				location.href = "http://localhost/new"; 
			else
				Materialize.toast("Something Went Wrong, Please Try Again !", 3000);
		}
		catch(e)
		{
			Materialize.toast("Something Went Wrong, Please Try Again !", 3000);
		}
	});
}

function useCoupon_btn(e)
{
	var couponCode = e.getAttribute('data-coupon-code');
	$('#couponCode').val(couponCode);
	showCart();
	Materialize.updateTextFields();
}

function requestCoupon()
{
	var couponCode = $('#couponCode').val();
	var adId = $('#adIdSpan').html();
	
	if(couponCode == '' || couponCode == null)
	{
		$('#couponCode').focus();
		Materialize.toast("Please Enter Coupon Code", 3000);
		return;
	}

	$.post("Dashboard_Rquests.php",
	{
		table: "coupon",
		action: "user_coupon",
		coupon_code: couponCode,
		ad_id: adId
	},
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			var req_status  = json.status;
			var req_message = json.message;

			if(req_status == "successful")
			{
				// coupon found and processed !
				var couponAmount = parseInt(json.coupon_amount);
				var amountToPay = parseInt($('#amountToPay').html());
				var deductedAmount = amountToPay - couponAmount;
				
				$('#couponAmount').html(couponAmount);
				$('#amountToPay').html(deductedAmount);
				$('#deductionDiv').fadeIn();
				refreshCart();
			}
			else if(req_status == "failed")
			{
				// Alerts!, When result is 'failed' >>
				if(req_message == "no_coupon_found")
				{
					Materialize.toast("Sorry, No Such Coupon Found !", 3000);
				}
				else if(req_message == "coupon_is_used")
				{
					Materialize.toast("Sorry, Coupon Is Already Used !", 3000);
				}
				else if(req_message == "something_went_wrong")
				{
					Materialize.toast("Something Went Wrong ! Pleasae Try Again", 3000);
				}
			}
		}
		catch(e)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}

function payThisAd_btn(e)
{
	var adId   = e.getAttribute("data-adid");
	var adCost = e.getAttribute("data-ad-cost");
	
	$('#adIdSpan').html(adId);
	
	$('#deductionDiv').hide(); 
	$('#amountToPay').html(adCost);
	$('#totlaAmount').html(adCost);
	$('#paymentDiv').fadeIn();
	$('#paymentDiv').fadeIn();
}

function deleteFromCart_btn(e)
{
	var adId = e.getAttribute("data-adid");
	
	$.post("Dashboard_Rquests.php", 
	{
		delete_ad_from_cart: "",
		id: adId
	}, 
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			
			if(json.status == "successful")
				showCart();
		}
		catch(ex)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}

function deletePostedAd_btn(e)
{
	var id = e.getAttribute("data-ad-id");
	
	$.post("Dashboard_Rquests.php",
	{
		delete_posted_ad: "",
		id: id
	}, 
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			if(json.status == "successful")
				refreshPostedAds();
		}
		catch(ex)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}

function deleteSavedAd_btn(e)
{
	var id = e.getAttribute("data-id");
	
	$.post("Dashboard_Rquests.php", 
	{
		delete_saved_ad: "",
		id: id
	}, 
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			if(json.status == "successful")
				refreshSavedAds();
		}
		catch(ex)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}

function deleteFile_btn(e)
{
	var id = e.getAttribute("data-file-id");
	
	$.post("Dashboard_Rquests.php", 
	{
		delete_file: "",
		id: id
	}, 
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			if(json.status == "successful")
				refreshMyFiles();
		}
		catch(ex)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}


// function to disabel all of the input fields
// in settings division.
function disableAllSettings()
{
	$('#user_fullname').attr("disabled", "");
	$('#user_email').attr("disabled", "");
	$('#user_mobile').attr("disabled", "");
	$('#user_state').attr("disabled", "");
	$('#user_city').attr("disabled", "");
	$('#user_address').attr("disabled", "");
	$('#save_settings_btn').attr("disabled", "");
}

// function to remove disabled attribute from
// all of the settings input fields.
function editUserDate_btn(e)
{
	$('#user_fullname').removeAttr("disabled");
	$('#user_email').removeAttr("disabled");
	$('#user_mobile').removeAttr("disabled");
	$('#user_state').removeAttr("disabled");
	$('#user_city').removeAttr("disabled");
	$('#user_address').removeAttr("disabled");
	$('#save_settings_btn').removeAttr("disabled");	
}

function saveUserDate_btn(e)
{
	var fullName = $('#user_fullname').val();
	var email = $('#user_email').val();
	var mobile = $('#user_mobile').val();
	var addr_state = $('#user_state').val();
	var addr_city = $('#user_city').val();
	var address = $('#user_address').val();
	
	if(fullName == "" || fullName == null)
	{
		$('#user_fullname').focus();
		return;
	}
	else if(email == "" || email == null)
	{
		$('#user_email').focus();
		return;
	}
	else if(mobile == "" || mobile == null)
	{
		$('#user_mobile').focus();
		return;
	}
	else if(addr_state == "" || addr_state == null)
	{
		$('#user_state').focus();
		return;
	}
	else if(addr_city == "" || addr_city == null)
	{
		$('#user_city').focus();
		return;
	}
	else if(address == "" || address == null)
	{
		$('#user_address').focus();
		return;
	}	
	
	$.post("Dashboard_Rquests.php", 
	{
		table: "user",
		action: "update_data",
		full_name : fullName,
		email : email,
		mobile : mobile,
		state : addr_state,
		city : addr_city,
		address : address
	},
	function(data, status)
	{
		try
		{
			var json = JSON.parse(data);
			if(json.status == "successful")
			{
				disableAllSettings();
				Materialize.toast("Saved Successfully !", 3000);
			}
			else
				Materialize.toast("Failed To Update Settings !", 3000);
		}
		catch(e)
		{
			Materialize.toast("Something Went Wrong !", 3000);
		}
	});
}


// --- RERADY --------------
$(document).ready(function()
{
	$('#mobile_menu').sideNav();
	$("#user_nav").sideNav();
	$(".tooltipped").tooltip();

	showDashboard(); // <---
	//showCart();
});