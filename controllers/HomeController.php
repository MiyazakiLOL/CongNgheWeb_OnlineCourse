<?php
// controllers/HomeController.php

require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/User.php';

class HomeController 
{
    private $courseModel;
    private $categoryModel;
    private $userModel;

    public function __construct() 
    {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    public function index() 
    {
        // Lấy khóa học nổi bật (đã duyệt + có nhiều đăng ký nhất - giả lập top 6)
        $featuredCourses = $this->courseModel->getFeaturedCourses(); // sẽ thêm method này

        // Lấy danh mục để hiển thị bộ lọc
        $categories = $this->categoryModel->getAll();

        // Lấy khóa học mới nhất
        $latestCourses = $this->courseModel->getLatestCourses(6);

        // Gắn tên giảng viên cho các course nếu có instructor_id
        $this->attachInstructorNames($featuredCourses);
        $this->attachInstructorNames($latestCourses);

        // Đưa dữ liệu vào view
        require __DIR__ . '/../views/home/index.php';
    }

    // Gắn trường instructor_name cho từng course (fallback: fullname -> username)
    private function attachInstructorNames(&$courses)
    {
        if (empty($courses) || !is_array($courses)) return;

        foreach ($courses as &$c) {
            $c['instructor_name'] = 'Giảng viên';
            if (!empty($c['instructor_id'])) {
                $u = $this->userModel->getById($c['instructor_id']);
                if ($u) {
                    $c['instructor_name'] = $u['fullname'] ?: $u['username'];
                }
            }
        }
        unset($c);
    }

    // ============================
    // TẤT CẢ KHÓA HỌC
    // ============================
    public function allCourses()
    {
        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            // TODO: Thêm search method vào Course model
            $courses = $this->courseModel->getAll();
        } else {
            $courses = $this->courseModel->getAll();
        }

        require __DIR__ . '/../views/courses/index.php';
    }

    // ============================
    // CHI TIẾT KHÓA HỌC
    // ============================
    public function detail($course_id)
    {
        $course = $this->courseModel->getById($course_id);

        if (!$course) {
            http_response_code(404);
            echo "<h1>404 - Khóa học không tồn tại</h1>";
            exit;
        }

        $lessonModel = new Lesson();
        $materialModel = new Material();
        
        $lessons = $lessonModel->getByCourse($course_id);
        $materials = $materialModel->getByCourse($course_id);

        require __DIR__ . '/../views/courses/detail.php';
    }
}