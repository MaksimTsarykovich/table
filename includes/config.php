<?php
session_start();

$mysqli = mysqli_connect("localhost", "root", "", "task");
if (!$mysqli) {
    $_SESSION['error'] = "Ошибка бд: " . mysqli_connect_error();
}
