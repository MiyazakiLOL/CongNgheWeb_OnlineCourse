<?php
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Course.php';

class MaterialController
{
    private function checkInstructor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            $_SESSION['error'] = "Bạn không có quyền truy cập trang này.";
            header('Location: /');
            exit;
        }
    }

    private function checkCourseOwnership($owner_id, $user_id)
    {
        return intval($owner_id) === intval($user_id);
    }

    // ============================
    // 1. LIỆT KÊ TÀI LIỆU
    // ============================
    public function list($course_id)
    {
        $this->checkInstructor();
        $materialModel = new Material();
        $courseModel = new Course();

        $course = $courseModel->getById($course_id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền xem tài liệu của khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        $materials = $materialModel->getByCourse($course_id);

        require __DIR__ . '/../views/instructor/materials/list.php';
    }

    // ============================
    // 2. TỰA TRANG UPLOAD
    // ============================
    public function upload($course_id)
    {
        $this->checkInstructor();
        $courseModel = new Course();

        $course = $courseModel->getById($course_id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền upload tài liệu cho khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        require __DIR__ . '/../views/instructor/materials/upload.php';
    }

    // ============================
    // 3. XỬ LÝ UPLOAD TÀI LIỆU
    // ============================
    public function uploadMaterial($course_id)
    {
        $this->checkInstructor();
        $courseModel = new Course();
        $materialModel = new Material();

        $course = $courseModel->getById($course_id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền upload tài liệu cho khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Kiểm tra tiêu đề
            if (empty($title)) {
                $_SESSION['error'] = "Vui lòng nhập tiêu đề tài liệu.";
                header("Location: /material/upload/{$course_id}");
                exit;
            }

            // Kiểm tra tệp
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Vui lòng chọn một tệp hợp lệ.";
                header("Location: /material/upload/{$course_id}");
                exit;
            }

            $file = $_FILES['file'];
            $allowed_types = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'txt', 'jpg', 'jpeg', 'png', 'mp4', 'webm'];
            $max_size = 100 * 1024 * 1024; // 100MB

            // Kiểm tra loại tệp
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed_types)) {
                $_SESSION['error'] = "Loại tệp không được phép. Loại được phép: " . implode(', ', $allowed_types);
                header("Location: /material/upload/{$course_id}");
                exit;
            }

            // Kiểm tra kích thước
            if ($file['size'] > $max_size) {
                $_SESSION['error'] = "Kích thước tệp vượt quá giới hạn 100MB.";
                header("Location: /material/upload/{$course_id}");
                exit;
            }

            // Tạo thư mục upload
            $upload_dir = __DIR__ . '/../uploads/materials/' . $course_id;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Tạo tên tệp duy nhất
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $file_path = $upload_dir . '/' . $filename;

            // Upload tệp
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                // Lưu vào database
                $materialModel->course_id = $course_id;
                $materialModel->title = $title;
                $materialModel->filename = $filename;
                $materialModel->file_path = 'uploads/materials/' . $course_id . '/' . $filename;

                if ($materialModel->create()) {
                    $_SESSION['success'] = "Tài liệu đã được upload thành công!";
                    header("Location: /material/list/{$course_id}");
                    exit;
                } else {
                    $_SESSION['error'] = "Lỗi khi lưu tài liệu: " . $materialModel->error;
                    unlink($file_path); // Xóa tệp nếu lỗi database
                }
            } else {
                $_SESSION['error'] = "Lỗi khi upload tệp.";
            }

            header("Location: /material/upload/{$course_id}");
            exit;
        }
    }

    // ============================
    // 4. XÓA TÀI LIỆU
    // ============================
    public function delete($id)
    {
        $this->checkInstructor();
        $materialModel = new Material();
        $courseModel = new Course();

        $material = $materialModel->getById($id);

        if (!$material) {
            $_SESSION['error'] = "Tài liệu không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        $course = $courseModel->getById($material['course_id']);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền xóa tài liệu này.";
            header('Location: /course/myCourses');
            exit;
        }

        // Xóa tệp
        $file_path = __DIR__ . '/../' . $material['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Xóa record
        if ($materialModel->delete($id)) {
            $_SESSION['success'] = "Tài liệu đã được xóa thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa tài liệu. Vui lòng thử lại.";
        }

        header("Location: /material/list/{$material['course_id']}");
        exit;
    }

    // ============================
    // 5. TẢI XUỐNG TÀI LIỆU
    // ============================
    public function download($id)
    {
        $materialModel = new Material();
        $material = $materialModel->getById($id);

        if (!$material) {
            http_response_code(404);
            echo "Tài liệu không tồn tại.";
            exit;
        }

        // Kiểm tra quyền (sinh viên đã đăng ký hoặc giảng viên)
        // TODO: Thêm kiểm tra enrollment

        $file_path = __DIR__ . '/../' . $material['file_path'];

        if (!file_exists($file_path)) {
            http_response_code(404);
            echo "Tệp không tồn tại.";
            exit;
        }

        // Thiết lập headers để download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($material['filename']) . '"');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    }
}
