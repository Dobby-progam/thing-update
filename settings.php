<?php
    require_once('scripts/php/functions.php');

    session_start();

    if (!isset($_SESSION['authentication'])) {
        redirect('404.html', 403);
    }

    $user = dbCommand('SELECT * FROM authentication WHERE UID = ?', [$_SESSION['authentication']])
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <title>Settings - <?php echo $user['username'] ?></title>
<!--        <link rel="stylesheet" href="styling/settings.css">-->
        <link rel="stylesheet" href="styling/login.css">
    </head>

    <body>
    <form action="/scripts/php/userSettings.php" method="post" name="registration">

        <div class="container">

            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="username">

            <label for="mail"><b>e-mail address</b></label>
            <input type="text" placeholder="Enter mail address" name="mail" id="mail">

            <label for="psw"><b>New Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw">

            <label for="confirm-psw"><b>Confirm New Password</b></label>
            <input type="password" placeholder="Confirm password" name="confirm-psw" id="confirm-psw">

            <button type="submit" name="registration">Save changes</button>

            <?php
            if (!empty($_SESSION['badAuth'])) {
                echo $_SESSION['badAuth'];
            }
            ?>
        </div>
    </form>
    </body>

</html>
