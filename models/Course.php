<?php
require_once __DIR__ . '/../config/Database.php';

class Course
{
    private $conn;
    private $table = "courses";

    public $id;
    public $title;
    public $description;
    public $category_id;
    public $instructor_id;
    public $error; // last error message

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Lấy tất cả khóa học (cho sinh viên xem)
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }

    // Lấy toàn bộ khóa học theo giảng viên
    public function getByInstructor($instructor_id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE instructor_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$instructor_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }

    // Lấy 1 khóa học theo id
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return null;
        }
    }

    // Lấy các khóa học nổi bật (nếu không có cột featured, trả về latest)
    public function getFeaturedCourses($limit = 6)
    {
        try {
            // Ưu tiên lấy các khóa học có cột `featured` = 1 nếu tồn tại
            // Nếu không, fallback về latest courses
            $limit = (int)$limit;

            // Thử truy vấn khóa học được đánh dấu featured
            $sql = "SELECT * FROM {$this->table} WHERE featured = 1 ORDER BY updated_at DESC LIMIT $limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                return $results;
            }

            // Nếu không có khóa học featured, trả về latest
            return $this->getLatestCourses($limit);
        } catch (Exception $e) {
            // Nếu truy vấn featured lỗi (ví dụ không có cột `featured`), fallback an toàn
            return $this->getLatestCourses($limit);
        }
    }

    // Lấy khóa học mới nhất
    public function getLatestCourses($limit = 6)
    {
        try {
            $limit = (int)$limit;
            $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT $limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }


    // Tạo khóa học
    public function create()
    {


        try {
            $sql = "INSERT INTO {$this->table} (title, description, category_id, instructor_id, created_at, updated_at)
                    VALUES (?, ?, ?, ?, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $this->title,
                $this->description,
                $this->category_id,
                $this->instructor_id
            ]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
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

    public function getByIdAndInstructor($course_id, $instructor_id)
{
    $sql = "SELECT * FROM courses 
            WHERE id = ? AND instructor_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$course_id, $instructor_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // --- HÀM CREATE ---
    

    // Cập nhật khóa học
    public function update($id)
    {
        try {
            $sql = "UPDATE {$this->table}
                    SET title = ?, description = ?, category_id = ?, updated_at = NOW()
                    WHERE id = ?";
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $this->title,
                $this->description,
                $this->category_id,
                $id
            ]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Xóa khóa học
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
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
