<?php require "pages-blocks/head-block.php";?>
<title>Сделайте свое мероприятие уникальным и запо минающимся</title>

<?php
    if (isset($_COOKIE['user']))
    {
        echo '<body class="body" data-page="design" data-role="admin">';
    }
else { echo '<body class="body" data-page="design" data-role="user">'; }
?>
<!-- wrapper -->
<div class="wrapper">
    <!-- header -->
    <div class="header" style="background-color: #908EB1">
        <?php require "pages-blocks/header.php"; ?>
    </div>
    <!-- main -->
    <main class="main custom-bg-blue">

        <div class="intro" style="background-image: url('img/design-intro.png');">
            <div class="overlay"></div>

            <div class="intro__container container-xl">
                <h1 class="intro__title">АРТ - ВЕЧЕРИНКИ</h1>
            </div>

        </div>

        <div class="main__body">

            <div class="sub-title">

                <div class="container-xl">
                    <h2 class="sub-title__text">Сделайте своё мероприятие уникальным и творческим</h2>
                </div>

            </div>

            <div class="house"></div>

            <button class="btn d-inline" style="background-color: #908EB1" data-background="#908EB1" id="btnSubmit">Записаться</button>

        </div>

        <div id="modal" class="my-modal" style="background-color: #908EB1">
            <p class="my-modal__title" id="my-modal__title"></p>
            <p class="my-modal__subtitle" id="my-modal__subtitle"></p>

            <span id="modal__close" class="my-modal__close">ₓ</span>
        </div>


    </main>
    <div id="overlay"></div>

    <footer class="footer" style="background-color: #908EB1">
        <?php require "pages-blocks/footer.php"; ?>
    </footer>

</div>
<!-- Стили или скрипты -->
<?php require "pages-blocks/scripts.php"; ?>
