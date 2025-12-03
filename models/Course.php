<?php
// models/Course.php
require_once __DIR__ . '/../config/Database.php';

class Course {
    public function getByInstructor(int $instructorId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM courses WHERE instructor_id = ? ORDER BY created_at DESC');
        $stmt->execute([$instructorId]);
        return $stmt->fetchAll();
    }

    public function find(int $id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM courses WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            'INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())'
        );
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['instructor_id'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image']
        ]);
    }

    public function update(array $data): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            'UPDATE courses
             SET title=?, description=?, category_id=?, price=?, duration_weeks=?, level=?, image=?, updated_at=NOW()
             WHERE id=?'
        );
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['category_id'],
            $data['price'],
            $data['duration_weeks'],
            $data['level'],
            $data['image'],
            $data['id']
        ]);
    }

    public function delete(int $id): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('DELETE FROM courses WHERE id = ?');
        return $stmt->execute([$id]);
    }
}