<h1>Skapa ett konto</h1>

<form action="subscribe.php" method="post">
    <label for="firstname">Firstname: <input type="text" name="firstname" required></label><br>
    <label for="lastname">Lastname: <input type="text" name="lastname" required></label><br>
    <label for="email">Email: <input type="email" name="email" required></label><br>
    <label for="password">Password: <input type="password" name="password" required></label><br>
    <label for="role">Role: 
        <select name="role" required>
            <option value="customer">Kund</option>
            <option value="subscriber">Prenumerant</option>
        </select>
    </label><br>
    <input type="submit" name="submit" value="Skapa konto">
</form>
