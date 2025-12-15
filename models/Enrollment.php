<?php
// models/Enrollment.php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $conn;
    private $table = 'enrollments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getTotal() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalByStatus($status) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getByStudentId($student_id) {
    $query = "SELECT e.*, 
                     c.id AS course_id,      -- SỬA: dùng c.id thay vì c.course_id
                     c.title, 
                     c.description, 
                     c.image, 
                     c.price,
                     c.duration_weeks,
                     c.level,
                     u.fullname AS instructor_name,
                     e.progress,
                     e.status
              FROM enrollments e
              JOIN courses c ON e.course_id = c.id
              LEFT JOIN users u ON c.instructor_id = u.id
              WHERE e.student_id = :student_id
              ORDER BY e.enrolled_date DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    

    public function isEnrolled($student_id, $course_id) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE student_id = :student_id AND course_id = :course_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':student_id', $student_id);
        $stmt->bindValue(':course_id', $course_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Đăng ký khóa học
    public function enroll($student_id, $course_id) {
        $query = "INSERT INTO " . $this->table . " 
                  (student_id, course_id, enrolled_date, status, progress) 
                  VALUES (:student_id, :course_id, NOW(), 'active', 0)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':student_id', $student_id);
        $stmt->bindValue(':course_id', $course_id);
        
        if ($stmt->execute()) {
        return true;
    } else {
        // In lỗi chi tiết ra màn hình
        $error = $stmt->errorInfo();
        echo "<pre style='color:red; font-weight:bold'>";
        echo "Lỗi SQL Database: " . $error[2]; 
        echo "</pre>";
        die(); // Dừng lại để xem lỗi
    }
    }

    public function getStudentsByInstructor($instructor_id) {
        $query = "SELECT u.id, u.fullname, u.email,
                         c.title as course_title,
                         e.enrolled_date, e.progress, e.status
                  FROM " . $this->table . " e
                  JOIN courses c ON e.course_id = c.id
                  JOIN users u ON e.student_id = u.id
                  WHERE c.instructor_id = :instructor_id
                  ORDER BY e.enrolled_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>