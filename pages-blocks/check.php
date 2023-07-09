<?php
require "connect.php";

$name = filter_var($_POST[trim("name")], FILTER_SANITIZE_STRING);
$pass = filter_var($_POST[trim("pass")], FILTER_SANITIZE_STRING);
$login = filter_var($_POST[trim("login")], FILTER_SANITIZE_STRING);

// Обыкновенная проверка на длину текста в полях с логином, паролем и именем
if (mb_strlen($login) < 5 || mb_strlen($login) > 20)
{
    echo "Недопустимая длина строки";
    exit();
}
else if (mb_strlen($login) < 5 || mb_strlen($login) > 20)
{
    echo "Недопустимая длина логина";
    exit();
}
else if (mb_strlen($pass) < 6 || mb_strlen($pass) > 50 )
{
    echo "Недопустимая длина пароля";
    exit();
}

try {
    $userLogin = $connection->query("SELECT * FROM `Users` WHERE `login` = '$login'");
    // fetch() извлекает строки из набора
    $userLogin = $userLogin->fetch();

    if (!$userLogin) {
        try {
            $connection->query("INSERT INTO `Users` (`login`, `name`, `pass`) VALUES ('$login', '$name', '$pass')");
            setcookie('user', $user['name'], time() + 3600, "/");
            header("location: /index.php");
        }
        catch (PDOException $e) { echo $e->getMessage(); }
    }
    else {
        echo "<meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>";
        echo "<meta http-equiv='X-UA-Compatible' content='ie=edge'>";
        echo "<h2 style='display: block; text-align: center;'>Пользователь с таким логином уже существует</h2>";
        echo "<a href='/reg_in.php' style='display: block; text-align: center;'>Вернутся на страницу регистрации</a>";
    }
} catch (PDOException $e) { echo $e->getMessage(); }
?>