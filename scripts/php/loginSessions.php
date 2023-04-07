<?php
require_once('functions.php');

session_start();

if (isset($_SESSION['authentication'])) {
    $userID = $_SESSION['authentication'];
    $result = dbCommand('SELECT * FROM authentication WHERE UID = ?', [$userID]);
} else {
    echo 'Not logged in.';
}