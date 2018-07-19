<?php
session_start();

setcookie("checktrans", "", time() - (60 * 60 * 24 * 30), "/");
if(session_destroy()) // Destroying All Sessions
{
header("Location: index.php"); // Redirecting To Home Page
}
?>