<?php
require_once('scripts/php/functions.php');

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