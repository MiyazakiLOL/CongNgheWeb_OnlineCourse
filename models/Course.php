<?php
// models/Course.php
require_once __DIR__ . '/../config/Database.php';

class Course {

    private $conn;
    private $table = 'courses';

    public $id;
    public $name;
    public $description;
    public $created_at;

    // Sửa constructor: nhận optional PDO $db (injection từ Controller) hoặc tự tạo Database nếu không có
    public function __construct($db = null) {
        if ($db instanceof PDO) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->connect();
        }
    }
   
//1. Hàm lấy danh sách khóa học nổi bật (Sửa lỗi Fatal Error của bạn tại đây)
    public function getFeaturedCourses() {
        // Logic: Lấy 4 khóa học có giá cao nhất làm "Nổi bật" (hoặc bạn có thể order by view/student count)
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.price DESC LIMIT 4";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Hàm lấy khóa học mới nhất (Dùng cho Trang chủ)
    public function getLatestCourses($limit = 6) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table. " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// models/Course.php (Bổ sung thêm vào class cũ)


    // 1. Hàm tìm kiếm và lọc danh sách khóa học
    public function getAll($keyword = "", $category_id = 0) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE 1=1"; // Kỹ thuật này giúp nối chuỗi AND dễ dàng hơn

        if (!empty($keyword)) {
            $query .= " AND c.title LIKE :keyword";
        }

        if ($category_id > 0) {
            $query .= " AND c.category_id = :cat_id";
        }

        $query .= " ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);

        if (!empty($keyword)) {
            $keyword = "%{$keyword}%";
            $stmt->bindValue(':keyword', $keyword);
        }
        if ($category_id > 0) {
            $stmt->bindValue(':cat_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy chi tiết một khóa học theo ID
    public function getById($id) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

