<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// ดึงข้อมูลประเภท (Category) ไปใส่ใน Dropdown
$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// ดึงรายการบันทึกทั้งหมด (SELECT)
$sql = "SELECT notes.*, categories.category_name 
        FROM notes 
        LEFT JOIN categories ON notes.category_id = categories.category_id 
        ORDER BY event_time ASC";
$stmt = $conn->query($sql);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกรายการ</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: #1e1e2e; color: #cdd6f4; }
        .card { background: #181825; padding: 25px; border-radius: 12px; max-width: 600px; margin: 0 auto 20px; border: 1px solid #313244; }
        h2 { margin-top: 0; color: #89b4fa; }
        label { font-size: 14px; color: #a6adc8; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #45475a; background: #313244; color: #fff; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #89b4fa; color: #11111b; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        button:hover { background: #b4befe; }
        table { width: 100%; border-collapse: collapse; background: #181825; margin-top: 10px; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; border-bottom: 1px solid #313244; text-align: left; }
        th { background: #313244; color: #89b4fa; }
        .btn-del { color: #f38ba8; text-decoration: none; font-weight: bold; }
        .btn-del:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="card">
    <h2>เพิ่มรายการบันทึกใหม่</h2>
    <form action="insert.php" method="POST">
        <label>หัวข้อ:</label>
        <input type="text" name="title" placeholder="กรอกหัวข้อ เช่น ซักผ้า, ส่งงาน" required>

        <label>เวลา:</label>
        <input type="datetime-local" name="event_time" required>

        <label>ประเภท (Category):</label>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">บันทึกข้อมูล (Insert)</button>
    </form>
</div>

<div class="card" style="max-width: 800px;">
    <h2>รายการที่บันทึกไว้ (Select)</h2>
    <table>
        <thead>
            <tr>
                <th>หัวข้อ</th>
                <th>เวลา</th>
                <th>ประเภท (Category)</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($notes) > 0): ?>
                <?php foreach ($notes as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['event_time'] ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td>
                        <a href="delete.php?id=<?= $row['note_id'] ?>" class="btn-del" onclick="return confirm('ยืนยันการลบ?')">ลบ (Delete)</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #a6adc8;">ยังไม่มีข้อมูลในระบบ</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>