<?php
// controllers/InstructorController.php

require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';

class InstructorController {
    private $courseModel;
    private $categoryModel;

    public function __construct() {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
    }

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: ' . (defined('BASE_URL') ? BASE_URL : '/onlinecourse') . '/auth/login');
            exit;
        }
    }

    public function dashboard() {
        $this->requireLogin();
        $user = $_SESSION['user'];
        $courses = $this->courseModel->getByInstructor($user['id']);
        $title = "Dashboard Giảng viên";
        require __DIR__ . '/../views/instructor/dashboard.php';
    }

    // =================================================================
    // HÀM QUAN TRỌNG: XỬ LÝ URL dạng /instructor/courses/action/id
    // =================================================================
    public function courses($action = 'list', $id = null) {
        $this->requireLogin();

        switch ($action) {
            case 'create':
                $this->create(); // Gọi hàm create
                break;
            case 'store':
                $this->store(); // Gọi hàm xử lý lưu
                break;
            case 'edit':
                $this->edit($id); // Gọi hàm sửa
                break;
            case 'update':
                $this->update($id); // Gọi hàm xử lý update
                break;
            case 'delete':
                $this->delete($id); // Gọi hàm xóa
                break;
            case 'list':
            default:
                $this->myCourses(); // Mặc định hiện danh sách
                break;
        }
    }

    // --- CÁC HÀM XỬ LÝ CHI TIẾT (Đã sửa đường dẫn view thành /course/) ---

    // Hiện danh sách (My Courses)
    private function myCourses() {
        $user = $_SESSION['user'];
        $courses = $this->courseModel->getByInstructor($user['id']);
        $title = "Khóa học của tôi";
        // SỬA ĐƯỜNG DẪN VIEW: course (số ít)
        require __DIR__ . '/../views/instructor/course/manage.php'; 
        // Lưu ý: Bạn gọi file này là manage.php hay my_courses.php thì sửa tên tương ứng ở đây nhé
    }

    // Hiện form tạo mới
    private function create() {
        $categories = $this->categoryModel->getAll();
        $title = "Tạo khóa học mới";
        // SỬA ĐƯỜNG DẪN VIEW: course (số ít)
        require __DIR__ . '/../views/instructor/course/create.php';
    }

    private function uploadImage($file) {
        $targetDir = __DIR__ . '/../assets/uploads/courses/'; // Đường dẫn thư mục lưu ảnh
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Lấy đuôi file (jpg, png...)
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Kiểm tra xem có phải là ảnh thật không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return false;
        }

        // Chỉ cho phép định dạng ảnh phổ biến
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp" ) {
            return false;
        }

        // Đặt tên file mới để tránh trùng lặp (ví dụ: course_1702345678.jpg)
        $newFileName = 'course_' . time() . '.' . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        // Di chuyển file từ bộ nhớ tạm vào thư mục đích
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $newFileName; // Trả về tên file để lưu vào DB
        }
        
        return false;
    }

    // Xử lý lưu (Store)
    private function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->courseModel->title = $_POST['title'];
            $this->courseModel->description = $_POST['description'];
            $this->courseModel->price = $_POST['price'];
            $this->courseModel->category_id = $_POST['category_id'];
            $this->courseModel->level = $_POST['level'];
            $this->courseModel->duration_weeks = $_POST['duration_weeks'];
            $this->courseModel->instructor_id = $_SESSION['user']['id'];
            
            // --- XỬ LÝ UPLOAD ẢNH ---
            $imageName = 'default-course.png'; // Ảnh mặc định nếu không upload
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploaded = $this->uploadImage($_FILES['image']);
                if ($uploaded) {
                    $imageName = $uploaded;
                }
            }
            
            $this->courseModel->image = $imageName; 
            // ------------------------

            if ($this->courseModel->create()) {
                $_SESSION['success'] = "Tạo khóa học thành công!";
                header('Location: ' . BASE_URL . '/instructor/dashboard'); 
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra!";
                header('Location: ' . BASE_URL . '/instructor/courses/create');
            }
            exit;
        }
    }

    // Hiện form sửa
    private function edit($id) {
        $course = $this->courseModel->find($id);
        
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Không có quyền truy cập!";
            header('Location: ' . BASE_URL . '/instructor/dashboard.php');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $title = "Sửa khóa học";
        // SỬA ĐƯỜNG DẪN VIEW: course (số ít)
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    // Xử lý cập nhật (Update)
    private function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check quyền sở hữu
            $check = $this->courseModel->find($id);
            if ($check['instructor_id'] != $_SESSION['user']['id']) die("Access Denied");

            $this->courseModel->id = $id;
            $this->courseModel->title = $_POST['title'];
            $this->courseModel->description = $_POST['description'];
            $this->courseModel->price = $_POST['price'];
            $this->courseModel->category_id = $_POST['category_id'];
            $this->courseModel->level = $_POST['level'];
            $this->courseModel->duration_weeks = $_POST['duration_weeks'];
            $this->courseModel->image = $check['image']; 

            if ($this->courseModel->update()) {
                $_SESSION['success'] = "Cập nhật thành công!";
                
                // --- SỬA Ở ĐÂY: Chuyển hướng về Dashboard ---
                header('Location: ' . BASE_URL . '/instructor/dashboard');
            } else {
                $_SESSION['error'] = "Lỗi cập nhật!";
                // Nếu lỗi thì quay lại trang sửa
                header('Location: ' . BASE_URL . '/instructor/courses/edit/' . $id);
            }
            exit;
        }
    }

    // Xóa
    private function delete($id) {
        $course = $this->courseModel->find($id);
        if ($course && $course['instructor_id'] == $_SESSION['user']['id']) {
            $this->courseModel->delete($id);
            $_SESSION['success'] = "Đã xóa khóa học!";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa!";
        }
        header('Location: ' . BASE_URL . '/instructor/dashboard');
        exit;
    }

    // Quản lý học viên
    public function students() {
        $this->requireLogin();
        $user = $_SESSION['user'];

        $enrollmentModel = new Enrollment();
        $students = $enrollmentModel->getStudentsByInstructor($user['id']);

        $title = "Quản lý học viên";
        // Gọi View hiển thị
        require __DIR__ . '/../views/instructor/students/list.php';
    }
}
?>