<?php
include_once("functions.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];

$my_newsletters = get_newsletters_by_user_email($user_email);
include("header.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina nyhetsbrev</title>
</head>
<body>
    <h1>Mina nyhetsbrev</h1>
    <ul>
        <?php 
        if ($my_newsletters) {
            foreach ($my_newsletters as $newsletter): 
        ?>
            <li><?php echo htmlspecialchars($newsletter['title']); ?></li>
            <a href="editNewsletter.php"><button>Redigera nyhetbrev</button></a>

        <?php 
            endforeach; 
        } else {
            echo "<li>Inga nyhetsbrev hittades.</li>";
        }
        ?>
    </ul>
</body>
</html>