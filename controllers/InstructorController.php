<?php
class InstructorController
{
    private function requireLogin()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireLogin();
        $user = $_SESSION['user'];

        // Khóa học của giảng viên (mẫu)
        $myCourses = [
            ['id' => 1, 'title' => 'Lập trình PHP từ A-Z', 'students' => 1234, 'rating' => 4.8, 'revenue' => '₫45,200,000'],
            ['id' => 2, 'title' => 'JavaScript Nâng Cao', 'students' => 892, 'rating' => 4.9, 'revenue' => '₫32,100,000'],
        ];

        $title = "Dashboard Giảng viên";
        require __DIR__ . '/../views/instructor/dashboard.php';
    }
}