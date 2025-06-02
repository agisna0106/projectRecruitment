<?php
include_once 'register.php';

$reg = new Register();

if($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $reg->register();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <section class="loginregister">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
            <h2>Kopi<i>keun</i></h2>
            <div class="cardlr">
                <label for="name">Nama : </label>
                <input type="text" name="name" id="name">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
                <button type="submit" name="register" value="register">REGISTER</button>
            </div>
        </form>
    </section>
    
</body>
</html>