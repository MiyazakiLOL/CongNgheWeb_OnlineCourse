<?php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class LessonController
{
    private $courseModel;
    private $lessonModel;

    public function __construct()
    {
        $this->courseModel = new Course();
        $this->lessonModel = new Lesson();
    }

    private function checkInstructor()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    private function isCourseOwner($course_id) {
        $course = $this->courseModel->getById($course_id);
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            return false;
        }
        return $course;
    }

    // ... (Giữ nguyên hàm manage và create) ...
    public function manage($course_id) {
        $this->checkInstructor();
        $course = $this->isCourseOwner($course_id);
        if (!$course) {
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }
        $lessons = $this->lessonModel->getByCourse($course_id);
        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    public function create($course_id) {
        $this->checkInstructor();
        $course = $this->isCourseOwner($course_id);
        if (!$course) {
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    // 3. XỬ LÝ LƯU (STORE) - Đã sửa theo CSDL mới
    public function store($course_id)
    {
        $this->checkInstructor();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isCourseOwner($course_id)) die("Unauthorized");

            // Gán dữ liệu đúng với cột trong bảng lessons
            $this->lessonModel->course_id = $course_id;
            $this->lessonModel->title = $_POST['title'];
            $this->lessonModel->content = $_POST['content'];
            $this->lessonModel->video_url = $_POST['video_url'];
            
            // Lấy giá trị order từ form, mặc định là 0 nếu không nhập
            $this->lessonModel->order = !empty($_POST['order']) ? $_POST['order'] : 0;

            if ($this->lessonModel->create()) {
                $_SESSION['success'] = "Thêm bài học thành công!";
                header("Location: " . BASE_URL . "/lesson/manage/" . $course_id);
            } else {
                $_SESSION['error'] = "Lỗi khi thêm bài học!";
                header("Location: " . BASE_URL . "/lesson/create/" . $course_id);
            }
            exit;
        }
    }

    // ... (Giữ nguyên hàm edit) ...
    public function edit($id) {
        $this->checkInstructor();
        $lesson = $this->lessonModel->getById($id);
        if (!$lesson || !$this->isCourseOwner($lesson['course_id'])) {
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            exit;
        }
        require __DIR__ . '/../views/instructor/lessons/edit.php';
    }

    // 5. XỬ LÝ CẬP NHẬT (UPDATE) - Đã sửa theo CSDL mới
    public function update($id)
    {
        $this->checkInstructor();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lesson = $this->lessonModel->getById($id);
            if (!$lesson || !$this->isCourseOwner($lesson['course_id'])) die("Unauthorized");

            $this->lessonModel->id = $id;
            $this->lessonModel->title = $_POST['title'];
            $this->lessonModel->content = $_POST['content'];
            $this->lessonModel->video_url = $_POST['video_url'];
            $this->lessonModel->order = !empty($_POST['order']) ? $_POST['order'] : 0;

            if ($this->lessonModel->update()) {
                $_SESSION['success'] = "Cập nhật thành công!";
                header("Location: " . BASE_URL . "/lesson/manage/" . $lesson['course_id']);
            } else {
                $_SESSION['error'] = "Lỗi cập nhật!";
                header("Location: " . BASE_URL . "/lesson/edit/" . $id);
            }
            exit;
        }
    }

    // ... (Giữ nguyên hàm delete) ...
    public function delete($id) {
        $this->checkInstructor();
        $lesson = $this->lessonModel->getById($id);
        if ($lesson && $this->isCourseOwner($lesson['course_id'])) {
            $this->lessonModel->delete($id);
            $_SESSION['success'] = "Xóa bài học thành công!";
            header("Location: " . BASE_URL . "/lesson/manage/" . $lesson['course_id']);
        } else {
            header('Location: ' . BASE_URL . '/instructor/dashboard');
        }
        exit;
    }
}
?>