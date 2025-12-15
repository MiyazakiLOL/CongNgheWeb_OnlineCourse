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

   public function __construct($db = null) {
        if ($db instanceof PDO) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->connect();
        }
    }

    // Lấy khóa học nổi bật
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

    // Lấy khóa học mới nhất
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

    // Hàm tìm kiếm và lọc danh sách khóa học
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

    // Lấy tất cả khóa học (admin)
    public function getAllForAdmin() {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name
                  FROM courses c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    //LẤY TẤT CẢ KHÓA HỌC CỦA MỘT GIẢNG VIÊN
    public function getByInstructor(int $instructor_id): array {
        $query = "SELECT c.*, cat.name as category_name
                  FROM $this->table c
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.instructor_id = :instructor_id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //LẤY 1 KHÓA HỌC THEO ID (CHI TIẾT)
    public function find(int $id): array|false {
        $query = "SELECT c.*, 
                         u.fullname as instructor_name,
                         cat.name as category_name
                  FROM $this->table c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }

    // --- HÀM CREATE ---
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, instructor_id, category_id, price, duration_weeks, level, image)
                  VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image)";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        // Bind params
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':instructor_id', $this->instructor_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':image', $this->image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
            
    //LẤY TẤT CẢ KHÓA HỌC CỦA MỘT GIẢNG VIÊN

    public function getByIdAndInstructor($course_id, $instructor_id)
{
    $sql = "SELECT * FROM courses 
            WHERE id = ? AND instructor_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$course_id, $instructor_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // --- HÀM CREATE ---
    

    // --- CẬP NHẬT HÀM UPDATE ---
    public function update() { // Bỏ tham số $id vì đã có $this->id
        $query = "UPDATE " . $this->table . "
                  SET title = :title, 
                      description = :description, 
                      category_id = :category_id, 
                      price = :price,
                      duration_weeks = :duration_weeks,
                      level = :level,
                      image = :image,
                      updated_at = NOW()
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind params
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa khóa học
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }
    public function findByInstructor($course_id, $instructor_id)
{
    $sql = "SELECT * FROM courses WHERE id = ? AND instructor_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$course_id, $instructor_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>