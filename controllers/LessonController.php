<?php
// controllers/LessonController.php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../middleware.php'; // chứa requireInstructor()

class LessonController {
    private $lessonModel;
    private $courseModel;

    public function __construct() {
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Danh sách bài học của 1 khóa học
    public function manage() {
        requireInstructor();
        $courseId = (int)($_GET['course_id'] ?? 0);
        if (!$courseId) {
            header('Location: /onlinecourse/index.php?route=instructor/courses');
            exit;
        }

        // Chỉ cho phép giảng viên quản lý khóa học của chính họ
        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->courseBelongsToInstructor($courseId, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền truy cập khóa học này.');
        }

        $course = $this->courseModel->find($courseId);
        $lessons = $this->lessonModel->getByCourse($courseId);
        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    // Form tạo bài học
    public function create() {
        requireInstructor();
        $courseId = (int)($_GET['course_id'] ?? 0);
        if (!$courseId) {
            header('Location: /onlinecourse/index.php?route=instructor/courses');
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->courseBelongsToInstructor($courseId, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền tạo bài học cho khóa học này.');
        }

        $course = $this->courseModel->find($courseId);
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    // Lưu bài học mới
    public function store() {
        requireInstructor();
        $courseId = (int)($_POST['course_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $order = (int)($_POST['order'] ?? 1);

        if (!$courseId || $title === '') {
            $_SESSION['error'] = 'Thiếu dữ liệu bắt buộc.';
            header('Location: /onlinecourse/index.php?route=lesson/create&course_id=' . $courseId);
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->courseBelongsToInstructor($courseId, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền thêm bài học cho khóa học này.');
        }

        $saved = $this->lessonModel->create([
            'course_id' => $courseId,
            'title' => $title,
            'content' => $content,
            'video_url' => $video_url,
            'order' => $order
        ]);

        if ($saved) {
            $_SESSION['success'] = 'Đã tạo bài học.';
            header('Location: /onlinecourse/index.php?route=lesson/manage&course_id=' . $courseId);
        } else {
            $_SESSION['error'] = 'Tạo bài học thất bại.';
            header('Location: /onlinecourse/index.php?route=lesson/create&course_id=' . $courseId);
        }
        exit;
    }

    // Form chỉnh sửa bài học
    public function edit() {
        requireInstructor();
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: /onlinecourse/index.php?route=instructor/courses');
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->belongsToInstructor($id, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền sửa bài học này.');
        }

        $lesson = $this->lessonModel->find($id);
        $course = $this->courseModel->find((int)$lesson['course_id']);
        require __DIR__ . '/../views/instructor/lessons/edit.php';
    }

    // Cập nhật bài học
    public function update() {
        requireInstructor();
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $order = (int)($_POST['order'] ?? 1);

        if (!$id || $title === '') {
            $_SESSION['error'] = 'Thiếu dữ liệu bắt buộc.';
            header('Location: /onlinecourse/index.php?route=instructor/courses');
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->belongsToInstructor($id, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền cập nhật bài học này.');
        }

        $updated = $this->lessonModel->update([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'video_url' => $video_url,
            'order' => $order
        ]);

        // Lấy course_id để quay lại danh sách
        $lesson = $this->lessonModel->find($id);
        $courseId = (int)$lesson['course_id'];

        if ($updated) {
            $_SESSION['success'] = 'Đã cập nhật bài học.';
        } else {
            $_SESSION['error'] = 'Cập nhật bài học thất bại.';
        }
        header('Location: /onlinecourse/index.php?route=lesson/manage&course_id=' . $courseId);
        exit;
    }

    // Xóa bài học
    public function delete() {
        requireInstructor();
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: /onlinecourse/index.php?route=instructor/courses');
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        if (!$this->lessonModel->belongsToInstructor($id, $instructorId)) {
            http_response_code(403);
            exit('Bạn không có quyền xóa bài học này.');
        }

        // Lấy course_id để redirect sau khi xóa
        $lesson = $this->lessonModel->find($id);
        $courseId = (int)$lesson['course_id'];

        $deleted = $this->lessonModel->delete($id);
        $_SESSION['success'] = $deleted ? 'Đã xóa bài học.' : 'Xóa bài học thất bại.';

        header('Location: /onlinecourse/index.php?route=lesson/manage&course_id=' . $courseId);
        exit;
    }
}