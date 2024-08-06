<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = "";

    // Validate credentials
    if ($username !== 'admin' && $password !== 'admin') {
        $error = "Username dan Password salah";
    } elseif ($username !== 'admin') {
        $error = "Username salah";
    } elseif ($password !== 'admin') {
        $error = "Password salah";
    }

    // If there is an error, redirect back to login with the error message
    if (!empty($error)) {
        header('Location: ../login.php?error=' . urlencode($error));
        exit();
    }

    // If login is successful
    $_SESSION['username'] = $username;
    header('Location: ../index.php');
    exit();
}
