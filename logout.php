<?php
//if they session variable is set (if user is logged in), unset the variable (log the user out)
session_start();
if (isset($_SESSION["authenticated"]))
{
    session_destroy();
}

//go to index page
header("location: index.php");
?>