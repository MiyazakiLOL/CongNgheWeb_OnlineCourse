<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $conn;
    private $table = 'lessons';

    // Các thuộc tính khớp với bảng trong CSDL
    public $id;
    public $course_id;
    public $title;
    public $content;
    public $video_url;
    public $order;      // Tương ứng với cột `order`
    public $created_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Lấy danh sách bài học theo khóa học
    public function getByCourse($course_id) {
        // Sắp xếp theo cột `order`
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE course_id = :course_id 
                  ORDER BY `order` ASC"; // Dùng dấu huyền cho `order`

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo bài học mới
    public function create() {
        // Lưu ý: dùng `order` trong câu lệnh SQL
        $query = "INSERT INTO " . $this->table . " 
                  (course_id, title, content, video_url, `order`, created_at)
                  VALUES (:course_id, :title, :content, :video_url, :order, NOW())";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->video_url = htmlspecialchars(strip_tags($this->video_url));

        // Bind data
        $stmt->bindParam(':course_id', $this->course_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':video_url', $this->video_url);
        $stmt->bindParam(':order', $this->order);

        return $stmt->execute();
    }

    // Cập nhật bài học
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, 
                      content = :content, 
                      video_url = :video_url, 
                      `order` = :order
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->video_url = htmlspecialchars(strip_tags($this->video_url));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':video_url', $this->video_url);
        $stmt->bindParam(':order', $this->order);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>