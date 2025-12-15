<?php
require_once __DIR__ . '/../config/Database.php';

class Material
{
    private $conn;
    private $table = "materials";

    public $id;
    public $lesson_id;
    public $title;
    public $filename;
    public $file_path;
    public $file_type;
    public $uploaded_at;
    public $error;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getByLessonId($lessonId)
    {
        if (!$lessonId || !is_numeric($lessonId)) {
            $this->error = "lesson_id không hợp lệ";
            return [];
        }

        try {
            $sql = "SELECT * FROM {$this->table} WHERE lesson_id = ? ORDER BY uploaded_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$lessonId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return [];
        }
    }

    public function getById($id)
    {
        if (!$id || !is_numeric($id)) {
            $this->error = "id không hợp lệ";
            return null;
        }

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

    public function create()
    {
        if (!$this->lesson_id || !$this->title || !$this->filename) {
            $this->error = "lesson_id, filename là bắt buộc";
            return false;
        }

        try {
            $sql = "INSERT INTO {$this->table} (lesson_id, filename, file_path, file_type, uploaded_at)
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $this->lesson_id,
                $this->title,
                $this->filename,
                $this->file_path ?? '',
                $this->file_type ??''
            ]);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        if (!$id || !is_numeric($id)) {
            $this->error = "id không hợp lệ";
            return false;
        }

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