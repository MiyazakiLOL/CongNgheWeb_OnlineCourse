<?php
// File: test_debug.php
require_once 'config/Database.php';

try {
    $db = new Database();
    $conn = $db->connect();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bật chế độ báo lỗi cực gắt

    echo "<h1>ĐANG TEST GHI DỮ LIỆU...</h1>";

    // 1. GIẢ LẬP DỮ LIỆU (Lấy theo cái Session bạn gửi lúc nãy)
    $student_id = 5;  // ID của user "Nguyen Huy Hai"
    $course_id = 4;   // Thay số này bằng ID khóa học bạn đang thử (ví dụ: 10, 11...)

    // 2. KIỂM TRA XEM USER CÓ TỒN TẠI KHÔNG
    $checkUser = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $checkUser->execute([$student_id]);
    if ($checkUser->rowCount() == 0) {
        die("<h3 style='color:red'>LỖI CHẾT NGƯỜI: User ID $student_id không tồn tại trong bảng 'users'. <br>-> Bạn đang đăng nhập bằng một tài khoản 'ma' không có trong CSDL hiện tại!</h3>");
    }
    echo "<p style='color:green'>✅ User ID $student_id có tồn tại.</p>";

    // 3. KIỂM TRA KHÓA HỌC CÓ TỒN TẠI KHÔNG
    $checkCourse = $conn->prepare("SELECT id FROM courses WHERE id = ?");
    $checkCourse->execute([$course_id]);
    if ($checkCourse->rowCount() == 0) {
        die("<h3 style='color:red'>LỖI: Course ID $course_id không tồn tại trong bảng 'courses'.</h3>");
    }
    echo "<p style='color:green'>✅ Course ID $course_id có tồn tại.</p>";

    // 4. THỬ INSERT
    $sql = "INSERT INTO enrollments (student_id, course_id, enrolled_date, status, progress) 
            VALUES (:sid, :cid, NOW(), 'active', 0)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':sid', $student_id);
    $stmt->bindValue(':cid', $course_id);
    
    if ($stmt->execute()) {
        echo "<h2 style='color:blue'>🎉 THÀNH CÔNG! Đã ghi được vào Database.</h2>";
        echo "Lỗi không phải do Database, mà do luồng code MVC (Controller/View).";
    }

} catch (PDOException $e) {
    echo "<div style='background:red; color:white; padding:20px;'>";
    echo "<h3>❌ LỖI SQL NGHIÊM TRỌNG:</h3>";
    echo $e->getMessage();
    echo "</div>";
}
?>