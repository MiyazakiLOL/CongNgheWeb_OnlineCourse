<?php
// Kiểm tra quyền admin (role = 2)
$user = $_SESSION['user'] ?? ['fullname' => 'Admin', 'username' => 'Guest'];

if (!defined('BASE_URL')) {
    // Nếu bạn đang chạy trên localhost/onlinecourse/
    define('BASE_URL', '/onlinecourse/'); 
}


// Lấy dữ liệu danh mục
require_once __DIR__ . '/../../models/Category.php';
$categoryModel = new Category();
$categories = $categoryModel->getAll();

// Lấy dữ liệu thống kê (bạn đã có file reports/statistics.php, giả sử có biến $stats)
$stats = [
    'total_users' => 1234,
    'total_courses' => 567,
    'total_enrollments' => 8901,
    'total_categories' => count($categories)
];

// Lấy dữ liệu người dùng (giả sử có file users/manage.php trả về $users)
require_once __DIR__ . '/../../models/User.php';
$userModel = new User();
$users = $userModel->getAllUsers();
?>

<?php $title = "Quản trị hệ thống"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <!-- Hero Section - Chào mừng Admin -->
    <div class="bg-primary text-white rounded-3 p-5 mb-5 shadow-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Xin chào <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>!</h1>
                <p class="lead mb-0">Chào mừng bạn đến với bảng điều khiển quản trị. Quản lý hệ thống một cách dễ dàng.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <img src="<?= BASE_URL ?>/assets/img/admin-illustration.svg" alt="Admin" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>
    </div>

    <!-- Phần 1: Quản lý Danh mục -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 fw-bold text-primary">Quản lý Danh mục</h4>
            <a href="<?= BASE_URL ?>./admin/categories/create" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Thêm danh mục mới
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($categories)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">Chưa có danh mục nào.</p>
                    <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-primary">Tạo danh mục đầu tiên</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Số khóa học</th>
                                <th class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><?= $cat['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                                    <td><?= htmlspecialchars(substr($cat['description'] ?? '', 0, 80)) ?>...</td>
                                    <td>0</td>
                                    <td class="text-end">
                                        <a href="<?= BASE_URL ?>/admin/categories/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Sửa
                                        </a>
                                        <a href="<?= BASE_URL ?>/admin/categories/delete/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa danh mục này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Phần 2: Báo cáo thống kê -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white">
            <h4 class="mb-0 fw-bold text-success">Báo cáo & Thống kê</h4>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center p-4 bg-light rounded shadow-sm">
                        <i class="bi bi-people fs-1 text-primary"></i>
                        <h5 class="mt-3">Tổng người dùng</h5>
                        <h3 class="text-primary"><?= number_format($stats['total_users']) ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-4 bg-light rounded shadow-sm">
                        <i class="bi bi-book fs-1 text-success"></i>
                        <h5 class="mt-3">Tổng khóa học</h5>
                        <h3 class="text-success"><?= number_format($stats['total_courses']) ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-4 bg-light rounded shadow-sm">
                        <i class="bi bi-cart-check fs-1 text-info"></i>
                        <h5 class="mt-3">Tổng đăng ký</h5>
                        <h3 class="text-info"><?= number_format($stats['total_enrollments']) ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-4 bg-light rounded shadow-sm">
                        <i class="bi bi-tags fs-1 text-warning"></i>
                        <h5 class="mt-3">Danh mục</h5>
                        <h3 class="text-warning"><?= $stats['total_categories'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần 3: Quản lý người dùng -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0 fw-bold text-danger">Quản lý Người dùng</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><?= htmlspecialchars($u['fullname'] ?? $u['username']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <?php 
                                    $roles = [0 => 'Học viên', 1 => 'Giảng viên', 2 => 'Quản trị viên'];
                                    echo $roles[$u['role']] ?? 'Không xác định';
                                    ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($u['created_at'] ?? 'now')) ?></td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/admin/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                                    <a href="<?= BASE_URL ?>/admin/users/delete/<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa người dùng này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>