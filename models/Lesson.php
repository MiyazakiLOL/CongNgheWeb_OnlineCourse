<?php
// models/Lesson.php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    public function getByCourse(int $courseId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM lessons WHERE course_id = ? ORDER BY `order` ASC, created_at ASC');
        $stmt->execute([$courseId]);
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM lessons WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            'INSERT INTO lessons (course_id, title, content, video_url, `order`, created_at)
             VALUES (?, ?, ?, ?, ?, NOW())'
        );
        return $stmt->execute([
            $data['course_id'],
            $data['title'],
            $data['content'],
            $data['video_url'],
            $data['order']
        ]);
    }

    public function update(array $data): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            'UPDATE lessons
             SET title = ?, content = ?, video_url = ?, `order` = ?
             WHERE id = ?'
        );
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['video_url'],
            $data['order'],
            $data['id']
        ]);
    }

    public function delete(int $id): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('DELETE FROM lessons WHERE id = ?');
        return $stmt->execute([$id]);
    }

    // Optional: đảm bảo giảng viên chỉ quản lý bài học của khóa học thuộc về họ
    public function belongsToInstructor(int $lessonId, int $instructorId): bool {
        $pdo = Database::getInstance();
        $sql = 'SELECT 1
                FROM lessons l
                JOIN courses c ON c.id = l.course_id
                WHERE l.id = ? AND c.instructor_id = ?
                LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$lessonId, $instructorId]);
        return (bool)$stmt->fetch();
    }

    public function courseBelongsToInstructor(int $courseId, int $instructorId): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT 1 FROM courses WHERE id = ? AND instructor_id = ? LIMIT 1');
        $stmt->execute([$courseId, $instructorId]);
        return (bool)$stmt->fetch();
    }
}