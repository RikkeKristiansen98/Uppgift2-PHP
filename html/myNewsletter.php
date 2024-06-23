<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user_email'];
$newsletters = get_newsletters_by_user_email($user_email);

include("header.php");
?>

<h2>Mina nyhetsbrev</h2>

<?php if (!empty($newsletters)): ?>
<?php foreach ($newsletters as $newsletter): ?>
  <h3><?php echo htmlspecialchars($newsletter['title']); ?></h3>
  <p><?php echo htmlspecialchars($newsletter['description']); ?></p>
  <form action="editNewsletter.php" method="GET" style="display: inline;">
  <input type="hidden" name="id" value="<?php echo $newsletter['id']; ?>">
    <button type="submit">Redigera</button>
</form>        
<?php endforeach; ?>
<?php else: ?>
    <p>Du har inga nyhetsbrev än.</p>
<?php endif; ?>

<?php
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}
?>
