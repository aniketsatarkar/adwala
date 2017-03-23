<?php
	session_start();

	include_once "cafunctions.php";
		
	if(isset($_GET['paperId']) && isset($_GET['editionId']) && isset($_GET['adtypeId']))
	{
		$_SESSION['paper_id']   = $_GET['paperId'];
		$_SESSION['edition_id'] = $_GET['editionId'];
		$_SESSION['adtype_id']  = $_GET['adtypeId'];
	}
	else	
		die();
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
	<script type="text/javascript" src="materialize/js/materialize.min.js"></script>
	
	<script type="text/javascript">
		
		// global variable contain rate object.
		var jsonRate = null;
		
		function getRate()
		{
			$.get("cafunctions.php", 
			{
				table : "rate",
				action : "getrate"
				
			},
			function(data, status)
			{
				//alert(data);
				
				try
				{
					jsonRate = JSON.parse(data);
				}
				catch(e)
				{
					jsonRate = null;
					//alert("Faied to parse JSON data !");
				}
				finally 
				{
					renderUI();
				}
			});
		}
		
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
			{
				$('#composead_ui').load("composead_line.html");
			}
			else if(rate_unit == 'W')
			{
				$('#composead_ui').load("composead_word.html");
			}
			else if(rate_unit == 'A')
			{
				$('#composead_ui').load("composead_graphic.html");
			}
			else
			{
				$('#composead_ui').html(error_message);
			}
			
			$('#composead_ui').fadeIn(1500);
		}
		
		$(document).ready(function()
		{
			$('#mobile_menu').sideNav();
			getRate();
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
		
	<!-- MAIN -->
	<main>	
		<div class="container">
			<div id="composead_ui"> </div>
		</div>
	</main>

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