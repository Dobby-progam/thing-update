<?php

$env = parse_ini_file('.env');

$host = $env['host'];
$user = $env['user'];
$password = $env['password'];
$database = $env['database'];


         $conn = new mysqli($host, $user, $password, $database) or die('could not connect');

         $query = "SELECT * FROM auth WHERE username = 'MiataBoy'";
         $result = $conn->prepare($query);
         //$result->bind_param("s", $_POST['uname']);
         echo $query;
         $result->execute();
         $result->store_result();


         if ($result->num_rows == 0) {
             $password = password_hash($_POST["psw"], PASSWORD_DEFAULT);

             $username = $_POST['uname'];
             $query = "INSERT INTO auth (username, password) VALUES (?, ?)";
             $stmt = $conn->prepare($query);
             $stmt->bind_param("ss", $username, $password);
             $stmt->execute();
         } else {
             if (password_verify($_POST['psw'], $result)) {
                 echo 'password correct';
             }
             $conn->close();
         }
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <title>Authenticating...</title>
    </head>

    <body>
        <h1>Authenticating... Wait...</h1>
    </body>

</html>
