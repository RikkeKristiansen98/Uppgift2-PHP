<?php
include_once("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $connect = connect_database();
    $stmt = $connect->prepare('SELECT user FROM passwordResets WHERE code = ?');
    $stmt->bind_param('i', $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $reset = $result->fetch_assoc();
    $stmt->close();

    if ($reset) {
        $stmt = $connect->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $newPassword, $reset['user']);
        $stmt->execute();
        $stmt->close();

        $stmt = $connect->prepare('DELETE FROM passwordResets WHERE code = ?');
        $stmt->bind_param('i', $code);
        $stmt->execute();
        $stmt->close();

        echo 'Ditt lösenord har uppdaterats.';
    } else {
        echo 'Ogiltig återställningskod.';
    }

    $connect->close();
}
?>

<form method="POST">
    <label for="email">E-post:</label>
    <input type="email" id="email" name="email" required>
    <label for="code">Återställningskod:</label>
    <input type="text" id="code" name="code" required>
    <label for="new_password">Nytt lösenord:</label>
    <input type="password" id="new_password" name="new_password" required>
    <button type="submit">Återställ lösenord</button>
</form>
<a href="login.php"><button>Logg in</button></a>
