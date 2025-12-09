<?php
// controllers/CourseController.php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Enrollment.php';

class CourseController {
    private $db;
    private $courseModel;
    private $categoryModel;
    private $enrollmentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect() ;
        $this->courseModel = new Course($this->db);
        $this->categoryModel = new Category($this->db);
        $this->enrollmentModel = new Enrollment($this->db);
        
        // Khởi động session nếu chưa có (để kiểm tra đăng nhập)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || (isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] != 1 : true)) {
            $_SESSION['error'] = "Bạn không có quyền truy cập trang này.";
            header('Location: /');
            exit;
        }
    }

    // Kiểm tra quyền sở hữu khóa học
    private function checkCourseOwnership($owner_id, $user_id)
    {
        if ($owner_id === null || $user_id === null) {
            return false;
        }

        return intval($owner_id) === intval($user_id);
    }

    // ============================
    // 1. DANH SÁCH KHÓA HỌC CỦA GIẢNG VIÊN
    // ============================
    public function myCourses()
    {
        $this->checkInstructor();
        $courseModel = new Course();

        $instructor_id = $_SESSION['user']['id'];
        $courses = $courseModel->getByInstructor($instructor_id);

        require __DIR__ . '/../views/instructor/my_courses.php';
    }

    // Public listing so /course works for browsing
    public function index()
    {
        $courseModel = new Course();
        $categoryModel = new Category();

        $courses = $courseModel->getAll();
        $categories = $categoryModel->getAll();

        require __DIR__ . '/../views/courses/index.php';
    }

    // 1. Hiển thị danh sách khóa học (có tìm kiếm)
    public function index() {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

        $courses = $this->courseModel->getAll($keyword, $category_id);
        $categories = $this->categoryModel->getAll();

        require __DIR__ . '/../views/courses/index.php';
    }

    // 2. Hiển thị chi tiết khóa học
// controllers/CourseController.php

public function detail($id = 0) {
    // 1. Luôn luôn lấy thông tin khóa học (Bất kể đã đăng nhập hay chưa)
    $course = $this->courseModel->getById($id);

    if (!$course) {
        echo "Khóa học không tồn tại!";
        return;
    }

    // 2. Mặc định là chưa đăng ký
    $isEnrolled = false; 

    // 3. Chỉ kiểm tra trạng thái đăng ký NẾU người dùng ĐÃ đăng nhập
    if (isset($_SESSION['user_id'])) {
        $isEnrolled = $this->enrollmentModel->isEnrolled($_SESSION['user_id'], $id);
    }

    // 4. Gọi View hiển thị
    require __DIR__ . '/../views/courses/detail.php';
}
    // 3. Xử lý đăng ký khóa học
    public function enroll() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang login
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $student_id = $_SESSION['user_id'];

        // Kiểm tra xem đã đăng ký chưa
        if ($this->enrollmentModel->isEnrolled($student_id, $course_id)) {
            echo "<script>alert('Bạn đã đăng ký khóa học này rồi!'); window.history.back();</script>";
            return;
        }

        // Thực hiện đăng ký
        if ($this->enrollmentModel->enroll($student_id, $course_id)) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href='index.php?controller=student&action=my_courses';</script>";
        } else {
            echo "Có lỗi xảy ra, vui lòng thử lại.";
        }
    }
}
?>
