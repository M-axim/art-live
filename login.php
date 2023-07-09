<?php require "pages-blocks/head-block.php";?>
<title>Страница для входа</title>
<body class="body">
<!-- wrapper -->
<div class="wrapper">

    <div class="admin">
        <div class="admin-form login">
            <div class="container" mt-4>
                <h1>Форма авторизации</h1>
                <h4><a href="index.php">На главную</a></h4>
                <form action="pages-blocks/auth.php" method="post">
                    <input type="text" class="form-control" name="login" required minlength="5" maxlength="20" id="login" placeholder="Введите логин (от 5 до 20 символов)"><br>
                    <input type="password" class="form-control" name="pass" required id="pass" minlength="6" placeholder="Введите пароль (не менее 6 символов)"><br>
                    <button class="btn btn-success" type="submit">Авторизация</button>
                </form>
                <a href="reg_in.php" class="btn" id="Reg_In">Создать пользователя</a>
            </div>
        </div>

    </div>



</div>
<!-- Стили или скрипты -->
<?php require "pages-blocks/scripts.php"; ?>