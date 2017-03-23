function hideAll()
{
	$('#dashboard_div').hide();
	$('#newspapers_div').hide();
	$('#editions_div').hide();
	$('#rates_div').hide();
	$('#packages_div').hide();
	$('#offers_div').hide();
	$('#coupons_div').hide();
	$('#settings_div').hide();
}

// function to heightlight buttons by applying a color,
// classe to it. called by show*() functions.
// e => javascript html element object.
function heightlightButton(e)
{	
	if(e == null) return;

	// remove teal class from all button >>>
	$("#userPanel a").removeClass("teal lighten-2");
	
	// add teal class to clicked button >>>
	var classes = e.getAttribute('class') + " teal lighten-2";
	e.setAttribute('class', classes);
}

function showDashboard(e)
{
	hideAll();
	heightlightButton(e);
	$('#dashboard_div').fadeIn();
}

function showNewspapers(e)
{
	hideAll();
	heightlightButton(e);
	$('#newspapers_div').fadeIn();
}

function showEditions(e)
{
	hideAll();
	heightlightButton(e);
	$('#editions_div').fadeIn();
}

function showRates(e)
{
	hideAll();
	heightlightButton(e);
	$('#rates_div').fadeIn();
}

function showPackages(e)
{
	hideAll();
	heightlightButton(e);
	$('#packages_div').fadeIn();
}

function showOffers(e)
{
	hideAll();
	heightlightButton(e);
	$('#offers_div').fadeIn();
}

function showCoupons(e)
{
	hideAll();
	heightlightButton(e);
	$('#coupons_div').fadeIn();
}

function showSettings(e)
{
	hideAll();
	heightlightButton(e);
	$('#settings_div').fadeIn();
}




function refreshDashboard()
{
	$.get("*.php",
	{
		get_dashboard:""
	},
	function(data,status)
	{
		$('#dashboard_div').html(data);
	});
}


function refreshNewspapers()
{
	$.get("*.php",
	{
		get_newspapers:""
	},
	function(data,status)
	{
		$('#newspapers_div').html(data);
	});
}


function refreshEditions()
{
	$.get("*.php",
	{
		get_editions:""
	},
	function(data,status)
	{
		$('#editions_div').html(data);
	});
}


function refreshRates()
{
	$.get("*.php",
	{
		get_rates:""
	},
	function(data,status)
	{
		$('#rates_div').html(data);
	});
}


function refreshPackages()
{
	$.get("*.php",
	{
		get_packages:""
	},
	function(data,status)
	{
		$('#packages_div').html(data);
	});
}


function refreshOffers()
{
	$.get("*.php",
	{
		get_offers:""
	},
	function(data,status)
	{
		$('#offers_div').html(data);
	});
}


function refreshCoupons()
{
	$.get("*.php",
	{
		get_coupons:""
	},
	function(data,status)
	{
		$('#coupons_div').html(data);
	});
}


function refreshSettings()
{
	$.get("*.php",
	{
		get_settings:""
	},
	function(data,status)
	{
		$('#settings_div').html(data);
	});
}


function showNewAds_btn(e)
{
	
}

function showPaidAds_btn(e)
{
	
}

function showUnpaidAds_btn(e)
{
	
}


function editNewspaper_btn(e)
{
	var id = e.getAttribute("data-paper-id");
}

function deleteNewspaper_btn(e)
{
	var id = e.getAttribute("data-paper-id");
}

function createNewspaper_btn(e)
{
	
}


function editEdition_btn(e)
{
	var id = e.getAttribute("data-paper-id");
}

function deleteEdition_btn(e)
{
	var id = e.getAttribute("data-paper-id");
}

function createEdition_btn(e)
{
	
}


function deleteCoupon_btn(e)
{
	var id = e.getAttribute("data-paper-id");
}

function createCoupon_btn(e)
{
	
}