<?php
use JetBrains\PhpStorm\NoReturn;

function dbCommand(string $query, array $parameters) : mixed {
    $env = parse_ini_file('example.env');

    $user = $env['USER'];
    $password = $env['PASSWORD'];

    $conn = new PDO('mysql:host=localhost;dbname=atomicforum', $user, $password);

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetch();
    } catch (PDOException $error) {
        return [$error->getCode(), $error];
    }
}

function verifyPassword(string $password) : bool {
    if (password_verify($_POST['psw'], $password)) {
        return true;
    } else {
        return false;
    }
}

function isMail(string $mail) : bool {
    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

#[NoReturn] function redirect(string $page, int $code) : void {
    session_start();
    $_SESSION['badAuth'] = $code;
    header("Location: $page");
    exit();
}

function getAuthenticationStatus() : mixed {
    session_start();
    if (isset($_SESSION['authentication'])) {
        return dbCommand('SELECT * FROM authentication WHERE UID = ?', [$_SESSION['authentication']]);
    } else {
        return 404;
    }
}
