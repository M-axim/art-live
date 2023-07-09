<?php
setcookie('user', $user['name'], time() - 3600, "/");
header("location: /index.php");
?>