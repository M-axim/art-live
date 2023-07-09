<?php
// Все файлы в папке api похоже между собой, поэтому ты можешь остальные не смотреть
// Только в других файлах есть запись вида:
// $file = $_FILES['imageURL'];
// $name = $file['name'];
// $pathFile = '../img/'.$name;
//
// move_uploaded_file($file['tmp_name'], $pathFile);
//
// Данный код перемещает фотографии с любого места

// Здесь находятся заголовки, благодаря которым сервер отправляет данные для js
require "headers.php";
// Здесь находится переменная с подключением к бд
require "../pages-blocks/connect.php";

// Здесь мы получаем метод, который отправила форма, то есть это GET, POST, DELETE, и PATH
// GET - этот метод используется для получения данные
// POST - этот метод используется для создания данных
// DELETE - этот метод используется для создания удаления данных
// PATCH  - этот метод используется для частичного изменения данных
// перечисленные выше методы не единственные, но в текущем сайте используются только они
// У метода GET и POST можно получать информацию, как в примере ниже, где мы получаем id
// Чтобы получить значение определенного параметра необходимо указать его в квадратных скобках
// Если такой параметр есть, то мы получим его значение
$method = $_SERVER["REQUEST_METHOD"];
if (isset($_GET["id"]))
    $id = $_GET["id"];

// Эта функция получает всех преподавателей
function getTeachers($connection)
{
    try {
        // Всех преподавателей будем хранить в массиве $teacherArray
        $teacherArray = [];
        // В строки ниже мы получаем не массив а строку, которую надо потом превравить в массив
        $teacher = $connection->query("SELECT * FROM teacher");

        // А здесь мы как раз преобразуем нашу строку в ассоциативный массив
        while ($row = $teacher->fetch(PDO::FETCH_ASSOC)) {
            $teacherArray[] = $row;
        }
        // json_encode превращает массив в json, а echo выводит этот json, который в свою очередь получить js
        echo json_encode($teacherArray);
    // Если произойдет ошибка, то выведем ее в консоль
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function getTeacher($connection, $id)
{
    try {
        // Делаем тоже самое, что и выше, только получаем одного единственного пользователя
        $teacherArray = [];
        $teacher = $connection->query(
            "SELECT * FROM c WHERE `teacher`.`id` = $id"
        );

        while ($row = $teacher->fetch(PDO::FETCH_ASSOC)) {
            $teacherArray[] = $row;
        }
        echo json_encode($teacherArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Функция удаления препода
function deleteTeacher($connection, $id)
{
    try {
        // Данная функция удаляет пользователя по id, а после выводи код 200, что значит: "удалено"
        $connection->query("DELETE FROM teacher WHERE `teacher`.`id` = $id");

        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Преподаватель удален",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Эта функция добавляет в бд нового преподавателя
function addTeacher($connection, $data)
{

    try {
        // Для добавления данных в pdo, лучше сначала подготовить строку
        $sql =
            "INSERT INTO `teacher` (`id`, `teacherImg`, `title`, `exhibitionWork_1`, `exhibitionWork_2`, `exhibitionWork_3`, `exhibitionWork_4`) VALUES (NULL, :teacherImg, :title, :exhibitionWork_1, :exhibitionWork_2, :exhibitionWork_3, :exhibitionWork_4)";

        // подготовка строки делается с помощью метода prepare()
        // Именно благодаря данному методу с PDO безопасней работать в БД
        // Так как грубо говоря этот метод отправляет на сервер сначала не значения, а сами переменные, а потом подменяет их значениями
        // которые мы синхронизируем ниже. А что насчет SQL инъекций, то PDO насчет этого позаботится
        // Но не всегда, но это другая тема, но в вашем сайте это скорей всего маловероятно
        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям нужно это для того, что подменить значения из переменной $sql, на наши
        // значение, но уже безопасные
        $stmt->bindValue(":teacherImg", $_FILES['teacherImg']["name"]);
        $stmt->bindValue(":title", $_POST["title"]);
        $stmt->bindValue(":exhibitionWork_1", $_FILES["exhibitionWork_1"]["name"]);
        $stmt->bindValue(":exhibitionWork_2", $_FILES["exhibitionWork_2"]["name"]);
        $stmt->bindValue(":exhibitionWork_3", $_FILES["exhibitionWork_3"]["name"]);
        $stmt->bindValue(":exhibitionWork_4", $_FILES["exhibitionWork_4"]["name"]);

        // Выполняем sql запрос
        $stmt->execute();

        // Ну, а дальше уже ты знаешь
        http_response_code(200);

        $res = [
            "status" => true,
            "id" => $connection->lastInsertId(),
            "message" => "Преподаватель добавлен",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Обновление фотографии происходить так: мы добавляем в бд новые фотографии за место старых
// Так как нельзя изменить фотографии можно только добавить новые
function updateTeachersPhotos($connection)
{

    try {
        $sql =
            "UPDATE `teacher` SET `teacherImg` = :teacherImg, `exhibitionWork_1` = :exhibitionWork_1, `exhibitionWork_2` = :exhibitionWork_2, `exhibitionWork_3` = :exhibitionWork_3, `exhibitionWork_4` = :exhibitionWork_4 WHERE `teacher`.`id` = :id";

        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям, а точней в глобальной методе $_FILES находятся фотографии,
        // которые мы указали в форме, а поле ["name"] хранит в себе название изображения
        // Также нужно не забывать о том, что мы меняем фотки у определенного препода, поэтому нам нужно его id
        $stmt->bindValue(":teacherImg", $_FILES['teacherImg']["name"]);
        $stmt->bindValue(":exhibitionWork_1", $_FILES["exhibitionWork_1"]["name"]);
        $stmt->bindValue(":exhibitionWork_2", $_FILES["exhibitionWork_2"]["name"]);
        $stmt->bindValue(":exhibitionWork_3", $_FILES["exhibitionWork_3"]["name"]);
        $stmt->bindValue(":exhibitionWork_4", $_FILES["exhibitionWork_4"]["name"]);
        $stmt->bindValue(":id", $_POST["id"]);

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Фотографии преподавателя обновлены"
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

}

// Данная функция обновляет заголовок у преподавателей
// способ похож с предыдущем, только теперь вместо $_FILES, мы используем $data, так как наши названия фотографий
// находятся в переменной $data. Почему так? Потому-что для того, чтобы менять данные необходимо использовать метод
// PATCH, но этот метод не поддерживает никакие файлы, только их названия. Поэтому приходится выкручиваться
// Также, если вы спросите, а почему бы не оставить фотки пустые, то в таком случае мы получим ситуацию,
// где все фотки у препода сбросятся из-за того, что поля с фотографиями по умолчанию ВСЕГДА пустые
// Поэтому в бд в местах, где должна быть фотка будет пустая строка
function updateTeacher($connection, $data)
{

    try {

        $sql =
            "UPDATE `teacher` SET `teacherImg` = :teacherImg, `title` = :title, `exhibitionWork_1` = :exhibitionWork_1, `exhibitionWork_2` = :exhibitionWork_2, `exhibitionWork_3` = :exhibitionWork_3, `exhibitionWork_4` = :exhibitionWork_4 WHERE `teacher`.`id` = :id";

        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям
        $stmt->bindValue(":teacherImg", $data['teacherImg']);
        $stmt->bindValue(":title", $data["title"]);
        $stmt->bindValue(":exhibitionWork_1", $data["exhibitionWork_1"]);
        $stmt->bindValue(":exhibitionWork_2", $data["exhibitionWork_2"]);
        $stmt->bindValue(":exhibitionWork_3", $data["exhibitionWork_3"]);
        $stmt->bindValue(":exhibitionWork_4", $data["exhibitionWork_4"]);
        $stmt->bindValue(":id", $data["id"]);


        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Заголовок у преподавателя обновлен"
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

// Здесь мы проверяем метод, который отправила форма и исходя из этого метода выполняем код
switch ($method) {
    case "GET":
        // Если переменная $id не равняется 0, значит мы хотим получить определенные данные, иначе все
        if (isset($id)) {
            getTeacher($connection, $id);
        } else {
            getTeachers($connection);
        }
    break;
    case "DELETE":
        deleteTeacher($connection, $id);
    break;
    case "POST":
        // По сути та же логика, есть id, значит нужно изменить данные, иначе создать
        if (isset($id)) {
            addTeacher($connection, $_POST);
        } else {
            updateTeachersPhotos($connection);
        }
    break;
    case "PATCH":
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        updateTeacher($connection, $data);
    break;
}

?>
