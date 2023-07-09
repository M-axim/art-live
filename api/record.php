<?php

require "headers.php";
require "../pages-blocks/connect.php";

$method = $_SERVER["REQUEST_METHOD"];
if (isset($_GET["id"]))
    $id = $_GET["id"];

function addRecord($connection, $data)
{

    try {
        $sql =
            "INSERT INTO `Record` (`id`, `surname`, `name`, `patronymic`, `tel`, `submitTitle`, `submitType`, `time`) VALUES (NULL, :surname, :name, :patronymic, :tel, :submitTitle, :submitType, :data)";

        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям
        $stmt->bindValue(":surname", $_POST['secondName']);
        $stmt->bindValue(":name", $_POST["name"]);
        $stmt->bindValue(":patronymic", $_POST["lastName"]);
        $stmt->bindValue(":tel", $_POST["tel"]);
        $stmt->bindValue(":submitTitle", $_POST["masterCourses"]);
        $stmt->bindValue(":submitType", $_POST["submitType"]);
        $stmt->bindValue(":data", date("Y-m-d H:i:s"));

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "id" => $connection->lastInsertId(),
            "message" => "Запись добавлена",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

switch ($method) {
    case "GET":
    break;
    case "DELETE":
    break;
    case "POST":
        addRecord($connection, $_POST);
    break;
    case "PATCH":
    break;
}

?>