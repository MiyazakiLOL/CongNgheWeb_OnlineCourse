<?php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class LessonController
{
    private function checkInstructor()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: /onlinecourse/auth/login');
            exit;
        }
    }

    // =============================
    // DANH SÁCH + QUẢN LÝ BÀI HỌC
    // =============================
    public function manage($course_id)
    {
        $this->checkInstructor();

        $courseModel = new Course();
        $lessonModel = new Lesson();

        $instructor_id = $_SESSION['user']['id'];

        // 🔐 kiểm tra quyền
        $course = $courseModel->findByInstructor($course_id, $instructor_id);

        if (!$course) {
            echo "<h3>❌ Khóa học không tồn tại hoặc bạn không có quyền</h3>";
            exit;
        }

        $lessons = $lessonModel->getByCourse($course_id);

        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }
}
