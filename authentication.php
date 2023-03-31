<?php

function dbCommand(string $query, array $parameters) : mixed {
    $env = parse_ini_file('.env');

    $user = $env['USER'];
    $password = $env['PASSWORD'];

    $conn = new PDO('mysql:host=localhost;dbname=atomicforum', $user, $password);

    $stmt = $conn->prepare($query);
    $stmt->execute($parameters);
    return $stmt->fetch();
}

function verifyPassword(string $password) : bool {
    if (password_verify($_POST['psw'], $password)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['registration'])) {
    echo 'new';
} elseif (isset($_POST['login'])) {
    $username = dbCommand('SELECT username FROM auth WHERE username = ?', [$_POST['uname']]);
    var_dump($username);

    if (empty($username)) {
        session_start();
        $_SESSION['badlogin'] = 404;
        header("location: login.php");
        exit();
    } else {

        $userPassword = dbCommand('SELECT password FROM auth WHERE username = ?', [$_POST['uname']]);
        $correctPassword = verifyPassword($userPassword['password']);

        if ($correctPassword) {
            echo 'password correct';
        } else {
            echo 'password bad';
            session_start();
            $_SESSION['badlogin'] = 403;
            header("Location: login.php");
            exit();
        }
    }


}
//
//if (empty($result)) {
//    $password = password_hash($_POST["psw"], PASSWORD_DEFAULT);
//
//    $username = $_POST['uname'];
//    $query = $conn->prepare("INSERT INTO auth (username, password) VALUES (?, ?)");
//    $query->execute([$_POST["uname"], $password]);
//} else {
//    if (password_verify($_POST['psw'], $result['password'])) {
//        echo 'password correct';
//    } else {
//        session_start();
//        $_SESSION['badlogin'] = "password";
//        header("Location: login.php");
//        exit();
//    }
//}