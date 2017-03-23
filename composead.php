<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>

	<title> Compose Ad </title>

	<!--Import Google Icon Font-->
	<link href="materialize/css/icon.css" rel="stylesheet">
	
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="materialize/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="materialize/js/materialize.min.js">
	</script>
	
	<!-- Import jquery-UI and Calender Components -->
	<script type="text/javascript" src="materialize/js/jquery-ui-1.11.1.js"></script>
	<script type="text/javascript" src="materialize/js/jquery-ui.multidatespicker.js"></script>
	<link rel="stylesheet" type="text/css" href="materialize/css/mdp.css"></link>
	<!-- ---------------------------------------- -->
	
	
	<script type="text/javascript">
		
		var jsonRate = null;
		
		function renderUI()
		{
			var error_message = "<div class='col s12 grey-text text-lighten-1 center'>" +
			"<h4>Opps! Something Went Wrong !</h4>" +
			"<h5> Please Try Again. </h5>" +
			"</div>";
			
			var rate_unit = '';
			
			if(jsonRate == null)
				$('#composead_ui').html(error_message);
			else
				rate_unit = jsonRate[0].rate_unit;
		
			$('#composead_ui').hide();
		
			if(rate_unit == 'L')
				$('#composead_ui').load("composead_line.html");
			else if(rate_unit == 'W')
				$('#composead_ui').load("composead_word.html");
			else if(rate_unit == 'A')
				$('#composead_ui').load("composead_graphic.html");
			else
				$('#composead_ui').html(error_message);
			
			$('#composead_ui').fadeIn(1500);
		}
		
		function getRate()
		{
			$.get("cafunctions.php", 
			{
				table : "rate",
				action : "getrate"
			},
			function(data, status)
			{
				try
				{
					jsonRate = JSON.parse(data);
				}
				catch(e)
				{
					jsonRate = null;
					//alert("Failed To Parse Json Data !");
				}
				finally
				{
					renderUI();
				}
			});
		}
		
		function adtypeSelection()
		{
			$.get("cafunctions.php", 
			{
				table: "classifiedtype",
				action : "getclassifiedselect"
			},
			function(data, status)
			{
				$('#classifiedTypeSelect').html(data);
				$('select').material_select();
			});
		}
		
		function classSelection()
		{
			var class_id = $('#classifiedTypeSelect').val();
			var adtype_id = $('#adtypeSelect').val();
			
			$.post("cafunctions.php", 
			{
				key : "adtype_id",
				value : adtype_id
			},
			function(data, status)
			{
				$.post("cafunctions.php", 
				{
					key : "class_id",
					value : class_id
				},
				function(data1, status)
				{
					getRate();
				});
			});
		}
		
		function onDateSelect()
		{
			var dates = $('#selectedDates').val();
			
			if(dates == "" || dates == null)
			{
				$('#test').html("No Date Selected !");
				return;
			}			
			
			var dates_count = dates.split(",").length;
			var msg = dates_count + " Dates Selected !";
			
			$('#test').html(msg);
		}
		
		function init_datapicker(isMultiple)
		{
			if(isMultiple == true)
			{
				$('#datepicker').multiDatesPicker
				({
					dateFormat: "d-m-y",
					altField: '#selectedDates',
					minDate: 4,
					maxDate: 30,
				});
			}
			else
			{
				$('#datepicker').multiDatesPicker
				({
					dateFormat: "d-m-y",
					altField: '#selectedDates',
					minDate: 4,
					maxDate: 30,
					maxPicks: 1
				});
			}
			
			$('#datepicker').mousemove(function()
			{
				onDateSelect();
			});
		}
		
		function chkbox_multipledates()
		{
			var init_value = $('#test1').val();
			
			if(init_value == "false")
				$('#test1').val('true');
			else
				$('#test1').val('false');
			
			var new_value = $('#test1').val();
			
			$('#datepicker').multiDatesPicker('destroy');
			
			if(new_value == "true")
				init_datapicker(true);
			else
				init_datapicker(false);
		}
		
		// READY EVENT HANDLER >>>
		$(document).ready(function()
		{
			$('#mobile_menu').sideNav();
			$('select').material_select();
		
			init_datapicker(false);
		});
		
	</script>
	
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
	</style>
	
</head>


<body>
	
	<!-- HEADER -->
	<header>
		<div class="navbar-fixed">
			<nav class="teal">
				<div class="nav-wrapper">
					
					<a href="#!" class="brand-logo">Logo</a>
				  
					<a href="#" data-activates="mobile-demo" id="mobile_menu" class="button-collapse">
						<i class="material-icons">menu</i>
					</a>
				  
					<ul class="right hide-on-med-and-down">
						<li><a href="sass.html">Sass</a></li>
						<li><a href="badges.html">Components</a></li>
						<li><a href="collapsible.html">Javascript</a></li>
						<li><a href="mobile.html">Mobile</a></li>
					</ul>
					<ul class="side-nav" id="mobile-demo">
						<li><a href="sass.html">Sass</a></li>
						<li><a href="badges.html">Components</a></li>
						<li><a href="collapsible.html">Javascript</a></li>
						<li><a href="mobile.html">Mobile</a></li>
					</ul>
				</div>
			</nav>
		</div>
    </header>
		
<main class="container">
	<div class="row" style="padding: 20px">
		<div class="col s4"></div>
		<div class="col s4 center">
		<!-- PHP CODE TO SHOW PAPER IMAGE ! -->
		<?php
			
			include_once "cafunctions.php";
			
			if(isset($_GET['paperid']))
				$_SESSION['paper_id'] = $_GET['paperid'];
			else if(isset($_GET['editionid']))
				$_SESSION['edition_id'] = $_GET['editionid'];
			else
				die();
			
			getPaperLogo($_SESSION['paper_id']);
		?>
		</div>
		<div class="col s4"></div>
 	</div>
	
	
	<div class="row">
		<div class="col s12">
			<div class="input-field col s6">
				<select id="adtypeSelect" onchange="adtypeSelection()">
					<?php getAdtypeSelect(); ?>
				</select>
				<label>Ad-Type</label>
			</div>
			<div class="input-field col s6">
				<select id="classifiedTypeSelect" onchange="classSelection()">
				</select>
				<label>Classified Catagory</label>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div id="composead_ui" class="col s12"></div>
	</div>
	
	
	<div class="row">
		<div class="division">
		<div class="col s12">
			<blockquote><h5 class="light italic">Select Dates</h5></blockquote>
			<div class="divider"></div>
			
			<div class="col s12" style="padding-top: 10px;">
				<div class="col s6">
					<div id="datepicker"></div>
				</div>
			</div>
			<div class="col s6">
				<p class="left">
					<input name="calender_opt" value="false" type="checkbox" onchange="chkbox_multipledates()" id="test1"/>
					<label for="test1">Select Multiple Dates.</label>
				</p>
			</div>
			<div class="input-field col s6" style="display: none">
				<textarea id="selectedDates" disabled class="materialize-textarea">
				</textarea>
			</div>
		</div>
		</div>
	</div>

</main>
	
	<div id="test"> </div>
	
	
	<!-- FOOTER -->
	<footer class="page-footer teal">
        <div class="container">
            <div class="row">
				<div class="col l6 s12">
					<h5 class="white-text">Footer Content</h5>
					<p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
				</div>
				<div class="col l4 offset-l2 s12">
					<h5 class="white-text">Links</h5>
					<ul>
						<li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
						<li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
					</ul>
				</div>
            </div>
        </div>
        <div class="footer-copyright">
			<div class="container"> © 2014 Copyright Text
				<a class="grey-text text-lighten-4 right" href="#top">More Links</a>
            </div>
        </div>
    </footer>
	
</body>
</html>