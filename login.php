<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login or register</title>
    <link rel="stylesheet" href="styling/login.css">
</head>
<body>

<h2>Login Form</h2>

<form action="/authentication.php" method="post">
    <div class="imgcontainer">
        <img src="assets/images/BlueAtomic/AtomicLogo.png" alt="Logo">
    </div>

    <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <?php
        session_start();
        if (isset($_SESSION['badlogin']) and $_SESSION["badlogin"] == "password") :?>
            <span style="color: red">Password incorrect.</span>
            <?php session_destroy()?>
        <?php endif;
        ?>

        <button type="submit" value="login">Login</button>
    </div>

    <div class="container footer">
        <button type="button" class="cancelbtn" onclick="history.back()">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
</form>

</body>
</html>
