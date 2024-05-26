<?php
session_start();
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsletter = $_POST['newsletter'];
    $user_email = $_POST['user_email'];

    $mysqli = connect_database();
    
    $query = "DELETE FROM subscriptions WHERE newsletter = ? AND user_email = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ss", $newsletter, $user_email);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Prenumerationen har avbrutits.";
        } else {
            $_SESSION['message'] = "Kunde inte avbryta prenumerationen.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: " . $mysqli->error;
    }
    
    $mysqli->close();

    header("Location: mySubsciptions.php");
    exit;
} else {
    header("Location: mySubsciptions.php");
    exit;
}
?>
