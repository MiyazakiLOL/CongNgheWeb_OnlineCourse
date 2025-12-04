<?php
// controllers/CourseController.php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../middleware.php';

class CourseController {
    private $model;
    public function __construct() {
        $this->model = new Course();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Danh sách khóa học của giảng viên
    public function myCourses() {
        requireInstructor();
        $instructorId = $_SESSION['user']['id'];
        $courses = $this->model->getByInstructor($instructorId);
        require __DIR__ . '/../views/instructor/course/manage.php';
    }

    // Form tạo khóa học
    public function create() {
        requireInstructor();
        $categories = (new Category())->getAll();
        require __DIR__ . '/../views/instructor/course/create.php';
    }

    // Lưu khóa học mới
    public function store() {
        requireInstructor();
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = $_POST['category_id'] ?? null;
        $price = (float)($_POST['price'] ?? 0);
        $duration_weeks = (int)($_POST['duration_weeks'] ?? 0);
        $level = $_POST['level'] ?? 'Beginner';

        // Upload ảnh
        $imageName = null;
        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif'];
            if (in_array($ext, $allowed)) {
                $imageName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $target = __DIR__ . '/../assets/uploads/courses/' . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
            }
        }

        $this->model->create([
            'title'=>$title,
            'description'=>$description,
            'instructor_id'=>$_SESSION['user']['id'],
            'category_id'=>$category_id,
            'price'=>$price,
            'duration_weeks'=>$duration_weeks,
            'level'=>$level,
            'image'=>$imageName
        ]);

        header("Location: /onlinecourse/index.php?route=course/myCourses");
        exit;
    }

    // Form chỉnh sửa
    public function edit() {
        requireInstructor();
        $id = $_GET['id'] ?? null;
        $course = $this->model->find($id);
        $categories = (new Category())->getAll();
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    // Cập nhật khóa học
    public function update() {
        requireInstructor();
        $id = $_POST['id'];
        $course = $this->model->find($id);

        $imageName = $course['image'];
        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif'];
            if (in_array($ext, $allowed)) {
                $imageName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $target = __DIR__ . '/../assets/uploads/courses/' . $imageName;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);
                if (!empty($course['image'])) {
                    $oldPath = __DIR__ . '/../assets/uploads/courses/' . $course['image'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }
            }
        }

        $this->model->update([
            'id'=>$id,
            'title'=>$_POST['title'],
            'description'=>$_POST['description'],
            'category_id'=>$_POST['category_id'],
            'price'=>$_POST['price'],
            'duration_weeks'=>$_POST['duration_weeks'],
            'level'=>$_POST['level'],
            'image'=>$imageName
        ]);

        header("Location: /onlinecourse/index.php?route=course/myCourses");
        exit;
    }

    // Xóa khóa học
    public function delete() {
        requireInstructor();
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: /onlinecourse/index.php?route=course/myCourses");
        exit;
    }
}