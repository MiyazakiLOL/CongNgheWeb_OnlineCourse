<?php
// controllers/AuthController.php

// 1. Nhúng Database và Model
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        // 2. Khởi tạo kết nối Database
        $database = new Database();
        $this->db = $database->connect();

        // 3. Truyền kết nối vào Model User
        $this->userModel = new User($this->db);

        // Khởi động session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gán dữ liệu từ Form vào Model
            $this->userModel->email = $_POST['email'] ?? '';
            $this->userModel->password = $_POST['password'] ?? '';

            // Gọi hàm login bên Model
            $user = $this->userModel->login();

            if ($user) {
                // Lưu session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['avatar'] = $user['avatar'] ?? 'default.png';

                // 4. REDIRECT ĐÚNG CHUẨN MVC (Dùng BASE_URL)
                // Không trỏ thẳng vào file view (.php)
                switch ($user['role']) {
                    case 2: // Admin
                        header('Location: ' . BASE_URL . '/admin/dashboard');
                        break;
                    case 1: // Instructor
                        header('Location: ' . BASE_URL . '/instructor/dashboard');
                        break;
                    case 0: // Student
                    default:
                        header('Location: ' . BASE_URL . '/student/dashboard'); // Hoặc về trang chủ '/'
                        break;
                }
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        }

        $title = "Đăng nhập";
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->username = $_POST['username'] ?? '';
            $this->userModel->email    = $_POST['email'] ?? '';
            $this->userModel->password = $_POST['password'] ?? ''; // Pass thô
            $this->userModel->fullname = $_POST['fullname'] ?? '';
            $this->userModel->role     = (int)($_POST['role'] ?? 0);

            // Kiểm tra email tồn tại
            if ($this->userModel->emailExists()) {
                $error = "Email này đã được sử dụng!";
            } else {
                if ($this->userModel->register()) {
                    // Redirect về trang login kèm thông báo
                    header('Location: ' . BASE_URL . '/auth/login?success=1');
                    exit;
                } else {
                    $error = "Đăng ký thất bại! Vui lòng thử lại.";
                }
            }
        }

        $title = "Đăng ký";
        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        // Xóa sạch session
        session_destroy();
        // Về trang chủ hoặc trang login
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
}
?>