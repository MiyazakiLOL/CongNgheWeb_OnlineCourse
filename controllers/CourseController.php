<?php
// controllers/CourseController.php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/User.php';

class CourseController
{
    private function checkInstructor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || (isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] != 1 : true)) {
            $_SESSION['error'] = "Bạn không có quyền truy cập trang này.";
            header('Location: /');
            exit;
        }
    }

    // Kiểm tra quyền sở hữu khóa học
    private function checkCourseOwnership($owner_id, $user_id)
    {
        if ($owner_id === null || $user_id === null) {
            return false;
        }

        return intval($owner_id) === intval($user_id);
    }

    // ============================
    // 1. DANH SÁCH KHÓA HỌC CỦA GIẢNG VIÊN
    // ============================
    public function myCourses()
    {
        $this->checkInstructor();
        $courseModel = new Course();

        $instructor_id = $_SESSION['user']['id'];
        $courses = $courseModel->getByInstructor($instructor_id);

        require __DIR__ . '/../views/instructor/my_courses.php';
    }

    // Public listing so /course works for browsing
    public function index()
    {
        $courseModel = new Course();
        $categoryModel = new Category();

        $courses = $courseModel->getAll();
        $categories = $categoryModel->getAll();

        require __DIR__ . '/../views/courses/index.php';
    }

    // Public course detail so /course/detail/{id} works
    public function detail($course_id)
    {
        $courseModel = new Course();
        $lessonModel = new Lesson();
        $materialModel = new Material();

        $course = $courseModel->getById($course_id);

        if (!$course) {
            http_response_code(404);
            echo "<h1>404 - Khóa học không tồn tại</h1>";
            exit;
        }

        $lessons = $lessonModel->getByCourse($course_id);
        $materials = $materialModel->getByCourse($course_id);

        require __DIR__ . '/../views/courses/detail.php';
    }

    // ============================
    // 2. TẠO KHÓA HỌC
    // ============================
    public function create()
    {
        $this->checkInstructor();
        $courseModel = new Course();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel->title = $_POST['title'] ?? '';
            $courseModel->description = $_POST['description'] ?? '';
            $courseModel->category_id = $_POST['category_id'] ?? '';
            $courseModel->instructor_id = $_SESSION['user']['id'];

            if ($courseModel->create()) {
                $_SESSION['success'] = "Khóa học đã được tạo thành công!";
                header('Location: /course/myCourses');
                exit;
            } else {
                $_SESSION['error'] = "Không thể tạo khóa học! Vui lòng kiểm tra lại thông tin.";
            }
        }

        require __DIR__ . '/../views/instructor/course/create.php';
    }

    // ============================
    // 3. CHỈNH SỬA KHÓA HỌC
    // ============================
    public function edit($id)
    {
        $this->checkInstructor();
        $courseModel = new Course();

        $course = $courseModel->getById($id);

        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền chỉnh sửa khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel->title = $_POST['title'] ?? '';
            $courseModel->description = $_POST['description'] ?? '';
            $courseModel->category_id = $_POST['category_id'] ?? '';

            if ($courseModel->update($id)) {
                $_SESSION['success'] = "Khóa học đã được cập nhật thành công!";
                header('Location: /course/myCourses');
                exit;
            } else {
                $_SESSION['error'] = "Cập nhật khóa học thất bại! Vui lòng thử lại.";
            }
        }

        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    // ============================
    // 4. XÓA KHÓA HỌC
    // ============================
    public function delete($id)
    {
        $this->checkInstructor();
        $courseModel = new Course();
        $lessonModel = new Lesson();

        $course = $courseModel->getById($id);
        
        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền xóa khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        // Xóa liên tầng: lessons -> materials -> course
        try {
            // 1. Lấy tất cả bài học của khóa học
            $lessons = $lessonModel->getByCourse($id);
            
            // 2. Xóa materials của từng bài học (nếu có)
            // Dùng SQL trực tiếp để xóa nhanh
            require_once __DIR__ . '/../models/Material.php';
            $materialModel = new Material();
            $materials = $materialModel->getByCourse($id);
            foreach ($materials as $material) {
                $materialModel->delete($material['id']);
            }
            
            // 3. Xóa tất cả bài học của khóa học
            foreach ($lessons as $lesson) {
                $lessonModel->delete($lesson['id']);
            }
            
            // 4. Xóa khóa học
            if ($courseModel->delete($id)) {
                $_SESSION['success'] = "Khóa học và tất cả nội dung liên quan đã được xóa thành công!";
            } else {
                $_SESSION['error'] = "Không thể xóa khóa học. Vui lòng thử lại.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Lỗi khi xóa khóa học: " . $e->getMessage();
        }

        header('Location: /course/myCourses');
        exit;
    }

    // ============================
    // 5. QUẢN LÝ BÀI HỌC
    // ============================
    public function lessons($course_id)
    {
        $this->checkInstructor();
        $lessonModel = new Lesson();
        $courseModel = new Course();

        $course = $courseModel->getById($course_id);

        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền xem bài học của khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        $lessons = $lessonModel->getByCourse($course_id);

        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    // ============================
    // 5.5 MATERIALS TRONG LESSON (TÀI LIỆU CHO KHÓA HỌC)
    // ============================
    public function materials($course_id)
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
            $_SESSION['error'] = "Bạn không có quyền xem tài liệu của khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        // Chuyển hướng tới MaterialController::list
        header("Location: /material/list/{$course_id}");
        exit;
    }

    // ============================
    // 6. TẠO BÀI HỌC
    // ============================
    public function createLesson($course_id)
    {
        $this->checkInstructor();
        $lessonModel = new Lesson();
        $courseModel = new Course();

        $course = $courseModel->getById($course_id);
        
        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền tạo bài học cho khóa học này.";
            header('Location: /course/myCourses');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel->course_id = $course_id;
            $lessonModel->title = $_POST['title'] ?? '';
            $lessonModel->content = $_POST['content'] ?? '';

            if ($lessonModel->create()) {
                $_SESSION['success'] = "Bài học đã được tạo thành công!";
                header("Location: /course/lessons/$course_id");
                exit;
            } else {
                $_SESSION['error'] = "Không thể tạo bài học! Vui lòng kiểm tra lại thông tin.";
            }
        }

        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    // ============================
    // 7. CHỈNH SỬA BÀI HỌC
    // ============================
    public function editLesson($id)
    {
        $this->checkInstructor();
        $lessonModel = new Lesson();
        $courseModel = new Course();

        $lesson = $lessonModel->getById($id);
        
        // Kiểm tra bài học tồn tại
        if (!$lesson) {
            $_SESSION['error'] = "Bài học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        $course = $courseModel->getById($lesson['course_id']);
        
        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền chỉnh sửa bài học này.";
            header('Location: /course/myCourses');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel->title = $_POST['title'] ?? '';
            $lessonModel->content = $_POST['content'] ?? '';

            if ($lessonModel->update($id)) {
                $_SESSION['success'] = "Bài học đã được cập nhật thành công!";
                header("Location: /course/lessons/" . $lesson['course_id']);
                exit;
            } else {
                $_SESSION['error'] = "Cập nhật bài học thất bại! Vui lòng thử lại.";
            }
        }

        require __DIR__ . '/../views/instructor/lessons/edit.php';
    }

    // ============================
    // 8. XÓA BÀI HỌC
    // ============================
    public function deleteLesson($id)
    {
        $this->checkInstructor();
        $lessonModel = new Lesson();
        $courseModel = new Course();

        $lesson = $lessonModel->getById($id);
        
        // Kiểm tra bài học tồn tại
        if (!$lesson) {
            $_SESSION['error'] = "Bài học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        $course = $courseModel->getById($lesson['course_id']);
        
        // Kiểm tra khóa học tồn tại
        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại.";
            header('Location: /course/myCourses');
            exit;
        }

        // Kiểm tra quyền sở hữu khóa học
        if (!$this->checkCourseOwnership($course['instructor_id'], $_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn không có quyền xóa bài học này.";
            header('Location: /course/myCourses');
            exit;
        }

        if ($lessonModel->delete($id)) {
            $_SESSION['success'] = "Bài học đã được xóa thành công!";
        } else {
            $_SESSION['error'] = "Không thể xóa bài học. Vui lòng thử lại.";
        }

        header("Location: /course/lessons/" . $lesson['course_id']);
        exit;
    }
}  