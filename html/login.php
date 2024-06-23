<?php
include_once("functions.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = get_user_by_email($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['user_email']; 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: mypage.php");
            exit;
        } else {
            $error_message = "Fel email eller lösenord, försök igen";
        }
    } else {
        $error_message = "Vänligen fyll i både e-post och lösenord.";
    }
}
?>

<?php include("header.php"); ?>

<form method="POST">
    <label for="email">Email: <input name="email" type="email" required /></label><br>
    <label for="password">Lösenord: <input name="password" type="password" required /></label><br>
    <input type="submit" value="Logga in" />
</form>

<?php
if (isset($error_message)) {
    echo "<p>$error_message</p>";
}
?>
<?php
if (isset($_SESSION['user_id'])) {
    echo '<a href="logout.php">Logga ut</a>';
}
?>
