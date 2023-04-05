<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login or register</title>
    <link rel="stylesheet" href="styling/login.css">
</head>
<body>

<h2>Login Form</h2>

<form action="/scripts/php/authentication.php" method="post">
    <div class="imgcontainer">
        <img src="assets/images/BlueAtomic/AtomicLogo.png" alt="Logo">
    </div>

    <div class="container">
        <label for="user"><b>Username or e-mail address</b></label>
        <input type="text" placeholder="Enter Username" name="user" id="user" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <?php
        session_start();
        if (isset($_SESSION['badAuth']) and $_SESSION["badAuth"] == 404) :?>
            <span style="color: red">Username or e-mail address does not exist. <a href="register.php">Try registering</a>.</span>
        <?php elseif (isset($_SESSION['badAuth']) and $_SESSION["badAuth"] == 403) :?>
            <span style="color: red">Password incorrect.</span>
        <?php endif;
        session_destroy()?>

        <button type="submit" name="login">Login</button>
    </div>

    <div class="container footer">
        <button type="button" class="cancelbtn" onclick="history.back()">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
</form>

</body>
</html>
