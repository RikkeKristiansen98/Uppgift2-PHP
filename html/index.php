<?php 
include_once("functions.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $error_message = "Fel mail eller lösenord, forsök igen.";
    }
}
?>

<?php
include("header.php");
?>

<a href="newsletters.php"><button>Kolla utbud av nyhetsbrev</button></a> <br></br>
<form method="POST">
    <label for="email">Email: <input name="email" type="email" required /></label><br>
    <label for="password">Lösenord: <input name="password" type="password" required /></label><br>
    <input type="submit" value="Logga in" /> 
</form>
<p>Har du glömt lösenordet?</p>
<a href="requestreset.php"><button>Gå vidare för att ändra lösenord</button></a>
<?php
if (isset($error_message)) {
    echo "<p>$error_message</p>";
}
?>

<p>Om du inte har ett konto kan du skapa ett:</p>

<a href="signup.php"><button>Skapa konto</button></a>
