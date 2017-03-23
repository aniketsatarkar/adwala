<?php

	global $conn;
	$conn = mysqli_connect("localhost", "root", "", "adwala");

	// function to get newspaper names in a json format,
	// which will be used as a data for autocomplete element
	// of materialze.
	function getPaperData()
	{
		global $conn;

		if(!$conn)
		{
			echo "Failed to connect to database !";
			die();
		}

		$query = "SELECT paper_name FROM newspaper";
		$result = mysqli_query($conn, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

		$outputArray = array();

		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$outputArray += array($resultArray[$i]['paper_name'] => null);
		}

		echo json_encode($outputArray);
	}

	// function to  get edition names as data to be used with
	// autocomplete element of materialize.
	function getEditionData()
	{
		global $conn;

		if(!$conn)
		{
			echo "Failed to connect to database !";
			die();
		}

		$query = "SELECT edition_name FROM edition";
		$result = mysqli_query($conn, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

		$outputArray = array();

		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$outputArray += array($resultArray[$i]['edition_name'] => null);
		}

		echo json_encode($outputArray);
	}
	
	
	// code execution logic >>>>
	if(is_array($_GET) && isset($_GET['table']) && isset($_GET['action']))
	{
		if($_GET['table'] == "newspaper" && $_GET['action'] == "getdata")
		{
			getPaperData();
		}
		else if($_GET['table'] == "edition" && $_GET['action'] == "getdata")
		{
			getEditionData();
		}
	}

?>