<?php
// controllers/AdminController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

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

    private function checkAdmin() {
        // Chỉ start session nếu chưa có
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? -1) != 2) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    public function dashboard() {
        $this->checkAdmin();
        
        // Chuẩn bị dữ liệu cho View
        $stats = [
            'total_users' => count($this->userModel->getAllUsers()),
            'total_courses' => count($this->courseModel->getAll()),
            'total_enrollments' => $this->enrollmentModel->getTotal(),
            'total_categories' => count($this->categoryModel->getAll())
        ];

        $categories = $this->categoryModel->getAll();
        $users = $this->userModel->getAllUsers();
        
        // Lấy thông tin user để hiển thị header
        $user = $_SESSION['user'];

        // Load View
        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/admin/dashboard.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    // ==================== QUẢN LÝ DANH MỤC ====================
    public function categories($action = 'list', $id = null) {
        $this->checkAdmin();
        $BASE_URL = defined('BASE_URL') ? BASE_URL : '/';

        switch ($action) {
            case 'list':
                $categories = $this->categoryModel->getAll();
                require __DIR__ . '/../views/layouts/header.php';
                require __DIR__ . '/../views/admin/categories/list.php';
                require __DIR__ . '/../views/layouts/footer.php';
                break;

            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->categoryModel->name = trim($_POST['name']);
                    $this->categoryModel->description = trim($_POST['description'] ?? '');

                    if ($this->categoryModel->create()) {
                        $_SESSION['success'] = "Thêm danh mục thành công!";
                        // 🔴 SỬA QUAN TRỌNG: Redirect về Route, KHÔNG redirect về file View
                        header('Location: ' . BASE_URL . '/admin/dashboard'); 
                        exit;
                    }
                }
                require __DIR__ . '/../views/layouts/header.php';
                require __DIR__ . '/../views/admin/categories/create.php';
                require __DIR__ . '/../views/layouts/footer.php';
                break;

            case 'edit':
                if (!$id || !is_numeric($id)) {
                    // SỬA: Điều hướng về Router Admin Dashboard
                    header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                    exit;
                }

                $category = $this->categoryModel->getById($id);
                if (!$category) {
                    $_SESSION['error'] = "Danh mục không tồn tại!";
                    // SỬA: Điều hướng về Router Admin Dashboard
                    header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->categoryModel->id = $id;
                    $this->categoryModel->name = trim($_POST['name']);
                    $this->categoryModel->description = trim($_POST['description'] ?? '');

                    if ($this->categoryModel->update()) {
                        $_SESSION['success'] = "Cập nhật danh mục thành công!";
                        // SỬA: Điều hướng về Router Admin Dashboard
                        header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                        exit;
                    } else {
                        $error = "Cập nhật thất bại!";
                    }
                }

                // Truyền biến $category cho view
                $category = $category; // đã có từ getById
                require __DIR__ . '/../views/layouts/header.php';
                require __DIR__ . '/../views/admin/categories/edit.php';
                require __DIR__ . '/../views/layouts/footer.php';
                break;

            case 'delete':
                if ($id && is_numeric($id)) {
                    $this->categoryModel->id = $id;
                    if ($this->categoryModel->delete()) {
                        $_SESSION['success'] = "Xóa danh mục thành công!";
                    } else {
                        $_SESSION['error'] = "Xóa thất bại (có thể danh mục đang có khóa học)!";
                    }
                }
                // SỬA: Điều hướng về Router Admin Dashboard
                header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                exit;
                break;

            default:
                // SỬA: Điều hướng về Router Admin Dashboard
                header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                exit;
        }
    }

    // ==================== QUẢN LÝ NGƯỜI DÙNG ====================
    public function users($action = 'list', $id = null) {
        $this->checkAdmin();
        $BASE_URL = defined('BASE_URL') ? BASE_URL : '/';

        switch ($action) {
            case 'list':
                $users = $this->userModel->getAllUsers();
                require __DIR__ . '/../views/layouts/header.php';
                require __DIR__ . '/../views/admin/users/list.php';
                require __DIR__ . '/../views/layouts/footer.php';
                break;

            case 'edit':
                if (!$id || !is_numeric($id)) {
                    $_SESSION['error'] = "ID người dùng không hợp lệ!";
                    // SỬA: Điều hướng về Router Admin Dashboard
                    header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                    exit;
                }

                $user = $this->userModel->getById($id);
                if (!$user) {
                    $_SESSION['error'] = "Người dùng không tồn tại!";
                    // SỬA: Điều hướng về Router Admin Dashboard
                    header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $role = (int)$_POST['role'];
                    if (in_array($role, [0, 1, 2])) {
                        if ($this->userModel->updateRole($id, $role)) {
                            $_SESSION['success'] = "Cập nhật vai trò thành công!";
                        } else {
                            $error = "Cập nhật thất bại!";
                        }
                    } else {
                        $error = "Vai trò không hợp lệ!";
                    }
                    // SỬA: Điều hướng về Router Admin Dashboard
                    header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                    exit;
                }

                require __DIR__ . '/../views/layouts/header.php';
                require __DIR__ . '/../views/admin/users/edit.php';
                require __DIR__ . '/../views/layouts/footer.php';
                break;

            case 'delete':
                if (!$id || !is_numeric($id)) {
                    $_SESSION['error'] = "ID không hợp lệ!";
                } elseif ($id == ($_SESSION['user']['id'] ?? 0)) {
                    $_SESSION['error'] = "Bạn không thể xóa chính mình!";
                } else {
                    if ($this->userModel->delete($id)) {
                        $_SESSION['success'] = "Xóa người dùng thành công!";
                    } else {
                        $_SESSION['error'] = "Xóa thất bại (có thể có dữ liệu liên quan)!";
                    }
                }
                // SỬA: Điều hướng về Router Admin Dashboard
                header('Location: ' . $BASE_URL . '/admin/dashboard'); 
                exit;
                break;

            default:
                // SỬA: Điều hướng về Router Admin Dashboard
                header('Location: ' . $BASE_URL . 'admin/dashboard'); 
                exit;
        }
    }
}
?>