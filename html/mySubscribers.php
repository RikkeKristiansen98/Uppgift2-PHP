<?php
session_start();
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("header.php"); 

$user_email = $_SESSION['user_email'];
$subscribed_newsletters = get_customers_subscribers($user_email);

if (!empty($subscribed_newsletters)) {
    echo "<h2>Mina prenumeranter</h2>";
    echo "<ul>";
    foreach ($subscribed_newsletters as $subscriber) {
        echo "<li>" . htmlspecialchars($subscriber) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Du har inga prenumeranter</p>";
}
?>
