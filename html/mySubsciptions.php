<?php
session_start();
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
$subscribed_newsletters = get_user_subscriptions($user_email);

include("header.php"); 

if (isset($_SESSION['message'])) {
    echo "<p>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}

if (!empty($subscribed_newsletters)) {
    echo "<h2>Aktiva prenumerationer:</h2>";
    echo "<ul>";
    foreach ($subscribed_newsletters as $newsletter) {
        echo "<li>" . htmlspecialchars($newsletter) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Du har inga prenumerationer.</p>";
}
?>
