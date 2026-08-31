<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM notes WHERE note_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
}

header("Location: index.php");
exit;
?>