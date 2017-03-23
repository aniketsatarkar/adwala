<?php

    global $_CONN;

    $_CONN = mysqli_connect("localhost", "root", "", "adwala");

    if(!$_CONN)
    {
        echo "Failed to connect to the database !";
        die();
    }

    // function to get edition table for modernizer,
    // which will be populated by database query using
    // newspaper name.
    function getEditionTable($newspaper_str)
    {
        global $_CONN;

        $query = "SELECT paper_id, paper_editions FROM newspaper WHERE paper_name LIKE '$newspaper_str'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        if(sizeof($resultArray) == 0)
        {
            noDataFound();
            return false;
        }

		// ------------------------------------------------
		session_start();
		$_SESSION['paper_id'] = $resultArray[0]['paper_id'];
		// ------------------------------------------------
		
        $editions_str = $resultArray[0]['paper_editions'];

        $query = "SELECT * FROM edition WHERE edition_id IN ($editions_str)";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        if(sizeof($resultArray) == 0)
        {
            noDataFound();
            return false;
        }

        $output = "<table class='table centered highlight'>
				<thead>
					<tr>
						<th>Paper Edition</th>
					</tr>
				</thead>
				<tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $edition_name = $resultArray[$i]['edition_name'];
            $edition_id   = $resultArray[$i]['edition_id'];

            $output .= "<tr>
					<td>$edition_name</td>
						<td>
						    <a id='table_btn' class='waves-effect waves-light btn' onclick='cedition_btn_click($edition_id)'>Compose Ad
						    </a>
                    </td>
                </tr>";
        }

        $output .= "</tbody></table>";

        echo $output;
    }

    // function to get newspaper table for modernizer,
    // which will be populated by database query using
    // edition id string.
    function getNewspaperTable($edition_str)
    {
        global $_CONN;

        $query = "SELECT edition_id FROM edition WHERE edition_name = '$edition_str'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        if(sizeof($resultArray) == 0)
        {
            noDataFound();
            return false;
        }

        $edition_id = $resultArray[0]['edition_id'];

		// ------------------------------------------------
		session_start();
		$_SESSION['edition_id'] = $edition_id;
		// ------------------------------------------------
		
        if($edition_id == 1)
            $query = "SELECT * FROM newspaper WHERE paper_editions REGEXP '^$edition_id,'";
        else
            $query = "SELECT * FROM newspaper WHERE paper_editions REGEXP '$edition_id'";

        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

        if(sizeof($resultArray) == 0)
        {
            noDataFound();
            return false;
        }

        $output = "<table class='table centered highlight'>
				<thead>
					<tr>
						<th>Paper Name</th>
					</tr>
				</thead>
				<tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {

            $paper_name = $resultArray[$i]['paper_name'];
            $paper_id   = $resultArray[$i]['paper_id'];

            $output .= "<tr>
						    <td>$paper_name</td>
						    <td>
						        <a id='table_btn' class='waves-effect waves-light btn' onclick='cpaper_btn_click($paper_id)'>
						        Compose Ad
						        </a>
                            </td>
					    </tr>";
        }

        $output .= "</tbody> </table>";

        echo $output;
    }

    // function to output no data found message
    // for modernizer.
    function noDataFound()
    {
        echo "<div class='row'>
				<div class='col 12 s12 center-align grey-text text-lighten-1'>
					<h3>No Data Has Been Found !</h3>
					<h5>Please Try Again.</h5>
				</div>
			</div>";
    }


    // page flow logic >>>
    if(is_array($_GET)
        && isset($_GET['table'])
        && isset($_GET['action'])
        && isset($_GET['search_str']))
    {
        if($_GET['table'] == "newspaper" && $_GET['action'] == "search")
        {
            getNewspaperTable($_GET['search_str']);
        }
        else if($_GET['table'] == "edition" && $_GET['action'] == "search")
        {
            getEditionTable($_GET['search_str']);
        }
    }

?>