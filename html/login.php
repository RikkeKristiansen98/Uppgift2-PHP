<?php 
include_once("functions.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    if($password === '12') {
        echo("login siccessful");
    } else {
        echo("login error");
    }

    die();
}
?>

<?php
include("header.php");
?>
<form method="POST">
    <input name="email" />
    <input name="password" type="password"/>
    <input type="submit" /> 
</form>