<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login or register</title>
    <link rel="stylesheet" href="styling/login.css">
</head>
<body>

<h2>Registration</h2>

<form action="/authentication.php" method="post" name="registration">
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
        if (isset($_SESSION['badlogin']) and $_SESSION["badlogin"] == 403) :?>
            <span style="color: red">A user with this name already exists.</span>
        <?php endif;
        session_destroy();?>

        <button type="submit" name="registration">Register</button>

        <label>
            <input type="checkbox" name="privacy policy" required> I agree to the privacy policy.
        </label>
    </div>

    <div class="container footer">
        <button type="button" class="cancelbtn" onclick="history.back()">Cancel</button>
    </div>
</form>

</body>
</html>
