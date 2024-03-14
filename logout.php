<?php
// clear all the session variables and redirect to the index
session_start();
session_unset();
session_write_close();
$url = "home.php";
header("Location: $url");