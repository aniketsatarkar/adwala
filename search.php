<?php
	
	// ----------------------
	include_once "dbcred.php";
	// ----------------------

	global $_CONN;
	
    // function to output no data found message,
    // and abort further code execution.
    function noDataFound()
    {
        echo "<div class='row'><div class='col 12 s12 center-align grey-text text-lighten-1'><h3>No Data Has Been Found !</h3><h5>Please Try Again.</h5></div></div>";
        die();
    }

    // function to output something went wrong message,
    // and abort further code execution.
    function somethingWentWrong()
    {
        echo "<div class='col s12 grey-text text-lighten-1 center'><h4>Oops! Something Went Wrong !</h4><h5> Please Try Again. </h5></div>";
        die();
    }

    // function to get Paper Id from paper name.
    function getPaperId($searchStr)
    {
        global $_CONN;

        if(!$_CONN)
            somethingWentWrong();

        $query = "SELECT paper_id FROM newspaper WHERE paper_name LIKE '%$searchStr%'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            noDataFound();

        $paperId = $resultArray[0]['paper_id'];

        return $paperId;
    }

    // function to get Edition ID from edition name.
    function getEditionId($searchStr)
    {
        global $_CONN;

        if(!$_CONN)
            somethingWentWrong();

        $query = "SELECT edition_id FROM edition WHERE edition_name LIKE '%$searchStr%'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            noDataFound();

        $editionId = $resultArray[0]['edition_id'];

        return $editionId;
    }

    // function to get HTML search results for a paper name.
    function getPaperSearchResult($searchStr)
    {
        global $_CONN;

        if(!$_CONN)
            somethingWentWrong();

        $paperId = 0;

        if($id = getPaperId($searchStr))
        {
            $paperId = $id;
        }
        else
            somethingWentWrong();

        $query = "SELECT paper_editions FROM newspaper WHERE paper_id='$paperId'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            noDataFound();

        $editions_str = $resultArray[0]['paper_editions'];

        $query  = "SELECT * FROM edition WHERE edition_id in ($editions_str)";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            noDataFound();

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $editionId = $resultArray[$i]['edition_id'];

            // ------------------------------------------------------
            $edition_name = $resultArray[$i]['edition_name'];
            echo "<li><div class='collapsible-header teal-text'><i class='material-icons teal-text'>location_on</i> $edition_name </div>";
            echo "<div class='collapsible-body'><div class='row'><div class='col s10 offset-s1'><table class='centered'><thead><th>Classified Text</th><th>Classified Display</th><th>Display</th></thead><tbody><tr>";
            // ------------------------------------------------------

            for($j=1; $j<=3; $j++)
            {
                $query = "SELECT * FROM rate WHERE paper_id='$paperId' AND edition_id='$editionId' AND adtype_id=$j";
                $result = mysqli_query($_CONN, $query);
                $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if(sizeof($resultArr) == 0)
                {
                    echo "<td class='flow-text'> N/A";
                    echo "<h6> N/A </h6></td>";
                    continue;
                }

                $rate = $resultArr[0]['rate'];

                echo "<td class='flow-text'>&#8377;$rate";

                if($resultArr[0]['rate_unit'] == "L")
                {
                    $unitCount = $resultArr[0]['unit_count'];
                    echo "<h6>For $unitCount Lines</h6></td>";
                }
                else if($resultArr[0]['rate_unit'] == "W")
                {
                    $unitCount = $resultArr[0]['unit_count'];
                    echo "<h6>For $unitCount Words</h6></td>";
                }
                else if($resultArr[0]['rate_unit'] == "A")
                {
                    echo "<h6> Per CM <sup>2</sup> </h6></td>";
                }

            }// end of inner loop.

            echo "</tr>";
            echo "<tr>";

            for($j=1; $j<=3; $j++)
            {
                $query = "SELECT * FROM rate WHERE paper_id='$paperId' AND edition_id='$editionId' AND adtype_id=$j";
                $result = mysqli_query($_CONN, $query);
                $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if(sizeof($resultArr) == 0)
                {
                    echo "<td><a class='btn-flat blue-text disabled'>Compose</a></td>";
                    continue;
                }

                echo "<td><a class='waves-effect waves-teal btn-flat blue-text' data-paperId='$paperId' data-editionId='$editionId' data-adtypeId='$j'>Compose</a></td>";

            }// end of inner loop.

            echo "</tr></tbody></table></div></div></div></li>";

        }// end of outer loop

        echo "<script type='text/javascript'>$('.btn-flat').click(btn_click);</script>";
    }

    // function to get HTML search results for a edition name.
    function getEditionSearchResult($searchStr)
    {
        global $_CONN;

        if(!$_CONN)
            somethingWentWrong();

        $editionId = 0;

        if($id = getEditionId($searchStr))
        {
            $editionId = $id;
        }
        else
            somethingWentWrong();

        if($editionId == 1)
            $query = "SELECT paper_id, paper_name FROM newspaper WHERE paper_editions REGEXP '^$editionId,'";
        else
            $query = "SELECT paper_id, paper_name FROM newspaper WHERE paper_editions REGEXP '$editionId'";

        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            noDataFound();

        for($i=0; $i<sizeof($resultArray);$i++)
        {
            $paperId = $resultArray[$i]['paper_id'];
            $paperName = $resultArray[$i]['paper_name'];

            // ------------------------------------------------------
            echo "<li><div class='collapsible-header teal-text'><i class='material-icons teal-text'>import_contacts</i>$paperName </div>";
            echo "<div class='collapsible-body'><div class='row'><div class='col s10 offset-s1'><table class='centered'><thead><th>Classified Text</th><th>Classified Display</th><th>Display</th></thead><tbody><tr>";
            // ------------------------------------------------------

            for($j=1; $j<=3; $j++)
            {
                $query = "SELECT * FROM rate WHERE paper_id='$paperId' AND edition_id='$editionId' AND adtype_id=$j";
                $result = mysqli_query($_CONN, $query);
                $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if(sizeof($resultArr) == 0)
                {
                    echo "<td class='flow-text'> N/A";
                    echo "<h6> N/A </h6> </td>";
                    continue;
                }

                $rate = $resultArr[0]['rate'];

                echo "<td class='flow-text'>&#8377;$rate";

                if($resultArr[0]['rate_unit'] == "L")
                {
                    $unitCount = $resultArr[0]['unit_count'];
                    echo "<h6>For $unitCount Lines</h6></td>";
                }
                else if($resultArr[0]['rate_unit'] == "W")
                {
                    $unitCount = $resultArr[0]['unit_count'];
                    echo "<h6>For $unitCount Words</h6></td>";
                }
                else if($resultArr[0]['rate_unit'] == "A")
                {
                    echo "<h6> Per CM <sup>2</sup> </h6></td>";
                }

            }// end of inner loop.

            echo "</tr>";
            echo "<tr>";

            for($j=1; $j<=3; $j++)
            {
                $query = "SELECT * FROM rate WHERE paper_id='$paperId' AND edition_id='$editionId' AND adtype_id=$j";
                $result = mysqli_query($_CONN, $query);
                $resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if(sizeof($resultArr) == 0)
                {
                    echo "<td><a class='btn-flat blue-text disabled'>Compose</a></td>";
                    continue;
                }

                echo "<td><a class='waves-effect waves-teal btn-flat blue-text' data-paperId='$paperId' data-editionId='$editionId' data-adtypeId='$j'>Compose</a></td>";

            }// end of inner loop.

            echo "</tr></tbody></table></div></div></div></li>";

        }// end of outer loop

        echo "<script type='text/javascript'>$('.btn-flat').click(btn_click);</script>";

    }// end of function.
	
	// PAGE EXECUTION LOGIC ---------------------------
	if(isset($_GET['table']) && isset($_GET['action']))
	{
		if($_GET['table'] == "newspaper" && $_GET['action'] == "getSearchResults")
		{
			$searchStr = $_GET['search_string'];
			getPaperSearchResult($searchStr);
		}
		else if($_GET['table'] == "edition" && $_GET['action'] == "getSearchResults")
		{
			$searchStr = $_GET['search_string'];
			getEditionSearchResult($searchStr);
		}
		else
			echo "FUCK PHP !"; 
	}
	
?>