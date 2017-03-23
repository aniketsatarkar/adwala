<?php

	include_once "dbcred.php";

	global $_CONN;

	if(!$_CONN)
	{
		echo "Failed to Connect to Database !";
		die();
	}
	
	// function to get all entities about a paper >>
	function getPaperEntity($paperId)
	{
		global $_CONN;

		$query = "SELECT paper_editions FROM newspaper WHERE paper_id='$paperId'";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

		if(sizeof($resultArray) == 0) die();

		$editions_str = $resultArray[0]['paper_editions'];

		$query  = "SELECT * FROM edition WHERE edition_id in ($editions_str)";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

		if(sizeof($resultArray) == 0) die();

		for($i=0; $i<sizeof($resultArray); $i++)
		{
			$editionId = $resultArray[$i]['edition_id'];

			// ------------------------------------------------------
			$edition_name = $resultArray[$i]['edition_name'];
			echo "<li><div class='collapsible-header teal-text'><i class='material-icons teal-text'>location_on</i> $edition_name </div>";
			// ------------------------------------------------------

			echo "<div class='collapsible-body'><div class='row'><div class='col s10 offset-s1'><table class='centered'><thead><th>Classified Text</th><th>Classified Display</th><th>Display</th></thead><tbody><tr>";

			for($j=1; $j<=3; $j++)
			{
				$query = "SELECT * FROM rate WHERE paper_id='$paperId' AND edition_id='$editionId' AND adtype_id=$j";
				$result = mysqli_query($_CONN, $query);
				$resultArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

				if(sizeof($resultArr) == 0)
				{
					echo "<td class='flow-text'> N/A </td>";
					continue;
				}

				$rate = $resultArr[0]['rate'];

				echo "<td class='flow-text'>&#8377;$rate</td>";

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

			echo "<script type='text/javascript'>
						$('.btn-flat').click(btn_click);
					  </script>";


		}// end of outer loop
	}// end of function


	// function to get paper logo from paper id >>
	function getPaperLogo($paperId)
	{
		global $_CONN;

		if(!$_CONN)
		{
			echo "Failed to connect to the database !";
			die();
		}

		$query = "SELECT paper_logo FROM newspaper WHERE paper_id=$paperId";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}

		$logo = $resultArray[0]['paper_logo'];
		echo "<img style='padding-top:40px; padding-bottom:20px; margin:auto' src='" . $logo  . "'>";
	}

	// function to get paper Description from paper id >>
	function getPaperDescription($paperId)
	{
		global $_CONN;

		if(!$_CONN)
		{
			echo "Failed To Connect To Database !";
			die();
		}

		$query = "SELECT paper_desc FROM newspaper WHERE paper_id=$paperId";
		$result = mysqli_query($_CONN, $query);
		$resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

		if(sizeof($resultArray) == 0)
		{
			echo "No Data Found !";
			die();
		}

		echo $resultArray[0]['paper_desc'];
	}

?>