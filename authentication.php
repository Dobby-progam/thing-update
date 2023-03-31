<?php
// TODO: Add mail addresses
// TODO: Add user IDs (auto increment)
// TODO: Make user IDs primary key
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
    if (!empty(dbCommand('SELECT username FROM auth WHERE username = ?', [$_POST['uname']]))) {
        session_start();
        $_SESSION['badlogin'] = 403;
        header("Location: register.php");
        exit();
    }

    $passwordHash = password_hash($_POST["psw"], PASSWORD_DEFAULT);
    $handled = dbCommand('INSERT INTO auth (username, password) VALUES (?, ?)', [$_POST['uname'], $passwordHash]);
    echo $handled;
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