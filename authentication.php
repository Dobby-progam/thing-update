<?php

use JetBrains\PhpStorm\NoReturn;

function dbCommand(string $query, array $parameters) : mixed {
    $env = parse_ini_file('.env');

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

if (isset($_POST['registration'])) {
    if (!isMail($_POST['mail'])) {
        redirect('register.php', 404);
    }

    $passwordHash = password_hash($_POST["psw"], PASSWORD_DEFAULT);

    $regInput = dbCommand('INSERT INTO authentication (username, mail, password) VALUES (?, ?, ?)', [$_POST['uname'], $_POST['mail'], $passwordHash]);

    if (!is_bool($regInput)) {
        if ($regInput[0] == 23000) {
            redirect('register.php', 403);
        } else {
            throw $regInput[1];
        }
    }

    redirect('login.php', 200);
} elseif (isset($_POST['login'])) {
    if (isMail($_POST['user'])) {
        $user = dbCommand('SELECT * FROM authentication WHERE mail = ?', [$_POST['user']]);
    } else {
        $user = dbCommand('SELECT * FROM authentication WHERE username = ?', [$_POST['user']]);
    }

    if (empty($user)) {
        redirect('login.php', 404);
    } else {

        $correctPassword = verifyPassword($user['password']);

        if ($correctPassword) {
            echo 'password correct';
        } else {
            echo 'password bad';
            redirect('login.php', 403);
        }
    }
}