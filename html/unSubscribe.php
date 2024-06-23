<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Du måste vara inloggad för att avprenumerera.";
    header("Location: noAccess.php");
    exit();
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_title'])) {
    $newsletter_title = validate_input($_POST['newsletter_title']);
    
    if ($user_email) {
        $mysqli = connect_database();

        $stmt = $mysqli->prepare("DELETE FROM subscriptions WHERE user_email = ? AND newsletter = ?");
        $stmt->bind_param("ss", $user_email, $newsletter_title);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Du har avprenumererat på nyhetsbrevet.";
        } else {
            $_SESSION['message'] = "Kunde inte avprenumerera. Kontrollera att du är prenumerant.";
        }

        $stmt->close();
        $mysqli->close();
    } else {
        $_SESSION['message'] = "Användarens e-post kunde inte hittas.";
    }
} else {
    $_SESSION['message'] = "Ogiltig förfrågan.";
}

header("Location: mySubsciptions.php");
exit();
?>
