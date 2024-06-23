<?php
session_start();
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect = connect_database();

    if (isset($_POST['newsletter_title']) && isset($_SESSION['user_email'])) {
        $newsletter_title = validate_input($_POST['newsletter_title']);
        $user_email = validate_input($_SESSION['user_email']);

        $check_sql = "SELECT * FROM subscriptions WHERE newsletter = ? AND user_email = ?";
        $stmt = $connect->prepare($check_sql);
        $stmt->bind_param("ss", $newsletter_title, $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "Du prenumererar redan på detta nyhetsbrev.";
        } else {
            $sql = "INSERT INTO subscriptions (newsletter, user_email) VALUES (?, ?)";
            $stmt = $connect->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($connect->error));
            }

            $stmt->bind_param("ss", $newsletter_title, $user_email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Du prenumererar nu på nyhetsbrevet.";
            } else {
                $_SESSION['message'] = "Fel: " . htmlspecialchars($stmt->error);
            }
        }

        $stmt->close();
        $connect->close();
    } else {
        $_SESSION['message'] = "Felaktig begäran.";
    }

    header("Location: mySubsciptions.php");
    exit();
}
?>
