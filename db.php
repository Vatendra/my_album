<?php
$conn = new mysqli("localhost", "root", "", "album");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


