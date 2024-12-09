<?php

use JetBrains\PhpStorm\NoReturn;

require_once('config.php');

function isMethodPOST(): bool
{
    if (!$_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['error'] = "Неверный метод запроса";
        return false;
    }
    return true;
}

function getAllTasks($mysqli): array
{
    $sql = "SELECT * FROM tasks";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода задач: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTaskStatus($mysqli, $task_id) : bool
{
    $sql = "SELECT `status` FROM tasks WHERE id = '$task_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода задач: " . mysqli_error($mysqli);
        exit();
    }
    return !mysqli_fetch_row($result)[0] == 0;
}

function createTask($name, $data, $mysqli): bool
{
    $sql = "INSERT INTO `tasks` (`id`, `name`, `status`, `data`) VALUES (NULL, '{$name}', '0' , '{$data}')";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка записи задачи: " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function deleteTask($id,$mysqli): bool
{
    $sql = "DELETE FROM `tasks` WHERE `id` = '$id'";
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка удаления задачи " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function editTask($name, $data): bool
{
    $sql = "UPDATE `tasks` SET `name` = '{$name}', `data` = '{$data}' WHERE `id` = '{$_GET['id']}'";
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка обновления задачи " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

#[NoReturn] function redirectToHomePage(): void
{
    header("Location: table/public/index.php");
    exit();
}

#[NoReturn] function redirectToEditPage(): void
{
    header("Location: table/public/edit.php");
    exit();
}

#[NoReturn] function redirectToCreatePage(): void
{
    header("Location: table/public/create.php");
    exit();
}
