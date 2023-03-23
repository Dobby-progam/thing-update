<?php

$env = parse_ini_file('.env');

$user = $env['user'];
$password = $env['password'];

$conn = new PDO('mysql:host=localhost;dbname=atomicforum', $user, $password);
//$conn = new mysqli($host, $user, $password, $database) or die('could not connect');

$stmt = $conn->prepare("SELECT password FROM auth WHERE username = ?");
$stmt->execute([$_POST["uname"]]);

$result = $stmt->fetch();
//var_dump($row);

if (empty($result)) {
    $password = password_hash($_POST["psw"], PASSWORD_BCRYPT);

    $username = $_POST['uname'];
    $query = $conn->prepare("INSERT INTO auth (username, password) VALUES (?, ?)");
    $query->execute([$_POST["uname"], $password]);
} else {
    if (password_verify($_POST['psw'], $result['password'])) {
        echo 'password correct';
    } else {
        echo "False password";
    }
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