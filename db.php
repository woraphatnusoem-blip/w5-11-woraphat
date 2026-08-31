<?php
$host = "localhost";
$user = "root";
$pass = ""; // ถ้าใช้ Mac/MAMP แล้วเชื่อมไม่ได้ ให้ลองใส่ "root"
$dbname = "bit23_w5_db";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
}
?>