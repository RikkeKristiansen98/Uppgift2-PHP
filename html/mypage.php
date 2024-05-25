<?php
session_start();
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include("header.php");
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Välkommen</title>
</head>
<body>
    <h3>Välkommen</h3>
    <p>Du är nu inloggad!</p>
</body>
</html>
