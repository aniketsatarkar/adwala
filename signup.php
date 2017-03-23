<?php

    include_once "dbcred.php";

    function failedResult()
    {
        echo json_encode(array("status" => "failed", "message"=> "Failed To Create User!"));
    }

    function successResult()
    {
        echo json_encode(array("status" => "success", "message" => "User Created Successfully!"));
    }


    function signUpUser($user_name, $user_username, $user_email, $user_mobile, $user_password)
    {
        global $_CONN;

        if(!$_CONN)
        {
            failedResult();
            die();
        }

        $query = "SELECT * FROM user WHERE usr_name='$user_name' OR usr_email='$user_email' OR usr_mobile='$user_mobile' OR usr_username='$user_username'";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
        if(sizeof($resultArray) != 0)
        {
            $name     = $resultArray[0]['usr_name'];
            $email    = $resultArray[0]['usr_email'];
            $mobile   = $resultArray[0]['usr_mobile'];
            $username = $resultArray[0]['usr_username'];

            if($user_username == $username)
            {
                echo json_encode(array("status" => "failed", "message" => "d_username"));
                die();
            }
            else if($user_email == $email)
            {
                echo json_encode(array("status" => "failed", "message" => "d_email"));
                die();
            }
            else if($user_mobile == $mobile)
            {
                echo json_encode(array("status" => "failed", "message" => "d_mobile"));
                die();
            }
        }

        $currDate = $currDate = date("d-m-y h:m:s");

        $query = "INSERT INTO user (usr_name, usr_email, usr_mobile, usr_username, usr_password, usr_role, usr_createdon)
                      VALUES ('$user_name', '$user_email', '$user_mobile', '$user_username', '$user_password', 'user', '$currDate')";

        $result = mysqli_query($_CONN, $query);

        if($result)
            successResult();
        else
            failedResult();
    }

    // Execution Logic >>>
    if(is_array($_POST) && isset($_POST['table']) && isset($_POST['action']))
    {
        if($_POST['table'] == "user" && $_POST['action'] =="create")
        {
            $name     = $_POST['user_name'];
            $email    = $_POST['user_email'];
            $mobile   = $_POST['user_mobile'];
            $username = $_POST['user_username'];
            $password = $_POST['user_password'];

            signUpUser($name, $username, $email, $mobile, $password);
        }
    }

?>