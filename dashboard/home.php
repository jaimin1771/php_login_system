<?php
session_start();

// Redirect to login if session not set
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit;
}
$page_content = "home-content.php";
include "dashboard.php";