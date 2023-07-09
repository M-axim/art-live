<?php require "pages-blocks/head-block.php";?>
<title>Осваиваете новые направления на наших мастер-классах</title>

<?php
    if (isset($_COOKIE['user']))
    {
        echo '<body class="body" data-page="masters" data-role="admin">';
    }
    else { echo '<body class="body" data-page="masters" data-role="user">'; }
?>

<!-- wrapper -->
<div class="wrapper">

    <!-- header -->
    <div class="header" style="background-color: #9ABAB7">
        <?php require "pages-blocks/header.php"; ?>
    </div>
    <!-- main -->
    <main class="main custom-bg-dark">

        <div class="intro" style="background-image: url('img/intro-master.png');">
            <div class="overlay"></div>

            <div class="intro__container container-xl">
                <h1 class="intro__title">Мастер - классы</h1>
            </div>

        </div>

        <div class="main__body">

            <div class="sub-title">

                <div class="container-xl">
                    <h2 class="sub-title__text">Освойте понравившееся направление на одном из наших мастер-классов</h2>
                </div>

            </div>

            <div class="house">
            </div>

            <button class="btn d-inline" style="background-color: #9ABAB7" data-background="#9ABAB7" id="btnSubmit">Записаться</button>

        </div>

        <div id="modal" class="my-modal modal-light">
            <p class="my-modal__title" id="my-modal__title"></p>
            <p class="my-modal__subtitle" id="my-modal__subtitle"></p>

            <span id="modal__close" class="my-modal__close">ₓ</span>
        </div>

    </main>
    <div id="overlay"></div>

    <footer class="footer" style="background-color: #9ABAB7">
        <?php require "pages-blocks/footer.php"; ?>
    </footer>

</div>
<!-- Стили или скрипты -->
<?php require "pages-blocks/scripts.php"; ?>
