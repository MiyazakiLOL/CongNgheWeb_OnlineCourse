<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->email = $_POST['email'] ?? '';
            $userModel->password = $_POST['password'] ?? '';

            $user = $userModel->login();

            if ($user) {
                $_SESSION['user'] = $user;
                // Redirect theo role
                switch ($user['role']) {
                    case 2:
                        header('Location: /admin/dashboard');
                        exit;
                    case 1:
                        header('Location: /instructor/dashboard');
                        exit;
                    default:
                        header('Location: /');
                        exit;
                }
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        }

        $title = "Đăng nhập";
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
            $userModel->role     = (int)($_POST['role'] ?? 0); // 0=student, 1=instructor

            if ($userModel->register()) {
                header('Location: /auth/login?success=1');
                exit;
            } else {
                $error = "Đăng ký thất bại! Email hoặc username đã tồn tại.";
            }
        }

        $title = "Đăng ký";
        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }
}