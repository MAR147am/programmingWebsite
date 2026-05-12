<?php
$conn = new mysqli("localhost", "root", "root", "ProgrammingCoursesDB");

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM Users");

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Check Users</title>";
echo "<style>
    body { font-family: Arial; padding: 30px; background: #f4f4f4; }
    h2 { color: #2c3e50; }
    table { border-collapse: collapse; background: white; width: 100%; max-width: 1000px; }
    th { background: #667eea; color: white; padding: 12px; }
    td { padding: 10px; border-bottom: 1px solid #ddd; word-break: break-all; }
    .status { padding: 15px; margin: 10px 0; border-radius: 8px; }
    .ok { background: #d4edda; color: #155724; }
    .bad { background: #f8d7da; color: #721c24; }
</style></head><body>";

echo "<h2>📊 المستخدمين المسجّلين في قاعدة البيانات:</h2>";

if ($result->num_rows == 0) {
    echo "<p style='color:red;'>⚠️ لا يوجد مستخدمين مسجّلين! روح على <a href='register.html'>register.html</a> وسجّل مستخدم جديد.</p>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>الحالة</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $isHashed = (strpos($row['password'], '$2y$') === 0);
        $statusText = $isHashed ? "✅ مشفّر" : "❌ غير مشفّر";
        $statusColor = $isHashed ? "green" : "red";
        
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td style='font-size:11px;'>" . htmlspecialchars($row['password']) . "</td>";
        echo "<td style='color:$statusColor; font-weight:bold;'>$statusText</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h2>📌 شرح:</h2>";
echo "<div class='status ok'>✅ <b>مشفّر:</b> الباسوورد يبدأ بـ <code>\$2y\$10\$</code> ← هذا صحيح، اللوقن راح يشتغل.</div>";
echo "<div class='status bad'>❌ <b>غير مشفّر:</b> الباسوورد ظاهر كنص واضح (مثل 123456) ← لازم تحذف المستخدم وتسجّل من جديد.</div>";

echo "<h2>🛠️ أزرار سريعة:</h2>";
echo "<a href='register.html' style='padding:10px 20px; background:#2ecc71; color:white; text-decoration:none; border-radius:5px; margin-right:10px;'>تسجيل مستخدم جديد</a>";
echo "<a href='login.html' style='padding:10px 20px; background:#667eea; color:white; text-decoration:none; border-radius:5px; margin-right:10px;'>تجربة تسجيل الدخول</a>";
echo "<a href='check.php?delete=all' style='padding:10px 20px; background:#e74c3c; color:white; text-decoration:none; border-radius:5px;' onclick=\"return confirm('متأكد تبي تحذف كل المستخدمين؟');\">حذف كل المستخدمين</a>";

// لو ضغط على زر الحذف
if (isset($_GET['delete']) && $_GET['delete'] == 'all') {
    $conn->query("DELETE FROM Users");
    echo "<p style='color:red; margin-top:20px;'>✅ تم حذف كل المستخدمين. <a href='check.php'>تحديث الصفحة</a></p>";
}

echo "</body></html>";

$conn->close();
?>
