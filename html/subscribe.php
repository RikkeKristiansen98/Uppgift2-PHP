<?php 
include 'functions.php';

function validate_input($data) {
    $data = trim($data); // för ta bort eventuella onödiga mellanslag
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect = connect_database();

    $first_name = validate_input($_POST['firstname']);
    $last_name = validate_input($_POST['lastname']);
    $email = validate_input($_POST['email']);
    $password = validate_input($_POST['password']);
    $role = validate_input($_POST['role']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
        echo "Alla fält är obligatoriska.";
        exit;
    }

    // Validera 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ogiltig e-postadress.";
        exit;
    }

    // Hasha lösenord
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connect->error));
    }

    $stmt->bind_param("sssss", $first_name, $last_name, $email, $password_hash, $role);

    if ($stmt->execute()) {
        echo "Konto skapat!";
    } else {
        echo "Fel: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $connect->close();
}
?>
