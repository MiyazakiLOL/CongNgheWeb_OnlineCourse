<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'OnlineCourse' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="<?= BASE_URL ?>/home/index">OnlineCourse</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/course/index">Tất cả khóa học</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): 
                    // Lưu ý: Mình dùng $_SESSION['user_id'] và $_SESSION['role'] cho đồng bộ với code Controller trước đó
                    // Nếu bạn lưu cả object user vào session thì sửa lại nhé.
                    $role = $_SESSION['role'] ?? 0;
                    $fullname = $_SESSION['fullname'] ?? 'User';
                    $avatar = $_SESSION['avatar'] ?? 'default.png'; 
                ?>
                    
                    <?php if ($role == 0 || $role == 1): ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>/student/my_courses" class="nav-link">
                                Khóa học của tôi
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= BASE_URL ?>/assets/uploads/avatars/<?= htmlspecialchars($avatar) ?>" 
                                 class="rounded-circle" width="38" height="38" style="object-fit: cover;" alt="Avatar">
                            <span class="d-none d-md-inline fw-medium"><?= htmlspecialchars($fullname) ?></span>
                            <img src="<?= $_SESSION['user']['avatar'] ?? 'assets/avatars/default.png' ?>" 
                                 class="rounded-circle" width="38" height="38" alt="Avatar">
                            <span class="d-none d-md-inline"><?= htmlspecialchars($name) ?></span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <div class="px-3 py-2">
                                    <span class="d-block small text-muted">Xin chào,</span>
                                    <span class="fw-bold"><?= htmlspecialchars($fullname) ?></span>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/student/profile">
                                <i class="bi bi-person me-2"></i> Hồ sơ cá nhân
                            </a></li>

                            <?php if ($role == 1): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/instructor/dashboard">
                                    <i class="bi bi-easel me-2"></i> Dashboard Giảng viên
                                </a></li>
                            <?php endif; ?>

                            <?php if ($role == 2): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/dashboard">
                                    <i class="bi bi-shield-lock me-2"></i> Quản trị hệ thống
                                </a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout">
                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmLogout(event)">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline-primary fw-medium px-4">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/auth/register" class="btn btn-primary fw-medium px-4">Đăng ký</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container py-4" style="min-height: 80vh;">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Xác nhận đăng xuất với SweetAlert2 style (dùng Bootstrap modal cho đẹp)
function confirmLogout(event) {
    event.preventDefault();

    const modalHtml = `
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">Xác nhận đăng xuất</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <p class="mt-3">Bạn có chắc chắn muốn đăng xuất không?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy</button>
                    <a href="auth/logout" class="btn btn-danger px-4">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>`;

    document.getElementById('logoutModal')?.remove();
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
    modal.show();
}
</script>
</body>
</html>
