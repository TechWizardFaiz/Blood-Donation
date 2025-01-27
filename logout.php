<?php
// Start or resume the session
session_start();

// Clear all session variables
$_SESSION = array();


// Redirect the user to the login page
header("Location: login.php");
exit();
?>
