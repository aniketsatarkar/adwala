<?php

	include_once "dbcred.php";
	
	
	function createAdv($adv_type, $adv_text, $adv_image, $newspaper_id, $adv_dates, $payment_status, $transaction_id, $adv_status, $posted_by)
	{
		// create a advertisement token by encrypting advertisement text to md5 hash.
		$token = md5($adv_text);
		
		// return false if connection is available.
		if(!$_CONN)
			return false;
		
		$token = mysqli_escape_string($_CONN, $token);
		
		$query = "SELECT COUNT(*) FROM advertisement WHERE token='$token'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
			return false;
		
		$adv_type 		= mysqli_escape_string($_CONN, $adv_type);
		$adv_text 		= mysqli_escape_string($_CONN, $adv_text);
		$adv_image 		= mysqli_escape_string($_CONN, $adv_image);
		$newspaper_id 	= mysqli_escape_string($_CONN, $newspaper_id);
		$adv_dates 		= mysqli_escape_string($_CONN, $adv_dates);
		$payment_status = mysqli_escape_string($_CONN, $payment_status);
		$transaction_id = mysqli_escape_string($_CONN, $transaction_id);
		$adv_status 	= mysqli_escape_string($_CONN, $adv_status);
		$posted_by 		= mysqli_escape_string($_CONN, $posted_by);
		
		$query = "INSERT INTO advertisement(token, adv_type, adv_text, adv_image, newspaper_id, adv_dates, payment_status, transaction_id, adv_status, posted_by) VALUES ('$token', '$adv_type', '$adv_text', '$adv_image', '$newspaper_id', '$adv_dates', '$payment_status', '$transaction_id', '$adv_status', '$posted_by')";
			
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		return $resultArray;
	}
	
	// function to delete an advertisement from table using its id.
	function deleteAdv($adv_id)
	{
		if(!$_CONN)
			return false;
		
		$adv_id = mysqli_escape_string($_CONN, $adv_id);
		$query  = "DELETE FROM advertisement WHERE id='$adv_id'";
		$result = mysqli_query($_CONN, $query);  
		
		return $result;
	}
			
	// function to create a newspaper in newspaper table.
	function createNewspaper($name, $lang, $regions, $logo)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$name = mysqli_escape_string($_CONN, $name); 
		$lang = mysqli_escape_string($_CONN, $lang);
		$regions = mysqli_escape_string($_CONN, $regions);
		$logo = mysqli_escape_string($_CONN, $logo);
		
		$query = "SELECT COUNT(*) FROM newspaper WHERE paper_name='$name'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
		{
			echo "Newspaper, $name already exists.";
			return false;
		}
		
		$query = "INSERT INTO newspaper(paper_name, paper_lang, paper_editions, paper_logo) VALUES ('$name', '$lang', '$regions', '$logo')";
	
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Newspaper Created !";
		else
			echo "Failed To create Newspaper !";
	}
	
	function showNewspapers($paper_id = null)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		// Check if there is data to show >>
		$query = "SELECT * FROM newspaper";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}
		else
		{
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "<th>Language</th>";
			echo "<th>Regions</th>";
			echo "<th>Icon</th>";
			echo "</tr>";

			for($i=0; $i<sizeof($resultArray); $i++)
			{
				echo "<tr>";
				echo "<td>" . $resultArray[$i]['paper_id'] . "</td>";
				echo "<td>" . $resultArray[$i]['paper_name'] . "</td>";
				echo "<td>" . $resultArray[$i]['paper_lang'] . "</td>";
				echo "<td>" . $resultArray[$i]['paper_editions'] . "</td>";
				echo "<td>" . $resultArray[$i]['paper_logo'] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		}
    }
	
	// function to delete a newspaper from newspaper table.
	function deleteNewspaper($id)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$id = mysqli_escape_string($_CONN, $id);
		
		$query = "SELECT COUNT(*) FROM newspaper WHERE paper_id='$id'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
		{
			$query = "DELETE FROM newspaper WHERE paper_id='$id'";
			$result = mysqli_query($_CONN, $query);
			
			if($result)
				echo "Newspaper Deleted !";
			else
				echo "Failed to delete Newspaper !";
		}
		else
		{
			echo "Cannot find newspaper with id $id.";
		}
	}
	
	// function to create a package in packages table.
	function createPackage($name, $description, $offer, $newspaper_id)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$name 		  = mysqli_escape_string($_CONN, $name);
		$description  =  mysqli_escape_string($_CONN, $description);
		$offer 		  = mysqli_escape_string($_CONN, $offer);
		$newspaper_id = mysqli_escape_string($_CONN, $newspaper_id);
		
		$query = "SELECT COUNT(*) FROM package WHERE package_name='$name'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
		{
			echo "Package, $name Already Exists !";
			die();
		}
		
		$query = "INSERT INTO package(package_name, package_desc, package_offer, paper_id) VALUES ('$name', '$description', '$offer', '$newspaper_id')";
		
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Package Created !";
		else
			echo "Failed To Create Package !";
	}
	
	function showPackages()
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		
		$query = "SELECT * FROM package";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Packages Available To Show.";
			return false;
		}
		else
		{
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "<th>Desscription</th>";
			echo "<th>Offer</th>";
			echo "<th>Newspaper</th>";
			echo "</tr>";

			for($i=0; $i<sizeof($resultArray); $i++)
			{
				echo "<tr>";
				echo "<td>" . $resultArray[$i]['package_id'] . "</td>";
				echo "<td>" . $resultArray[$i]['package_name'] . "</td>";
				echo "<td>" . $resultArray[$i]['package_desc'] . "</td>";
				echo "<td>" . $resultArray[$i]['package_offer'] . "</td>";
				echo "<td>" . $resultArray[$i]['paper_id'] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	}
	
	// function to delete a package from packages table.
	function deletePackage($package_id)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$package_id = mysqli_escape_string($_CONN, $package_id);
		
		$query = "SELECT COUNT(*) FROM package WHERE package_id = '$package_id'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] == 0)
		{
			echo "Index did not Found !";
			return false;
		}
		
		$query = "DELETE FROM package WHERE package_id = '$package_id'";
		$result = mysqli_query($_CONN, $query); 
		
		if($result)
			echo "Package Delete !";
		else
			echo "Failed to Delete Package !";
	}
	
	function createEdition($edition_name)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT COUNT(*) FROM edition WHERE edition_name = '$edition_name'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
		{
			echo "Edition Already Exists !";
			die();
		}
		
		$query = "INSERT INTO edition (edition_name) VALUES ('$edition_name')";
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Edition Created !";
		else
			echo "Failed  To Create Edition !";
	}

	function delteEdition($edition_id)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT COUNT(*) FROM edition WHERE edition_id = '$edition_id'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 1)
		{
			echo "Index did not found !";
			die();
		}
		
		$query = "DELETE FROM edition WHERE edition_id = '$edition_id'";
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Edition Deleted !";
		else
			echo "Failed to Delete Edition !";
	}
	
	function showEditions()
	{
		global $_CONN;

		if(!$_CONN)
			return false;
		
		$query = "SELECT * FROM edition";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Edition Available To Show.";
			return false;
		}
		else
		{
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "</tr>";

			for($i=0; $i<sizeof($resultArray); $i++)
			{
				echo "<tr>";
				echo "<td>" . $resultArray[$i]['edition_id'] . "</td>";
				echo "<td>" . $resultArray[$i]['edition_name'] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	}

	function createAdType($adtype_name)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT COUNT(*) FROM adtype WHERE adtype_name = '$adtype_name'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] != 0)
		{
			echo "Ad Type already Exists !";
			die();
		}
		
		$query = "INSERT INTO adtype (adtype_name) VALUES ('$adtype_name')";
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Ad Type Created !";
		else
			echo "Faild To Create Ad Type !";
	}
	
	function  deleteAdType($adtype_id)
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT COUNT(*) FROM adtype WHERE adtype_id = '$adtype_id'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if($resultArray[0][0] == 0)
		{
			echo "Index not found !";
			die();
		}
		
		$query = "DELETE FROM adtype WHERE adtype_id = '$adtype_id'";
		$result = mysqli_query($_CONN, $query);
		
		if($result)
			echo "Ad Type Delete !";
		else
			echo "Failed Delete Ad Type !";
	}
	
	function showAdType()
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT * FROM adtype";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
		}
		else
		{
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Ad Type</th>";
			echo "</tr>";

			for($i=0; $i<sizeof($resultArray); $i++)
			{
				echo "<tr>";
				echo "<td>" . $resultArray[$i]['adtype_id'] . "</td>";
				echo "<td>" . $resultArray[$i]['adtype_name'] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	}
	
	
	// ---------| DUPLICATE OF "getNewspapers()" |---------
	function selectNewspapers()
	{
		global $_CONN;

        if(!$_CONN)
            return false;

        $query = "SELECT paper_id, paper_name FROM newspaper";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            echo "<option value='" . $resultArray[$i]['paper_id'] . "'>" . $resultArray[$i]['paper_name'] . "</option>";
        }
	}
	

	function selectEditions()
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT edition_id, edition_name FROM edition";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		for($i=0; $i<sizeof($resultArray); $i++)
		{
			echo "<option value='". $resultArray[$i]['edition_id'] ."'>" . $resultArray[$i]['edition_name'] . "</option>";
		}
	}
	
	function selectAdTypes()
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT adtype_id, adtype_name FROM adtype";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		for($i=0; $i< sizeof($resultArray); $i++)
		{
			echo "<option value='". $resultArray[$i]['adtype_id'] ."'>" . $resultArray[$i]['adtype_name'] . "</option>";
		}
	}
	
	
	// function to get newspaper from newspaper table using
    // edition id.
    function getNewspapersByEdition($editionId)
    {
        global $_CONN;

        if(!$_CONN)
            return false;

        $query = "SELECT * FROM newspaper WHERE paper_editions LIKE '%$editionId%'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result);

        //print_r($resultArray);
    }


    // Function to get all edition of the newspaper
    // using editions string.
    function getEditionsByPaper($editionList)
    {
        global $_CONN;

        if(!$_CONN)
            return false;

        $query = "SELECT * FROM adwala.edition WHERE edition_id IN ($editionList)";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        //print_r($resultArray);
    }


    // function to search newspaper name.
    function searchNewspaper($searchString)
    {
        global $_CONN;

        if(!$_CONN)
            return false;

        $query = "SELECT * FROM newspaper WHERE paper_name LIKE '%$searchString%'";
        $result = mysqli_query($_CONN, $query);

        if($result != null)
        {
            $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
            $resultSet = "";

            for($i=0; $i<sizeof($resultArray); $i++)
                $resultSet .=  $resultArray[$i]['paper_name'] . ",";

            echo $resultSet;
        }
    }


    // function to search edition names.
    function searchEdition($searchString)
    {
        global $_CONN;

        if(!$_CONN)
            return false;

        $query = "SELECT * FROM edition WHERE edition_name LIKE '%$searchString%'";
        $result = mysqli_query($_CONN, $query);

        if($result != null)
        {
            $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
            $resultSet = "";

            for($i=0; $i<sizeof($resultArray); $i++)
                $resultSet .= $resultArray[$i]['edition_name'];

            echo $resultSet;
        }
    }
	
	// function to get html input boxes.
	function getEditionChk()
	{
		global $_CONN;
		
		if(!$_CONN)
			return false;
		
		$query = "SELECT * FROM edition";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);
		
		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$edition_name = $resultArray[$i]['edition_name'];
			$edition_id = $resultArray[$i]['edition_id'];
			
			echo "<input type='checkbox' value='$edition_id'>" . $edition_name . "</input>";
		}
	}
	
?>