<?php
// controllers/StudentController.php
// 1. Gọi file cấu hình và Model
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Enrollment.php';
class StudentController
{
    private $db;
    private $enrollmentModel;
    private function requireLogin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: /auth/login');
            exit;
        }
    }
    public function __construct()
    {
        
// Kết nối Database
        $database = new Database();
        $this->db = $database->connect();

        // Khởi tạo Model (Dòng này giúp $this->enrollmentModel KHÔNG bị null)
        $this->enrollmentModel = new Enrollment($this->db);

        // Khởi động session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
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
    // Hàm hiển thị danh sách khóa học của tôi
    public function my_courses() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $student_id = $_SESSION['user']['id'];

        // 2. Lấy danh sách khóa học đã đăng ký từ Model
        // Hàm getByStudentId đã được viết trong Enrollment.php ở các bước trước
        $myCourses = $this->enrollmentModel->getByStudentId($student_id);

        // 3. Gọi View để hiển thị
        require __DIR__ . '/../views/student/my_courses.php';
    }
}