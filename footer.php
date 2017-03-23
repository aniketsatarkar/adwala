<?php
	
	include_once "dbcred.php";

    global $_CONN;

    if(!$_CONN)
    {
        echo "Failed To connect to Database !";
        die();
    }

    // function to get Paper Select Drop down.
    // supposed to be used in footer >>>
    function getPaperSelect()
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT paper_id, paper_name FROM newspaper";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        echo "<a class='dropdown-button btn' href='#' data-activates='paperSelectDropDown'>Select Paper</a>";
        echo "<ul id='paperSelectDropDown' class='dropdown-content'>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $paperId = $resultArray[$i]['paper_id'];
            $paperName = $resultArray[$i]['paper_name'];

            $href = "paper.php?paperId=$paperId";

            echo "<li><a href='$href'>$paperName</a></li>";
        }

        echo "</ul>";
    }

?>