<?php 
session_start();
include("header.php");
include_once("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = get_user_by_email($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $user['email']; 
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['role'] = $user['role'];
        header("Location: mypage.php");
        exit;
    } else {
        $error_message = "Fel email eller lösenord, försök igen";
    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Välkommen</title>
</head>
<body>
    <h3>Välkommen</h3>
    <p>Du är nu inloggad!</p>
</body>
</html>
