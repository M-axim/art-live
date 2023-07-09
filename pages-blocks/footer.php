<div class="container-xl">
    <div class="footer__top">
        <div class="row">
            <div class="col-md">
                <a href="index.php">
                    <img class="footer__img" src="img/Logo.png" alt="logo">
                </a>
                <a href="rules.php" class="footer__text text-xl-left text-decoration">Правила бронирования, посещений и отмены занятий</a>


                <?php
                // Если пользователь зареган, то создаем ссылку на выход из аккаунта
                if (isset($_COOKIE['user']))
                {
                    echo "<a href='pages-blocks/exit.php' class='footer__text text-xl-left text-decoration'>Выйти</a>";
                }
                ?>

            </div>
            <div class="col-md">
                <p class="footer__title">Студия ART LIFE</p>
                <ul class="footer__nav">
                    <li class="footer__item">
                        <a class="footer__link" href="masters.php">МАСТЕР - КЛАССЫ</a>
                    </li>
                    <li class="footer__item">
                        <a class="footer__link" href="design.php">АРТ - ВЕЧЕРИНКИ</a>
                    </li>
                    <li class="footer__item">
                        <a class="footer__link" href="courses.php">КУРСЫ</a>
                    </li>
                    <li class="footer__item">
                        <a class="footer__link" href="teachers.php">ПРЕПОДАВАТЕЛИ</a>
                    </li>
                </ul>
            </div>
            <div class="col-md">
                <p class="footer__title">Контакты</p>
                <div class="footer__text text-xl-left">Адрес: Макаренко , 11 Б Старый Оскол, Россия</div>
                <div class="footer__text text-xl-left">Телефон: <a class="footer__link text-decoration" href="tel:79611710654">+7 (961) 171-06-54</a></div>
                <div class="footer__text text-xl-left">Почта: <a class="footer__link text-decoration" href="mailto:info@artlife.ru">info@artlife.ru</a></div>
                <div class="footer__text text-xl-left">
                    *Вы можете отправить сообщение в мессенджер в любое время. Мы ответим Вам, как только сможем.
                </div>

            </div>
        </div>
    </div>
</div>
    <div class="footer__bottom">
        <div class="container-xl">
            <div class="row">
                <div class="col-md">
                    <span class="footer__text footer__copyright h-100 d-flex align-items-center">© 2022-2023 Студия ART LIFE</span>
                </div>
                <div class="col-md footer__text-right">
                    <a href="#" class="footer__icon">
                        <img class="icon" src="img/icon/instagram.png" alt="instagram">
                    </a>
                    <a href="#" class="footer__icon">
                        <img class="icon" src="img/icon/telegram.png" alt="telegram">
                    </a>
                    <a href="#" class="footer__icon">
                        <img class="icon" src="img/icon/tiktok.png" alt="tiktok">
                    </a>
                    <a href="#" class="footer__icon">
                        <img class="icon" src="img/icon/VK.png" alt="VK">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>