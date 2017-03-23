<?php
	@session_start();
?>

<?php

    include_once "dbcred.php";

	// function to get HTML selection element,
	// with newspaper values.
    function getNewsPaperSelect()
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to database !";
            die();
        }

        $query = "SELECT paper_id, paper_name FROM newspaper";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found";
            die();
        }
		
        //echo "<select id='paper_selection' onchange='paperSelection()'>";
		echo "<option value='' disabled selected> Select Newspaper </option> ";
		
        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $paperId = $resultArray[$i]['paper_id'];
            $paperName = $resultArray[$i]['paper_name'];

            echo "<option value='$paperId'> $paperName </option>";
        }

        //echo "</select>";
		echo "<label>Select Newspaper</label>";
    }

	// function to get an HTML selection element,
	// with edition values.
    function getEditionSelect($paperId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to the database !";
            die();
        }

        $query = "SELECT paper_editions FROM newspaper WHERE paper_id = $paperId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

		$editionsList = $resultArray[0]['paper_editions']; 
		
		$query = "SELECT edition_id, edition_name FROM edition WHERE edition_id IN ($editionsList)";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}
		
        //echo "<select id='edition_selection' onchange='editionSelection()'>";
		
		echo "<option value='' disabled selected> Select Edition </option>";
		
        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $editionId   = $resultArray[$i]['edition_id'];
            $editionName = $resultArray[$i]['edition_name'];

            echo "<option value='$editionId'> $editionName </option>";
        }

        //echo "</select>";
		//echo "<label>Select Edition</label>";
    }
	
	
	function getAdtypeSelect()
	{
		global $_CONN;
		
		if(!$_CONN)
		{
			echo "Failed to Connect to the database !";
			die();
		}
		
		$query = "SELECT adtype_id, adtype_name FROM adtype";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}
		
		echo "<option value='' disabled selected>Select Ad-Type</option>";
		
		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$adtypeId = $resultArray[$i]['adtype_id'];
			$adtypeName = $resultArray[$i]['adtype_name'];
			
			echo "<option value='$adtypeId'> $adtypeName </option>";
		}
	}
	
	
	// function to get classidfied ad type selection
	// dropdown. 
	function getClassifiedSelect()
	{
		global $_CONN;
		
		if(!$_CONN)
		{
			echo "Failed to connect to the database !";
			die();
		}
		
		$query = "SELECT class_id, class_name FROM classifiedtype";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Recived !";
			die();
		}
	
		echo "<option value='' disabled selected>Select Classified Catagory</option>";
	
		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$classId = $resultArray[$i]['class_id'];
			$className = $resultArray[$i]['class_name'];
			
			echo "<option value='$classId'> $className </option>";
		}
	}
	
	
	// function to get newspaper logo, wrapped in img tag >>
	function getPaperLogo($paper_id)
	{
		global $_CONN;
			
		if(!$_CONN)
		{
			echo "Failed to connect to the database ! ";
			die();
		}
		
		$query = "SELECT paper_logo FROM newspaper WHERE paper_id = $paper_id";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}
			
		$logo_src = $resultArray[0]['paper_logo'];
			
		echo "<img width='150' src='$logo_src'>";
	}

	
	// function to get rate for selected paper, edition and adtype,
	// as json string.
	function getRate($paper_id, $edition_id, $adtype_id)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT * FROM rate WHERE paper_id = $paper_id AND edition_id = $edition_id AND adtype_id = $adtype_id";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        echo json_encode($resultArray);
    }
	
	
	// Page execution Logic >>
	if(isset($_GET['table']) && isset($_GET['action']))
	{
		if($_GET['table'] == "edition" && $_GET['action'] == "getselect")
		{
			getEditionSelect($_GET['paper_id']);
		}
		else if($_GET['table'] == "rate" && $_GET['action'] == "getrate")
		{
			$paper_id   = $_SESSION["paper_id"];
			$edition_id = $_SESSION["edition_id"];
			$adtype_id  = $_SESSION["adtype_id"];
			
			getRate($paper_id, $edition_id, $adtype_id);
		}
		else if($_GET['table'] == "classifiedtype" && $_GET['action'] == "getclassifiedselect")
		{
			getClassifiedSelect();
		}
	}
	else if(isset($_POST['action']))
	{
		if(isset($_POST['paper_id']) && isset($_POST['edition_id']))
		{
			session_start();
			
			$_SESSION['paper_id']   = $_POST['paper_id'];
			$_SESSION['edition_id'] = $_POST['edition_id'];
		}
	}
	else if(isset($_POST['key']) && isset($_POST['value']))
	{
		@session_start();
			
		$element_name = $_POST['key'];
		$element_value = $_POST['value'];
			
		$_SESSION[$element_name] = $element_value;
			
		echo "success";
	}
	
?>