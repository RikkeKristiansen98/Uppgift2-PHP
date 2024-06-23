<?php
session_start();
require 'functions.php';
include("header.php"); 

if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

$userEmail = $_SESSION['user_email'];

$subscribers = get_customers_subscribers($userEmail);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mina prenumeranter</title>
</head>
<body>
    <h1>Mina prenumeranter</h1>
    <?php if (empty($subscribers)): ?>
        <p>Du har inga prenumeranter.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Förnamn</th>
                <th>Efternamn</th>
                <th>E-post</th>
                <th>Nyhetsbrev</th>
            </tr>
            <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subscriber['firstname']); ?></td>
                    <td><?php echo htmlspecialchars($subscriber['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($subscriber['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($subscriber['title']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
