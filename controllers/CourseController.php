<?php
// controllers/CourseController.php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
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
public function detail($id = null) {
        
        // Logic: Nếu Router chưa truyền ID (hoặc null), thì thử tìm trong $_GET (phòng hờ)
        if (!$id && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }

        // Nếu vẫn không có ID thì dừng luôn
        if (!$id) {
            echo "Lỗi: Không tìm thấy ID khóa học!";
            return;
        }

        // Gọi Model
        $course = $this->courseModel->getById($id);

        if (!$course) {
            echo "Khóa học (ID: $id) không tồn tại trong CSDL!";
            return;
        }
        // Kiểm tra xem người dùng đã đăng ký khóa này chưa (nếu đã đăng nhập)
        $isEnrolled = false;
        if (isset($_SESSION['user_id'])) {
            $isEnrolled = $this->enrollmentModel->isEnrolled($_SESSION['user_id'], $id);
        }

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