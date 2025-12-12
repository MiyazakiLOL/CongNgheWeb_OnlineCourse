<?php
session_start();


// ĐỊNH NGHĨA BASE_URL – CHỈ LÀM 1 LẦN Ở ĐÂY
define('BASE_URL', '/onlinecourse');  // Nếu dự án trong thư mục onlinecourse
// define('BASE_URL', '');            // Nếu copy ra htdocs gốc thì dùng dòng này

// Kiểm tra đăng nhập + quyền học viên
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
    header('Location: ' . BASE_URL . '/auth/login');
    exit;
}

$user = $_SESSION['user'];

// Lấy dữ liệu an toàn
try {
    require_once __DIR__ . '/../../models/Enrollment.php';
    $enrollmentModel = new Enrollment();
    $enrolledCourses = $enrollmentModel->getByStudentId($user['id']) ?: [];

    $completedCourses = array_filter($enrolledCourses, fn($c) => ($c['progress'] ?? 0) >= 100);
} catch (Exception $e) {
    $enrolledCourses = [];
    $completedCourses = [];
    $db_error = "Tạm thời không tải được dữ liệu khóa học.";
}
?>

<?php $title = "Dashboard Học viên"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Xin chào, <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>!</h2>
            <p class="text-muted">Chào mừng bạn trở lại với hành trình học tập</p>
        </div>
    </div>

    <?php if (isset($db_error)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $db_error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Thống kê nhanh -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card text-center p-4 shadow-sm border-primary">
                <h5 class="text-primary">Khóa học đang học</h5>
                <h3 class="text-primary"><?= count($enrolledCourses) ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-4 shadow-sm border-success">
                <h5 class="text-success">Đã hoàn thành</h5>
                <h3 class="text-success"><?= count($completedCourses) ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-4 shadow-sm border-warning">
                <h5 class="text-warning">Chứng chỉ</h5>
                <h3 class="text-warning">0</h3>
                <small class="text-muted">(Sắp ra mắt)</small>
            </div>
        </div>
    </div>

    <!-- Danh sách khóa học -->
    <h4 class="mb-4">
        <i class="bi bi-play-circle"></i> Tiếp tục học
    </h4>

    <?php if (empty($enrolledCourses)): ?>
        <div class="text-center py-5 bg-light rounded">
            <img src="<?= BASE_URL ?>/assets/img/empty-courses.svg" alt="Chưa có khóa học" width="200" class="mb-4 opacity-75">
            <h5 class="text-muted">Bạn chưa đăng ký khóa học nào</h5>
            <a href="<?= BASE_URL ?>/" class="btn btn-primary mt-3">Khám phá khóa học ngay</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($enrolledCourses as $course): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm hover-shadow transition">
                        <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= htmlspecialchars($course['image'] ?? 'default.jpg') ?>" 
                             class="card-img-top" style="height:180px; object-fit:cover;" 
                             alt="<?= htmlspecialchars($course['title'] ?? 'Khóa học') ?>">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold"><?= htmlspecialchars($course['title'] ?? 'Không có tiêu đề') ?></h6>
                            <small class="text-muted mb-2">
                                Giảng viên: <?= htmlspecialchars($course['instructor_name'] ?? 'Không rõ') ?>
                            </small>

                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar <?= ($course['progress'] ?? 0) >= 100 ? 'bg-success' : 'bg-primary' ?>" 
                                     style="width: <?= ($course['progress'] ?? 0) ?>%"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted"><?= ($course['progress'] ?? 0) ?>% hoàn thành</small>
                                <?php if (($course['progress'] ?? 0) >= 100): ?>
                                    <span class="badge bg-success">Hoàn thành</span>
                                <?php endif; ?>
                            </div>

                            <a href="<?= BASE_URL ?>/courses/detail/<?= $course['course_id'] ?? $course['id'] ?? '' ?>" 
                               class="btn btn-primary mt-3">Tiếp tục học</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    transition: all 0.3s ease;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>