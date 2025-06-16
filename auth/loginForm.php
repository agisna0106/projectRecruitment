<?php 
require_once 'login.php';

$login = new Login();

if(isset($_POST['login'])) {
    $login->login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="loginregister">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
            <h2>Kopi<i>keun</i></h2>
            <div class="cardlr">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
                <button type="submit" name="login" value="login">REGISTER</button>
            </div>
        </form>
    </section>
    
</body>
</html>