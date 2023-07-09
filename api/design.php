<?php

require "headers.php";
require "../pages-blocks/connect.php";

$method = $_SERVER["REQUEST_METHOD"];
if (isset($_GET["id"]))
    $id = $_GET["id"];

function getDesigns($connection)
{
    try {
        $designArray = [];
        $design = $connection->query("SELECT * FROM artDesign");

        while ($row = $design->fetch(PDO::FETCH_ASSOC)) {
            $designArray[] = $row;
        }
        echo json_encode($designArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function getDesign($connection, $id)
{
    try {
        $designArray = [];
        $design = $connection->query(
            "SELECT * FROM artDesign WHERE `artDesign`.`id` = $id"
        );

        while ($row = $design->fetch(PDO::FETCH_ASSOC)) {
            $designArray[] = $row;
        }
        echo json_encode($designArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function deleteDesign($connection, $id)
{
    try {
        $connection->query("DELETE FROM artDesign WHERE `artDesign`.`id` = $id");

        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Мастер-курс удален",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function addDesign($connection, $data)
{

    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);

    try {
        $sql =
            "INSERT INTO `artDesign` (`id`, `imageURL`, `title`, `tags_1`, `tags_2`, `tags_3`, `text`) VALUES (NULL, :imagesURL, :title, :tags_1, :tags_2, :tags_3, :text)";

        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям
        $stmt->bindValue(":imagesURL", $file['name']);
        $stmt->bindValue(":title", $_POST["title"]);
        $stmt->bindValue(":tags_1", $_POST["tags_1"]);
        $stmt->bindValue(":tags_2", $_POST["tags_2"]);
        $stmt->bindValue(":tags_3", $_POST["tags_3"]);
        $stmt->bindValue(":text", $_POST["text"]);

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "id" => $connection->lastInsertId(),
            "message" => "Мастер-курс добавлен",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function updatePhotoDesign($connection)
{
    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);

    try {
        $sql = "UPDATE `artDesign` SET `imageURL` = :imagesURL WHERE `artDesign`.`id` = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":imagesURL", $file["name"]);
        $stmt->bindValue(":id", $_POST['id']);

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Фотография арт-дизайна обновлена"
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

}

function updateDesign($connection, $data)
{

    try {
        $sql =
            "UPDATE `artDesign` SET `imageURL` = :imagesURL, `title` = :title, `tags_1` = :tags_1, `tags_2` = :tags_2, `tags_3` = :tags_3, `text` = :text WHERE `artDesign`.`id` = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":imagesURL", $data["imageURL"]["name"]);
        $stmt->bindValue(":title", $data["title"]);
        $stmt->bindValue(":tags_1", $data["tags_1"]);
        $stmt->bindValue(":tags_2", $data["tags_2"]);
        $stmt->bindValue(":tags_3", $data["tags_3"]);
        $stmt->bindValue(":text", $data["text"]);
        $stmt->bindValue(":id", $data["id"]);

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Арт-дизайн обновлен"
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

switch ($method) {
    case "GET":
        if (isset($id)) {
            getDesign($connection, $id);
        } else {
            getDesigns($connection);
        }
    break;
    case "DELETE":
        deleteDesign($connection, $id);
    break;
    case "POST":
        if (isset($id)) {
            addDesign($connection, $_POST);
        } else {
            updatePhotoDesign($connection);
        }
    break;
    case "PATCH":
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);

        updateDesign($connection, $data);
    break;
}

?>
