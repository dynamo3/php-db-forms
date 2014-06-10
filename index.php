<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    phpinfo();

    $errors = array();

    if($_POST) {

        print_r($_POST);
        if($_POST['password'] != $_POST['password2']) {
            array_push($errors, "passwords do not match");
        }

        $mysqli = new mysqli("localhost", "root", "", "userreg");
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .
                $mysqli->connect_error;
        }

        $query = "SELECT * FROM user WHERE username = \"{$_POST['username']}\"";
        echo $query;

        $results = $mysqli->query($query);
        if($results->num_rows > 0) {
            array_push($errors, "username exists");
        } else {
            //echo "username available";
            $insert = "INSERT INTO user (firstname, lastname, username, password) " .
                "VALUES (\"{$_POST['firstname']}\", \"{$_POST['lastname']}\", " .
                "\"{$_POST['username']}\", \"{$_POST['password']}\") " ;
            echo $insert;
            $mysqli->query($insert);
            if($mysqli->errno()) {
                echo "there was an error: " . $mysqli->error();
            }
        }


        //print_r($results);

        
    }
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <div><?php print_r($errors); ?></div>
    <form action="index.php" method="POST">
        First: <input type="text" name="firstname"><br>
        Last: <input type="text" name="lastname"><br>
        Username: <input type="text" name="username"><br>
        Password: <input type="text" name="password"><br>
        Password 2: <input type="text" name="password2"><br>

        <button type="submit">Go</button>
    </form>
</body>
</html>