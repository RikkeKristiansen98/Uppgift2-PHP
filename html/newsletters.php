<?php
session_start();
include_once("functions.php");
include("header.php");

$mysqli = connect_database();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['newsletter_id'])) {
    $newsletter_id = $_GET['newsletter_id'];
    $newsletter = get_newsletter_by_id($newsletter_id);

    if ($newsletter) {
        echo '<h2>' . htmlspecialchars($newsletter['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($newsletter['description']) . '</p>';

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

            if ($user_role === 'subscriber') {
                $subscriptions = get_user_subscriptions($_SESSION['user_email']);
                if (in_array($newsletter['title'], $subscriptions)) {
                    echo '<form method="POST" action="unsubscribe.php">';
                    echo '<input type="hidden" name="newsletter_title" value="' . $newsletter['title'] . '" />';
                    echo '<button type="submit" name="unsubscribe">Avregistrera</button>';
                    echo '</form>';
                } else {
                    echo '<form method="POST" action="subscribe.php">';
                    echo '<input type="hidden" name="newsletter_title" value="' . $newsletter['title'] . '" />';
                    echo '<button type="submit" name="subscribe">Prenumerera</button>';
                    echo '</form>';
                }
            } elseif ($user_role === 'customer') {
                echo '<p>Du är en kund och kan inte prenumerera på nyhetsbrev.</p>';
            }
        } else {
            echo '<p><a href="login.php">Logga in</a> för att prenumerera på detta nyhetsbrev.</p>';
        }
    } else {
        echo '<p>Nyhetsbrevet hittades inte.</p>';
    }
} else {
    echo '<h2>Alla tillgängliga nyhetsbrev</h2>';
    echo '<ul>';
    $newsletters = get_all_newsletters();
    foreach ($newsletters as $newsletter) {
        echo '<li><a href="newsletters.php?newsletter_id=' . $newsletter['id'] . '">' . htmlspecialchars($newsletter['title']) . '</a></li>';
    }
    echo '</ul>';
}

$mysqli->close();
?>
