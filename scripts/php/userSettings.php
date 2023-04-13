<?php
require_once('functions.php');

session_start();

if ($_POST['username']) {
    dbCommand('UPDATE authentication SET username = ? WHERE UID = ?', [$_POST['username'], $_SESSION['authentication']]);
}

if ($_POST['mail']) {
    dbCommand('UPDATE authentication SET mail = ? WHERE UID = ?', [$_POST['mail'], $_SESSION['authentication']]);
}

if (($_POST['psw'] && empty($_POST['confirm-psw'])) || empty($_POST['psw'] && $_POST['confirm-psw'])) {
    redirect('../../settings.php', 404);
} else if ($_POST['psw'] && $_POST['confirm-psw']) {
    if ($_POST['psw'] == $_POST['confirm-psw']) {
        $password = password_hash($_POST["psw"], PASSWORD_DEFAULT);
        dbCommand('UPDATE authentication SET password = ? WHERE UID = ?', [$password, $_SESSION['authentication']]);
    } else {
        redirect('../../settings.php', 403);
    }
}

redirect('../../settings.php', 200);