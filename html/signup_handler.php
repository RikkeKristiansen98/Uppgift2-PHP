<?php
session_start();
include 'functions.php';

function validate_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect = connect_database();

    if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['role'])) {
        $firstname = validate_input($_POST['firstname']);
        $lastname = validate_input($_POST['lastname']);
        $email = validate_input($_POST['email']);
        $password = password_hash(validate_input($_POST['password']), PASSWORD_DEFAULT); 
        $role = validate_input($_POST['role']);

        $check_sql = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $connect->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "Den här e-postadressen är redan registrerad.";
        } else {
            $sql = "INSERT INTO users (firstname, lastname, user_email, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($connect->error));
            }

            $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $role);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Konto skapat. Du kan nu logga in.";
            } else {
                $_SESSION['message'] = "Fel: " . htmlspecialchars($stmt->error);
            }
        }

        $stmt->close();
        $connect->close();
    } else {
        $_SESSION['message'] = "Felaktig begäran.";
    }

    header("Location: signup.php");
    exit;
}
?>
