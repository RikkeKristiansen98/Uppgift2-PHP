<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: noAccess.php");
    exit;
}

$newsletter_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_email = $_SESSION['user_email'];
$newsletter = get_newsletter_by_id($newsletter_id);

if (!$newsletter || $newsletter['user'] !== $user_email) {
    $_SESSION['message'] = "Du har inte behörighet att redigera detta nyhetsbrev.";
    header("Location: myNewsletter.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (update_newsletter($newsletter_id, $title, $description)) {
        $_SESSION['message'] = "Nyhetsbrevet uppdaterades!";
        header("Location: myNewsletter.php");
        exit;
    } else {
        $error_message = "Kunde inte uppdatera nyhetsbrevet. Försök igen.";
    }
}

include("header.php");
?>

<h2>Redigera nyhetsbrev</h2>

<form method="POST">
    <label for="title">Titel:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($newsletter['title']); ?>" required>
    <br>
    <label for="description">Beskrivning:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($newsletter['description']); ?></textarea>
    <br>
    <input type="submit" value="Uppdatera">
</form>

<?php
if (isset($error_message)) {
    echo "<p>$error_message</p>";
}
?>
