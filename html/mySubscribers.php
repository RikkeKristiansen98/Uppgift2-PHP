<?php
session_start();
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("header.php"); 

$user_email = $_SESSION['user_email'];
$subscribed_newsletters = get_user_subscribed_newsletters($user_email);

if (!empty($subscribed_newsletters)) {
    echo "<h2>Mina prenumeranter</h2>";
    echo "<ul>";
    foreach ($subscribed_newsletters as $subscription) {
        echo "<li>" . htmlspecialchars($subscription['user_email']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Du har inga prenumeranter</p>";
}

include("footer.php"); 
?>
