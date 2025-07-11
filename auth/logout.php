<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <style>
    .alert-logout {
      position: fixed;
      top: 30%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #C97C5D;
      color: white;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.2);
      font-size: 18px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="alert-logout">
  ✅ Berhasil Logout!<br>
  Anda akan diarahkan ke halaman login...
</div>

<script>
  setTimeout(() => {
    window.location.href = 'loginForm.php';
  }, 2000); // redirect dalam 2 detik
</script>

</body>
</html>
