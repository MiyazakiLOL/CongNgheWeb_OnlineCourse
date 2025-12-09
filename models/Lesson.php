<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson
{
    private $conn;
    private $table = "lessons";

    public $id;
    public $course_id;
    public $title;
    public $content;
    public $video_url;
    public $error;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Lấy tất cả bài học
    public function all()
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

    // Alias cho find() - dùng để tương thích với CourseController
    public function getById($id)
    {
        return $this->find($id);
    }

    // Lấy bài học theo ID
    public function find($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return null;
        }
    }

    // Lấy bài học theo course_id
    public function getByCourse($course_id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE course_id = ? ORDER BY id ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$course_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }

    // Tạo bài học - version dùng công khai properties
    public function create()
    {
        if (!$this->course_id || !$this->title || !$this->content) {
            $this->error = "course_id, title, và content là bắt buộc";
            return false;
        }

        try {
            $sql = "INSERT INTO {$this->table} (course_id, title, content, video_url, created_at, updated_at)
                    VALUES (?, ?, ?, ?, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $this->course_id,
                $this->title,
                $this->content,
                $this->video_url ?? ''
            ]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Tạo bài học từ array (backwards compat)
    public function createFromArray($data)
    {
        $this->course_id = $data["course_id"] ?? null;
        $this->title = $data["title"] ?? '';
        $this->content = $data["content"] ?? '';
        $this->video_url = $data["video_url"] ?? '';
        return $this->create();
    }

    // Cập nhật bài học - version dùng công khai properties
    public function update($id)
    {
        if (!$this->title || !$this->content) {
            $this->error = "title và content là bắt buộc";
            return false;
        }

        try {
            $sql = "UPDATE {$this->table}
                    SET title = ?, content = ?, video_url = ?, updated_at = NOW()
                    WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $this->title,
                $this->content,
                $this->video_url ?? '',
                $id
            ]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Cập nhật bài học từ array (backwards compat)
    public function updateLesson($id, $data)
    {
        $this->course_id = $data["course_id"] ?? null;
        $this->title = $data["title"] ?? '';
        $this->content = $data["content"] ?? '';
        $this->video_url = $data["video_url"] ?? '';
        return $this->update($id);
    }

    // Xóa bài học
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
}
