<?php
session_start();
session_unset();
session_destroy();
header("Location: ../Homescreen.php");
exit();
?>
