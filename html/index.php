<?php
ob_start();
include_once("functions.php");
include("header.php");

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = get_user_by_email($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] === 'customer') {
            header("Location: mySubscribers.php");
            exit;
        } elseif ($_SESSION['role'] === 'subscriber') {
            header("Location: newsletters.php");
            exit;
        }
    } else {
        $error_message = "Fel mail eller lösenord, försök igen.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggning</title>
</head>
<body>

<?php if (!isset($_SESSION['user_id'])): ?>
    <form method="POST">
        <label for="email">Email: <input name="email" type="email" required /></label><br>
        <label for="password">Lösenord: <input name="password" type="password" required /></label><br>
        <input type="submit" value="Logga in" /> 
    </form>
    <?php if (!empty($error_message)) {
        echo "<p>$error_message</p>";
    } ?>
    <p>Har du glömt lösenordet?</p>
    <a href="requestreset.php"><button>Gå vidare för att ändra lösenord</button></a>
<?php elseif ($_SESSION['role'] === 'customer'): ?>
    <p>Välj i menyen om du vill se dina prenumeranter eller redigera ditt nyhetsbrev.</p>
<?php elseif ($_SESSION['role'] === 'subscriber'): ?>
    <p>Välj i menyen om du vill kolla utbud av nyhetsbrev, vilka du prenumererar på eller avsluta en prenumeration.</p>
<?php endif; ?>
<php
ob_end_flush();
?>
</body>
</html>
