<?php

    global $_CONN;
    $_CONN = mysqli_connect("localhost", "root", "", "adwala");

    // function to get rate from paper, edition and adtype ids,
    // in json format.
    function getRate($paper_id, $edition_id, $adtype_id)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to the database !";
            die();
        }

        $query = "SELECT * FROM rate WHERE paper_id = $paper_id
                    AND edition_id = $edition_id AND adtype_id = $adtype_id";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "failed";
            die();
        }

        echo json_encode($resultArray);
    }

    // function to get option element hydrated with
    // newspaper id and name values.
    function getPaperSelectOptions()
    {
        global $_CONN;

        if(!$_CONN)
            die();

        $query  = "SELECT * FROM newspaper";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            die();

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $paper_id = $resultArray[$i]['paper_id'];
            $paper_name = $resultArray[$i]['paper_name'];

            echo "<option value='$paper_id'> $paper_name </option>";
        }
    }

    // function to get edition element hydrated with
    // edition id and name values.
    function getEditionSelectOptions()
    {
        global $_CONN;

        if(!$_CONN)
            die();

        $query = "SELECT * FROM edition";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray)==0)
            die();

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $edition_id = $resultArray[$i]['edition_id'];
            $edition_name = $resultArray[$i]['edition_name'];

            echo "<option value='$edition_id'>$edition_name</option>";
        }
    }

    // function to get edition element hydrate with
    // adtype id and name values.
    function getAdtypeSelectOptions()
    {
        global $_CONN;

        if(!$_CONN)
            die();

        $query = "SELECT * FROM adtype";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
            die();

        for($i=0;  $i<sizeof($resultArray); $i++)
        {
            $adtype_id = $resultArray[$i]['adtype_id'];
            $adtype_name = $resultArray[$i]['adtype_name'];

            echo "<option value='$adtype_id'> $adtype_name </option>";
        }
    }

    // function to set session value.
    function setSessionDate($key, $value)
    {
        if(isset($_SESSION))
            $_SESSION[$key] = $value;
        else
            echo "failed";
    }

    // Page Execution Logic >>>
    if(is_array($_GET) && isset($_GET['table']) && isset($_GET['action']))
    {
        if($_GET['table'] == "rate" && $_GET['action'] == "get")
        {
            $paper_id   = $_GET['paper_id'];
            $edition_id = $_GET['edition_id'];
            $adtype_id  = $_GET['adtype_id'];

            getRate($paper_id, $edition_id, $adtype_id);
        }
        else if($_GET['table'] == "newspaper" && $_GET['action'] == "getoptions")
        {
            getPaperSelectOptions();
        }
        else if($_GET['table'] == "edition" && $_GET['action'] == "getoptions")
        {
            getEditionSelectOptions();
        }
        else if($_GET['table'] == "adtype" && $_GET['action'] == "getoptions")
        {
            getAdtypeSelectOptions();
        }
    }
    else if(is_array($_POST) && isset($_POST['key']) && isset($_POST['value']))
    {
        setSessionDate($_POST['key'], $_POST['value']);
    }

?>