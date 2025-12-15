<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    // Helper để lấy Base URL nếu chưa define (phòng hờ)
    private function getBaseUrl() {
        return defined('BASE_URL') ? BASE_URL : '/onlinecourse';
    }

    public function login()
    {
        // Đảm bảo session đã start để lưu user login
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->email = $_POST['email'] ?? '';
            $userModel->password = $_POST['password'] ?? '';

            $user = $userModel->login();

            if ($user) {
                $_SESSION['user'] = $user;
                
                $baseUrl = $this->getBaseUrl();

                // SỬA LỖI Ở ĐÂY: Chuyển hướng về Router (URL), KHÔNG chuyển về file .php
                switch ($user['role']) {
                    case 2: // Admin
                        header('Location: ' . $baseUrl . '/admin/dashboard');
                        exit;
                    case 1: // Instructor
                        header('Location: ' . $baseUrl . '/instructor/dashboard');
                        exit;
                    case 0: // Student
                        header('Location: ' . $baseUrl . '/student/dashboard'); // Hoặc trang chủ
                        exit;
                    default:
                         header('Location: ' . $baseUrl . '/');
                         exit;
                }
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        }

        $title = "Đăng nhập";
        // View vẫn include bình thường vì đây là lúc hiển thị form
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->username = $_POST['username'] ?? '';
            $userModel->email    = $_POST['email'] ?? '';
            $userModel->password = $_POST['password'] ?? '';
            $userModel->fullname = $_POST['fullname'] ?? '';
            $userModel->role     = (int)($_POST['role'] ?? 0); 

            if ($userModel->register()) {
                $baseUrl = $this->getBaseUrl();
                // SỬA LỖI: Chuyển hướng về Route Login
                header('Location: ' . $baseUrl . '/auth/login?register=success');
                exit;
            } else {
                $error = "Đăng ký thất bại! Email hoặc username đã tồn tại.";
            }
        }

        $title = "Đăng ký tài khoản";
        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        
        $baseUrl = $this->getBaseUrl();
        header('Location: ' . $baseUrl . '/auth/login');
        exit;
    }
}
?>