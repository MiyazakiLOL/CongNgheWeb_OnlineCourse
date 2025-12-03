<?php
// controllers/AdminController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

class AdminController {
    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function dashboard() {
        $this->checkAdmin();
        $userModel = new User();
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();

        $stats = [
            'total_users' => count($userModel->getAllUsers()),
            'total_courses' => count($courseModel->getAll()),
            'total_enrollments' => $enrollmentModel->getTotal(),
            'active_enrollments' => $enrollmentModel->getTotalByStatus('active')
        ];

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function manageUsers() {
        $this->checkAdmin();
        $userModel = new User();
        $users = $userModel->getAllUsers();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $role = $_POST['role'];
            $userModel->updateRole($id, $role);
            header('Location: /admin/users/manage');
        }

        require __DIR__ . '/../views/admin/users/manage.php';
    }

    // ... các method khác giữ nguyên (categories, etc.)
}
?>