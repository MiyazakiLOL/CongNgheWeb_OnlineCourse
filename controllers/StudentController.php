<?php
// controllers/StudentController.php
class StudentController
{
    private function requireLogin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireLogin();
        $user = $_SESSION['user'];

        // Lấy danh sách khóa học đã đăng ký (sẽ làm sau, tạm để mẫu)
        $enrolledCourses = [
            ['id' => 1, 'title' => 'Lập trình PHP từ A-Z', 'progress' => 65, 'image' => 'php.jpg'],
            ['id' => 2, 'title' => 'Thiết kế giao diện với Bootstrap 5', 'progress' => 30, 'image' => 'bootstrap.jpg'],
            ['id' => 3, 'title' => 'JavaScript Nâng Cao', 'progress' => 100, 'image' => 'js.jpg'],
        ];

        $title = "Dashboard Học viên";
        require __DIR__ . '/../views/student/dashboard.php';
    }
}