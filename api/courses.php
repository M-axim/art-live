<?php

require "headers.php";
require "../pages-blocks/connect.php";

$method = $_SERVER["REQUEST_METHOD"];
if (isset($_GET["id"]))
    $id = $_GET["id"];

function getCourses($connection)
{
    try {
        $coursesArray = [];
        $courses = $connection->query("SELECT * FROM Courses");

        while ($row = $courses->fetch(PDO::FETCH_ASSOC)) {
            $coursesArray[] = $row;
        }
        http_response_code(200);

        echo json_encode($coursesArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function getCourse($connection, $id)
{
    try {
        $coursesArray = [];
        $courses = $connection->query(
            "SELECT * FROM Courses WHERE `Courses`.`id` = $id"
        );

        while ($row = $courses->fetch(PDO::FETCH_ASSOC)) {
            $coursesArray[] = $row;
        }
        http_response_code(200);

        echo json_encode($coursesArray);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

function deleteCourse($connection, $id)
{
    try {
        $connection->query("DELETE FROM Courses WHERE `Courses`.`id` = $id");

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

function addCourse($connection, $data)
{
    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);
    try {
        $sql =
            "INSERT INTO `Courses` (`id`, `imageURL`, `title`, `tags_1`, `tags_2`, `tags_3`, `text`) VALUES (NULL, :imagesURL, :title, :tags_1, :tags_2, :tags_3, :text)";

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

function updateCourse($connection, $id, $data)
{
    try {
        $sql =
            "UPDATE `Courses` SET `imageURL` = :imagesURL, `title` = :title, `tags_1` = :tags_1, `tags_2` = :tags_2, `tags_3` = :tags_3, `text` = :text WHERE `Courses`.`id` = :id";

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

function updatePhotoCourse ($connection)
{
    $file = $_FILES['imageURL'];
    $name = $file['name'];
    $pathFile = '../img/'.$name;

    move_uploaded_file($file['tmp_name'], $pathFile);

    try {
        $sql = "UPDATE `Courses` SET `imageURL` = :imagesURL WHERE `Courses`.`id` = :id";

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
        if (isset($id)) {
            getCourse($connection, $id);
        } else {
            getCourses($connection);
        }
    break;
    case "DELETE":
        deleteCourse($connection, $id);
    break;
    case "POST":
        if (isset($id))
            addCourse($connection, $_POST);
        else
            updatePhotoCourse($connection);
        break;
    case "PATCH":
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        updateCourse($connection, $id, $data);
    break;
}

?>
