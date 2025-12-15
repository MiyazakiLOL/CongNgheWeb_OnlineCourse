<?php 
// Kiểm tra quyền giảng viên
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    header('Location: /auth/login');
    exit;
}
$user = $_SESSION['user'];

if (!defined('BASE_URL')) {
    // Nếu bạn đang chạy trên localhost/onlinecourse/
    define('BASE_URL', '/onlinecourse/'); 
}
else{
    //Không session_start() nữa

}

// Lấy khóa học của giảng viên
require_once __DIR__ . '/../../models/Course.php';
$courseModel = new Course();
$courses = $courseModel->getByInstructor($user['id']);
?>

<?php $title = "Dashboard Giảng viên"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Xin chào Giảng viên <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>!</h2>
            <p class="text-muted">Theo dõi hiệu suất giảng dạy của bạn</p>
        </div>
        <div class="d-flex gap-3">
            <div class="d-flex gap-2">
                <a href="<?= BASE_URL ?>/instructor/students" class="btn btn-outline-primary">
                    <i class="bi bi-people"></i> Quản lý Học viên
                </a>
                
                <a href="<?= BASE_URL ?>/instructor/courses/create" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tạo khóa học mới
                </a>
            </div>
        </div>
    </div>

    <!-- Thống kê mẫu -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-center p-4 bg-primary text-white">
                <h5>Tổng học viên</h5>
                <h3><?= array_sum(array_column($courses, 'enrollment_count' ?? [])) ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 bg-success text-white">
                <h5>Khóa học</h5>
                <h3><?= count($courses) ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 bg-warning text-white">
                <h5>Đánh giá TB</h5>
                <h3>4.8 ★</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-4 bg-info text-white">
                <h5>Doanh thu</h5>
                <h3>₫0</h3>
            </div>
        </div>
    </div>

    <h4 class="mb-4">Khóa học của bạn</h4>
    <?php if (!empty($courses)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle"> <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th style="width: 250px;">Hành động</th> </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $c): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($c['title']) ?></strong>
                                <br>
                                <small class="text-muted">ID: <?= $c['id'] ?></small>
                            </td>
                            <td><?= htmlspecialchars($c['category_name'] ?? 'Chưa có') ?></td>
                            <td><?= $c['price'] == 0 ? 'Miễn phí' : number_format($c['price']) . 'đ' ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/lesson/manage/<?= $c['id'] ?>" class="btn btn-sm btn-info text-white me-1" title="Quản lý bài học">
                                    <i class="bi bi-collection-play"></i> Xem
                                </a>

                                <a href="<?= BASE_URL ?>/instructor/courses/edit/<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>

                                <a href="<?= BASE_URL ?>/instructor/courses/delete/<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này không? Hành động này không thể hoàn tác!')">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>