<?php
// controllers/AdminController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

// Đảm bảo BASE_URL được định nghĩa để tránh lỗi
if (!defined('BASE_URL')) {
    define('BASE_URL', '/onlinecourse'); 
}

class AdminController {
    private $userModel;
    private $categoryModel;
    private $courseModel;
    private $enrollmentModel;

    public function __construct() {
        $this->userModel = new User();
        $this->categoryModel = new Category();
        $this->courseModel = new Course();
        $this->enrollmentModel = new Enrollment();
    }

    // Hàm kiểm tra quyền Admin
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Kiểm tra xem đã đăng nhập và có phải role = 2 (Admin) hay không
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? -1) != 2) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    // ==================== DASHBOARD ====================
    public function dashboard() {
        $this->checkAdmin();
        
        // Lấy thống kê
        // Lưu ý: Đảm bảo model Course có hàm getAllForAdmin() hoặc dùng getAll()
        $courses = method_exists($this->courseModel, 'getAllForAdmin') 
                    ? $this->courseModel->getAllForAdmin() 
                    : $this->courseModel->getAll();

        $stats = [
            'total_users' => count($this->userModel->getAllUsers()),
            'total_courses' => count($courses),
            'total_categories' => count($this->categoryModel->getAll()),
            // Nếu chưa có bảng enrollments thì để 0 để tránh lỗi
            'total_enrollments' => method_exists($this->enrollmentModel, 'getTotal') ? $this->enrollmentModel->getTotal() : 0
        ];

        // Lấy dữ liệu cho bảng hiển thị nhanh
        $categories = $this->categoryModel->getAll();
        $users = $this->userModel->getAllUsers(); // Giới hạn số lượng nếu cần trong model
        
        $user = $_SESSION['user'];

        // --- GỌI VIEW ---
        // Không include header/footer ở đây vì trong view đã có rồi
        if (file_exists(__DIR__ . '/../views/admin/dashboard.php')) {
            require __DIR__ . '/../views/admin/dashboard.php';
        } else {
            echo "Lỗi: Không tìm thấy file views/admin/dashboard.php";
        }
    }

    // ==================== QUẢN LÝ DANH MỤC (CATEGORIES) ====================
    public function categories($action = 'list', $id = null) {
        $this->checkAdmin();

        switch ($action) {
            case 'list':
                $categories = $this->categoryModel->getAll();
                require __DIR__ . '/../views/admin/categories/list.php';
                break;

            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->categoryModel->name = trim($_POST['name']);
                    $this->categoryModel->description = trim($_POST['description'] ?? '');

                    if ($this->categoryModel->create()) {
                        $_SESSION['success'] = "Thêm danh mục thành công!";
                        header('Location: ' . BASE_URL . '/admin/categories'); 
                        exit;
                    } else {
                        $_SESSION['error'] = "Thêm thất bại!";
                    }
                }
                require __DIR__ . '/../views/admin/categories/create.php';
                break;

            case 'edit':
                if (!$id || !is_numeric($id)) {
                    header('Location: ' . BASE_URL . '/admin/categories'); 
                    exit;
                }

                $category = $this->categoryModel->getById($id);
                if (!$category) {
                    $_SESSION['error'] = "Danh mục không tồn tại!";
                    header('Location: ' . BASE_URL . '/admin/categories'); 
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->categoryModel->id = $id;
                    $this->categoryModel->name = trim($_POST['name']);
                    $this->categoryModel->description = trim($_POST['description'] ?? '');

                    if ($this->categoryModel->update()) {
                        $_SESSION['success'] = "Cập nhật danh mục thành công!";
                        header('Location: ' . BASE_URL . '/admin/categories'); 
                        exit;
                    } else {
                        $error = "Cập nhật thất bại!";
                    }
                }
                // Truyền biến $category sang view
                require __DIR__ . '/../views/admin/categories/edit.php';
                break;

            case 'delete':
                if ($id && is_numeric($id)) {
                    $this->categoryModel->id = $id;
                    // Cần đảm bảo model có hàm delete()
                    if ($this->categoryModel->delete()) {
                        $_SESSION['success'] = "Xóa danh mục thành công!";
                    } else {
                        $_SESSION['error'] = "Xóa thất bại (có thể danh mục đang chứa khóa học)!";
                    }
                }
                header('Location: ' . BASE_URL . '/admin/categories'); 
                exit;
                break;

            default:
                header('Location: ' . BASE_URL . '/admin/dashboard'); 
                exit;
        }
    }

    // ==================== QUẢN LÝ NGƯỜI DÙNG (USERS) ====================
    public function users($action = 'list', $id = null) {
        $this->checkAdmin();

        switch ($action) {


            case 'edit':
                if (!$id || !is_numeric($id)) {
                    header('Location: ' . BASE_URL . '/admin/users'); 
                    exit;
                }

                $user = $this->userModel->getById($id);
                if (!$user) {
                    header('Location: ' . BASE_URL . '/admin/users'); 
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $role = (int)$_POST['role'];
                    // Kiểm tra role hợp lệ (0: Student, 1: Instructor, 2: Admin)
                    if (in_array($role, [0, 1, 2])) {
                        if ($this->userModel->updateRole($id, $role)) {
                            $_SESSION['success'] = "Cập nhật vai trò thành công!";
                        } else {
                            $_SESSION['error'] = "Cập nhật thất bại!";
                        }
                    }
                    header('Location: ' . BASE_URL . '/admin/users'); 
                    exit;
                }

                require __DIR__ . '/../views/admin/users/edit.php';
                break;

            case 'delete':
                if (!$id || !is_numeric($id)) {
                    $_SESSION['error'] = "ID không hợp lệ!";
                } elseif ($id == ($_SESSION['user']['id'] ?? 0)) {
                    $_SESSION['error'] = "Bạn không thể xóa chính tài khoản mình đang đăng nhập!";
                } else {
                    if ($this->userModel->delete($id)) {
                        $_SESSION['success'] = "Xóa người dùng thành công!";
                    } else {
                        $_SESSION['error'] = "Xóa thất bại!";
                    }
                }
                header('Location: ' . BASE_URL . '/admin/users'); 
                exit;
                break;

            default:
                header('Location: ' . BASE_URL . '/admin/dashboard'); 
                exit;
        }
    }
}
?>