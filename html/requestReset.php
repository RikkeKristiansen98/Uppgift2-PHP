<?php
include_once("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $user = get_user_by_email($email);

    if ($user) {
        $resetCode = rand(100000, 999999);
        $connect = connect_database();
        $stmt = $connect->prepare('INSERT INTO passwordResets (user, code) VALUES (?, ?)');
        $stmt->bind_param('ii', $user['id'], $resetCode);
        $stmt->execute();
        $stmt->close();
        $connect->close();

        $subject = "Återställ ditt lösenord";
        $body = "Din återställningskod är: $resetCode";
        $result = send_email($email, $subject, $body);

        if ($result) {
            echo "Återställningskoden har skickats till din e-postadress.";
        } else {
            echo "Det gick inte att skicka återställningskoden. Kontrollera loggarna för mer information.";
        }
    } else {
        echo "E-postadressen finns inte i vår databas.";
    }
}
?>

<form method="POST">
    <label for="email">E-post:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Skicka återställningskod</button>
</form>
<a href="newpassword.php"><button>Gå vidare</button></a>
