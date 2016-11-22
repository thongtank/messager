<?php
session_start();
// session_unset();
session_destroy();
//
// $_SESSION["profile"] = NULL;
// $_SESSION["profile_username"] = NULL;
// $_SESSION["profile_typeOfUser"] = NULL;
// $_SESSION["profile_detail"] = NULL;

header("Location: index.php");
