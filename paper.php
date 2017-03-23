<?php
	include_once "paper_page_dyn.php";
	
	if(isset($_GET['paperId']))
	{
		$_SESSION['paper_id'] = $_GET['paperId'];
	}
	else
	{
		echo "Something Went Wrong !";
		die();
	}
?>

<!DOCTYPE html>
<html>

<head>

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
		
		function btn_click(e)
		{
			//alert("Button Click !");
			e.stopImmediatePropagation();
			
			var element = e.currentTarget;
			
			if(element == null)
				alert("element is null !");
			
			var paperId = element.getAttribute("data-paperId");
			var editionId = element.getAttribute("data-editionId");
			var adtypeId = element.getAttribute("data-adtypeId");
			
			if(paperId == null || editionId == null || adtypeId == null)
				return;
			else
			{
				var query_str = "paperId=" + paperId + "&";
				query_str += "editionId=" + editionId + "&";
				query_str += "adtypeId=" + adtypeId;
				
				location.href = "composead2.php?" + query_str;
			}
		}
		
		$(document).ready(function()
		{
			$('.tooltipped').tooltip({delay: 50, position:"bottom"});
		});
	
	</script>
	
</head>


<body>
	
	<!-- Header -->
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
	
	<!-- Paper Info-Header -->
	<div class="row">
		<div class="card horizontal">
			<div class="card-image">
				<!-- ------------------------------------ -->
				<?php getPaperLogo($_SESSION['paper_id']); ?>
				<!-- ------------------------------------ -->
			</div>
			<div class="card-stacked">
				<div class="card-content">
					<p>
						<!-- ------------------------------------------ -->
						<?php getPaperDescription($_SESSION['paper_id']); ?>
						<!-- ------------------------------------------ -->
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<!--Collapsible-->
	<div class="container">			
		<div class="row teal-text">
			<blockquote style="margin: 0px; padding-left: 1.5rem; border-left: 5px solid #26a69a">
			<div class="gray-text text-lighten-3"><h4>Select Edition for publishing Ad</h4></div>
			</blockquote>
			<div class="divider z-depth-5"></div>
		</div>
		<ul class="collapsible popout teal-text" data-collapsible="accordion">
			<!-- ------------------- -->
			<?php getPaperEntity($_SESSION['paper_id']); ?>
			<!-- ------------------- -->
		</ul>
	</div>

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