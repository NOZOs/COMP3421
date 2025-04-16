<?php
$servername = "ehc1u4pmphj917qf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "d9wcuyxwit45t4sh";
$password = "az9ia1foe8wzpcd3";
$dbname = "i9zcmu88t2blefy2";
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
