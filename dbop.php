<?php

	include_once 'dbfunctions.php';

	if(is_array($_POST) && isset($_POST['table']) && isset($_POST['action']))
	{
		if($_POST['table'] == "newspaper" && $_POST['action'] == "create")
		{
			createNewspaper($_POST['paper_name'],
							$_POST['paper_language'], 
							$_POST['paper_regions'],
							$_POST['paper_logo']);
		}
		else if($_POST['table'] == "newspaper" && $_POST['action'] == "show")
		{
			showNewspapers();
		}
		else if($_POST['table'] == "newspaper" && $_POST['action'] == "delete")
		{
			deleteNewspaper($_POST['paper_id']);
		}
		else if($_POST['table'] == "advertisement" && $_POST['action'] == "create")
		{
		}
		else if($_POST['table']== "advertisement" && $_POST['action'] == "delete")
		{
		}
		else if($_POST['table'] == "packages" && $_POST['action'] == "create")
		{
			createPackage($_POST['pkg_name'], 
						  $_POST['pkg_desc'], 
						  $_POST['pkg_offer'], 
						  $_POST['pkg_news_id']);
		}
		else if($_POST['table'] == "packages" && $_POST['action'] == "delete")
		{
			deletePackage($_POST['pkg_id']);
		}
		else if($_POST['table']=="packages" && $_POST['action'] == "show")
		{
			showPackages();
		}
		else if($_POST['table'] == "edition" && $_POST['action'] == "create")
		{
			createEdition($_POST['edition_name']);
		}
		else if($_POST['table'] == "edition" && $_POST['action'] == "delete")
		{
			delteEdition($_POST['edition_id']);
		}
		else if($_POST['table'] == "edition" && $_POST['action'] == "show")
		{
			showEditions();
		}
		else if($_POST['table'] == "adtype" && $_POST['action'] == "create")
		{
			createAdType($_POST['adtype_name']);
		}
		else if($_POST['table'] == "adtype" && $_POST['action'] == "delete")
		{
			deleteAdType($_POST['adtype_id']);
		}
		else if($_POST['table'] == "adtype" && $_POST['action'] == "show")
		{
			showAdType();
		}
	}
	else if(is_array($_GET) && $_GET['table'] && isset($_GET['action']))
	{	
		if($_GET['table'] == "newspaper" && $_GET['action'] == "select")
		{
			selectNewspapers();
		}
		else if($_GET['table'] == "edition" && $_GET['action'] == "select")
		{
			selectEditions();
		}
		else if($_GET['table'] == "adtype" && $_GET['action'] == "select")
		{
			selectAdTypes();
		}
		else if($_GET['table'] == "newspaper" && $_GET['action'] == "search")
		{	
			searchNewspaper($_GET['search_str']);
		}
		else if($_GET['table'] == "edition" && $_GET['action'] == "get")
		{
			getEditionChk();
		}
	}
	else
	{
		echo "Failed to connect to database !";
	}
?>