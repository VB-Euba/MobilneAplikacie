<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
}

function redirectToAccount() {
    if (!isLoggedIn()) {
        header("Location: ucet.php");
        exit();
    }
}

redirectToAccount();
?>
