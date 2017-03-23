<?php

    global $_CONN;
    $_CONN = mysqli_connect("localhost", "root", "", "adwala");


    // function to create user in database >>
    function insertUser($user_name, $user_username, $user_email, $user_mobile, $user_password)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to the database !";
            die();
        }

        $currDate = $currDate = date("d-m-y h:m:s");

        $query = "INSERT INTO user (usr_name, usr_email, usr_mobile, usr_username, usr_password, usr_role, usr_createdon)
                  VALUES ('$user_name', '$user_email', '$user_mobile', '$user_username', '$user_password', 'user', '$currDate')";
        $result = mysqli_query($_CONN, $query);

        if($result)
            echo "User Created !";
        else
            echo "Failed to Create user !";
    }


    

?>
