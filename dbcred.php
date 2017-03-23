<?php

	global $_HOST; 	// database host name. 
	global $_USER;	// database username.
	global $_PASS;	// database password.
	global $_DB;	// database name.
	global $_CONN;	// global connection object.
	
	// Initialize global variables.
	$_HOST = "localhost";
	$_USER = "root";
	$_PASS = "";
	$_DB   = "adwala";
		
	$_CONN = mysqli_connect($_HOST, $_USER, $_PASS, $_DB); 
	
	/*
     * This function is used to maintain the backward comparability
     * of the code as there is no definition of this function in the
     * PHP library of version 5.3 or less.
     * $result -> mysqli result object resource.
     * $option -> MYSQLI_ASSOC, MYSQLI_BOTH or MYSQLI_NUM
     * return  -> multidimensional array of all rows from the result,
     *            otherwise null.
    
    function mysqli_fetch_all($result, $option)
    {
        $resultArray = array();

        if($option == MYSQLI_ASSOC)
            while($row = mysqli_fetch_assoc($result))
                $resultArray[] = $row;
        else if($option == MYSQLI_NUM)
            while($row = mysqli_fetch_array($result))
                $resultArray[] = $row;
        else if($option == MYSQLI_BOTH)
            while($row_assoc = mysqli_fetch_assoc($result)
                  && $row_num = mysqli_fetch_array($result))
            {
                $resultArray[] = $row_num;
                $resultArray[] = $row_assoc;
            }
        else
            return null;

        return $resultArray;
    }
    */
	
?>