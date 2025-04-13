<?php
session_start();
// Destroy session
session_unset();
session_destroy();
header("Location: /COMP3421/index.php");
exit();
?>