<?php
    session_start();
?>

<?php

include_once "dbcred.php";


    // function to change password of user account.
    // using session values.
    function changePassword($newPassword)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Faield To Connect To The Database !";
            die();
        }

        if(!isset($_SESSION['user_id']))
        {
            echo "User Not Logged In !";
            die();
        }

        $userId = $_SESSION['user_id'];

        $query = "UPDATE user SET usr_password = '$newPassword' WHERE usr_id='$userId'";

        $result = mysqli_query($_CONN, $query);

        if($result)
            echo "Password Changed Successfully !";
        else
            echo "Failed Change Password !";
    }

    // function to change user specific data, using
    // session values.
    function changeUserData($name, $username, $email, $mobile, $state, $city, $address)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        if(!isset($_SESSION['user_id']))
        {
            echo "User Not Logged In !";
            die();
        }

        $userId   = $_SESSION['user_id'];

        $query = "UPDATE user SET
					usr_name='$name', usr_email='$email', usr_mobile='$mobile',
					usr_username='$username', usr_address='$address',
					usr_city='$city', usr_state='$state' WHERE $userId";

        $result = mysqli_query($_CONN, $query);

        if($result)
            echo "Data Successfully Updated !";
        else
            echo "Failed To Update Data !";
    }

    // function to get user specific data.
    function getUserData()
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to the database";
            die();
        }

        if(!isset($_SESSION['user_id']))
        {
            echo "User Not Logged In";
        }

		$userId = $_SESSION['user_id'];

        $query = "SELECT usr_name, usr_email, usr_mobile, usr_username, usr_address, usr_city, usr_state
                  FROM user WHERE usr_id = $userId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Received !";
            die();
        }

        echo json_encode($resultArray);
    }


    // ------ Execution Logic ------
	if(is_array($_POST))
    {
        // check if request is for changing the password !
        if(isset($_POST['curr_pass']) && isset($_POST['new_pass']))
        {
            changePassword($_POST['new_pass']);
        }
        // change if request is for changing user data !
        else if(isset($_POST['table']) && isset($_POST['action']))
        {
            if($_POST['table'] == "user" && $_POST['action'] == "update")
            {
                $name 	  =  $_POST['new_name'];
                $username =  $_POST['new_username'];
                $email    =  $_POST['new_email'];
                $mobile   =  $_POST['new_mobile'];
                $state    =  $_POST['new_state'];
                $city     =  $_POST['new_city'];
                $address  =  $_POST['new_address'];

                changeUserData($name, $username, $email, $mobile, $state, $city, $address);
            }
        }
    }
    
	if(is_array($_GET))
    {
		if(isset($_GET['table']) && isset($_GET['action']))
		{
			if($_GET['table'] == "user" && $_GET['action'] == "getdata")
				getUserData();
		}
    }

?>