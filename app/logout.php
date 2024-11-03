<?php

include "connection.php";

$_SESSION = array();
session_destroy();

$_SESSION["notification"] = true;

header(header: "Location: " . baseUrl . "/login.php?msg=true");
exit();