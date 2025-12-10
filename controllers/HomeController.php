<?php
// controllers/HomeController.php

// 1. Nhúng file cấu hình Database
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/User.php';

class HomeController 
{
    private $db; // Biến lưu kết nối
    private $courseModel;
    private $categoryModel;
    private $userModel;

    public function __construct() 
    {
        // 2. Khởi tạo kết nối Database
        $database = new Database();
        $this->db = $database->connect();

        // 3. Truyền biến kết nối $this->db vào trong Model
        $this->courseModel = new Course($this->db);
        $this->categoryModel = new Category($this->db);
    }

    public function index() 
    {
        // Lấy khóa học nổi bật
        $featuredCourses = $this->courseModel->getFeaturedCourses();

        // Lấy danh mục
        $categories = $this->categoryModel->getAll();

        // Lấy khóa học mới nhất
        $latestCourses = $this->courseModel->getLatestCourses(6);

        // Gắn tên giảng viên cho các course nếu có instructor_id
        // $this->attachInstructorNames($featuredCourses);
        // $this->attachInstructorNames($latestCourses);

        // Đưa dữ liệu vào view
        require __DIR__ . '/../views/home/index.php';
    }
}
?>
