<?php
// models/Course.php
require_once __DIR__ . '/../config/Database.php';

class Course {
    private $conn;
    private $table = 'courses';

    public $id;
    public $title;
    public $description;
    public $instructor_id;
    public $category_id;
    public $price;
    public $duration_weeks;
    public $level;
    public $image;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Lấy khóa học nổi bật
    public function getFeaturedCourses($limit = 6) {
        $query = "SELECT c.*, u.fullname as instructor_name, 
                         COUNT(e.id) as enrollment_count
                  FROM courses c 
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN enrollments e ON c.id = e.course_id
                  WHERE c.image IS NOT NULL OR c.image != ''
                  GROUP BY c.id 
                  ORDER BY enrollment_count DESC, c.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khóa học mới nhất
    public function getLatestCourses($limit = 6) {
        $query = "SELECT c.*, u.fullname as instructor_name
                  FROM courses c 
                  LEFT JOIN users u ON c.instructor_id = u.id
                  ORDER BY c.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy khóa học theo ID
    public function getById($id) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name
                  FROM courses c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả khóa học (admin)
    public function getAll() {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name
                  FROM courses c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>