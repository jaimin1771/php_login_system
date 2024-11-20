<?php
$conn = new mysqli("localhost", "root", "", "php_login");

if (!$conn) {
    echo "database not connected";
} else {
    // echo "database connected";
}
