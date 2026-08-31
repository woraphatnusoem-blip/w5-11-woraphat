<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $event_time = $_POST['event_time'];
    $category_id = $_POST['category_id'];

    $sql = "INSERT INTO notes (title, event_time, category_id) VALUES (:title, :event_time, :category_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':event_time' => $event_time,
        ':category_id' => $category_id
    ]);

    header("Location: index.php");
    exit;
}
?>