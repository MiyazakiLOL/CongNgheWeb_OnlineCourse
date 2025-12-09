<?php 
// ĐẶT DÒNG NÀY LÊN ĐẦU TIÊN CỦA MỌI DASHBOARD
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    header('Location: /auth/login');
    exit;
}
$user = $_SESSION['user']; // BÂY GIỜ $user CHẮC CHẮN TỒN TẠI
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Xin chào Giảng viên <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>!</h2>
            <p class="text-muted">Theo dõi hiệu suất giảng dạy của bạn</p>
        </div>
        <div class="d-flex gap-3">
            <a href="/instructor/courses/create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tạo khóa học mới
            </a>
        </div>
    </div>

    <!-- Phần còn lại giữ nguyên -->
    <div class="row g-4 mb-5">
        <!-- ... các card thống kê ... -->
    </div>

    <h4>Khóa học của bạn</h4>
    <!-- ... bảng danh sách khóa học ... -->
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>