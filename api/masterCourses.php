<?php

require "headers.php";
require "../pages-blocks/connect.php";

$method = $_SERVER["REQUEST_METHOD"];
if (isset($_GET["id"]))
    $id = $_GET["id"];

function getMastersCourses($connection)
{
    try {
        $masterCoursesArray = [];
        $masterCourses = $connection->query("SELECT * FROM MasterCourses");

        while ($row = $masterCourses->fetch(PDO::FETCH_ASSOC)) {
            $masterCoursesArray[] = $row;
        }
        echo json_encode($masterCoursesArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function getMastersCourse($connection, $id)
{
    try {
        $masterCoursesArray = [];
        $masterCourses = $connection->query(
            "SELECT * FROM MasterCourses WHERE `MasterCourses`.`id` = $id"
        );

        while ($row = $masterCourses->fetch(PDO::FETCH_ASSOC)) {
            $masterCoursesArray[] = $row;
        }
        echo json_encode($masterCoursesArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function deleteMastersCourse($connection, $id)
{
    try {
        $connection->query(
            "DELETE FROM MasterCourses WHERE `MasterCourses`.`id` = $id"
        );

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

function addMastersCourse($connection, $data)
{
    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);

    try {
        $sql =
            "INSERT INTO `MasterCourses` (`id`, `imageURL`, `title`, `tags_1`, `tags_2`, `tags_3`, `text`) VALUES (NULL, :imagesURL, :title, :tags_1, :tags_2, :tags_3, :text)";

        $stmt = $connection->prepare($sql);
        // привязываем параметры к значениям
        $stmt->bindValue(":imagesURL", $file["name"]);
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

function updateMastersCourse($connection, $id, $data)
{
    try {
        $sql =
            "UPDATE `MasterCourses` SET `imageURL` = :imagesURL, `title` = :title, `tags_1` = :tags_1, `tags_2` = :tags_2, `tags_3` = :tags_3, `text` = :text WHERE `MasterCourses`.`id` = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":imagesURL", $data["imageURL"]["name"]);
        $stmt->bindValue(":title", $data["title"]);
        $stmt->bindValue(":tags_1", $data["tags_1"]);
        $stmt->bindValue(":tags_2", $data["tags_2"]);
        $stmt->bindValue(":tags_3", $data["tags_3"]);
        $stmt->bindValue(":text", $data["text"]);
        $stmt->bindValue(":id", $data["id"]);
        echo $data["id"];

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Мастер-курс обновлен",
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function updatePhotoMastersCourse ($connection)
{
    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);

    try {
        $sql = "UPDATE `MasterCourses` SET `imageURL` = :imagesURL WHERE `MasterCourses`.`id` = :id";

        $stmt = $connection->prepare($sql);

        $stmt->bindValue(":imagesURL", $file["name"]);
        $stmt->bindValue(":id", $_POST['id']);

        $stmt->execute();
        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Фотография мастер-курса обновлена"
        ];

        echo json_encode($res);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

switch ($method) {
    case "GET":
        if (isset($id))
            getMastersCourse($connection, $id);
        else
            getMastersCourses($connection);
        break;
    case "DELETE":
        deleteMastersCourse($connection, $id);
    break;
    case "POST":
        if (isset($id))
            addMastersCourse($connection, $_POST);
        else
            updatePhotoMastersCourse($connection);
    break;
    case "PATCH":
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        updateMastersCourse($connection, $id, $data);
    break;
}

?>
