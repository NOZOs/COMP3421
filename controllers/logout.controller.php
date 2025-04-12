<?php
session_start();
// Destroy session
session_unset();
session_destroy();
header("Location: /3421/index.php");
exit();
?>