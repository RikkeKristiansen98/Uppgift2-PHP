<?php
session_start();
include("functions.php");

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}


$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;


$subscribed_newsletters = get_user_subscribed_newsletters($user_email);

include("header.php"); 

if (!empty($subscribed_newsletters)) {
    echo "<h2>Aktiva prenumerationer:</h2>";
    echo "<ul>";
    foreach ($subscribed_newsletters as $newsletter) {
        echo "<li>" . htmlspecialchars($newsletter) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>You are not subscribed to any newsletters.</p>";
}

include("footer.php"); 
?>
