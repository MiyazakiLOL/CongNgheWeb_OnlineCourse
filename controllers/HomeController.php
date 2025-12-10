<?php
// controllers/HomeController.php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/User.php';

class HomeController 
{
    private $courseModel;
    private $categoryModel;

    public function __construct() 
    {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
    }

    public function index() 
    {
        // Lấy khóa học nổi bật (đã duyệt + có nhiều đăng ký nhất - giả lập top 6)
        $featuredCourses = $this->courseModel->getFeaturedCourses(); // sẽ thêm method này

        // Lấy danh mục để hiển thị bộ lọc
        $categories = $this->categoryModel->getAll();

        // Lấy khóa học mới nhất
        $latestCourses = $this->courseModel->getLatestCourses(6);

        // Đưa dữ liệu vào view
        require __DIR__ . '/../views/home/index.php';
    }
}