<?php require "pages-blocks/head-block.php";?>
<title>Познакомьтесь с нашим преподавательским составом</title>

<?php
    if (isset($_COOKIE['user']))
    {
        echo '<body class="body" data-page="teacher" data-role="admin">';
    }
    else { echo '<body class="body" data-page="teacher" data-role="user">'; }
?>

<!-- wrapper -->
<div class="wrapper">
    <!-- header -->
    <div class="header" style="background-color: #D2CFCD">
        <?php require "pages-blocks/header.php"; ?>
    </div>
    <!-- main -->
    <main class="main custom-bg-light">

        <div class="intro" style="background-image: url('img/teacher-intro.png');">
            <div class="overlay"></div>

            <div class="intro__container container-xl">
                <h1 class="intro__title">Преподаватели</h1>
            </div>

        </div>

        <div class="main__body">

            <div class="sub-title">

                <div class="container-xl">
                    <h2 class="sub-title__text">Ознакомьтесь с нашей невероятно творческой командой</h2>
                </div>

            </div>

            <div class="teacher">
                <div class="container-xl">

                    <div id="carouselExampleSlidesOnly" class="carousel slide">

                        <div class="carousel-inner">

                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>

                </div>
            </div>

            <div class="cards">
                <div class="container-xl">

                    <h2 class="cards__title" id="cards__title"></h2>

                </div>
            </div>

        </div>
        <div id="modal" class="my-modal modal-light">
            <p class="my-modal__title" id="my-modal__title"></p>
            <p class="my-modal__subtitle" id="my-modal__subtitle"></p>

            <? // Для работы с файлами, в форме нужно прописывать свойство enctype="multipart/form-data"?>
            <form action="" method="POST" class="my-modal__form" id="addForm" data-info-id="0" enctype="multipart/form-data">
                <label for="teacherImg" class="my-modal__label my-modal__file">
                    Загрузите фото учителя
                    <input type="file" name="teacherImg" id="teacherImg" class="mt-2">
                </label>
                <label for="title" class="my-modal__label">
                    <input type="text" name="title" placeholder="Введите заголовок" required id="title" class="my-modal__line">
                </label>
                <label for="exhibitionWork_1" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_1" id="exhibitionWork_1" class="mt-2">
                </label>
                <label for="exhibitionWork_2" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_2" id="exhibitionWork_2" class="mt-2">
                </label>
                <label for="exhibitionWork_3" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_3" id="exhibitionWork_3" class="mt-2">
                </label>
                <label for="exhibitionWork_4" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_4" id="exhibitionWork_4" class="mt-2">
                </label>

                <div class="my-modal__action">
                    <button type="submit" class="btn" id="newHouse">Отправить</button>
                </div>
            </form>

            <? // Форма, в которой мы будем отдельно работать с фотками для преподавателей ?>
            <form action="" method="POST" class="my-modal__form" id="addPhotoForm" data-info-id="0" enctype="multipart/form-data">
                <label for="teacherImg" class="my-modal__label my-modal__file">
                    Загрузите фото учителя
                    <input type="file" name="teacherImg" required id="teacherImg" class="mt-2">
                </label>
                <label for="exhibitionWork_1" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_1" required id="exhibitionWork_1" class="mt-2">
                </label>
                <label for="exhibitionWork_2" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_2" id="exhibitionWork_2" class="mt-2">
                </label>
                <label for="exhibitionWork_3" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_3" id="exhibitionWork_3" class="mt-2">
                </label>
                <label for="exhibitionWork_4" class="my-modal__label my-modal__file">
                    Загрузите работу
                    <input type="file" name="exhibitionWork_4" id="exhibitionWork_4" class="mt-2">
                </label>
                <div class="my-modal__action">
                    <button type="submit" class="btn" id="newPhoto">Отправить</button>
                </div>
            </form>

            <span id="modal__close" class="my-modal__close">ₓ</span>
        </div>

    </main>
    <div id="overlay"></div>

    <footer class="footer" style="background-color: #D2CFCD">
        <?php require "pages-blocks/footer.php"; ?>
    </footer>

</div>
<!-- Стили или скрипты -->
<?php require "pages-blocks/scripts.php"; ?>
