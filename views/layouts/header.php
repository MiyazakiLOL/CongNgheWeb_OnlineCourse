<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'OnlineCourse' ?></title>
    <base href="<?= defined('BASE_URL') ? BASE_URL . '/' : '/onlinecourse/' ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        /* Nội dung chính sẽ tự động giãn ra để đẩy footer xuống */
        .container, section {
            flex-shrink: 0; 
        }
        /* Footer sẽ tự động đẩy xuống dưới cùng */
        footer {
            margin-top: auto;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4" href="">OnlineCourse</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): 
                    $role = $_SESSION['user']['role'] ?? 0;
                    $name = $_SESSION['user']['fullname'] ?? $_SESSION['user']['username'];
                    // Xử lý avatar: nếu không có thì dùng ảnh mặc định online để tránh lỗi 404
                    $avatar = !empty($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random';
                ?>
                    <?php if ($role == 0 || $role == 1): ?>
                        <li class="nav-item">
                            <a href="<?= $role == 0 ? 'student/dashboard' : 'instructor/dashboard' ?>" class="nav-link">
                                Khóa học của tôi
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $avatar ?>" class="rounded-circle" width="38" height="38" alt="Avatar" style="object-fit: cover;">
                            <span class="d-none d-md-inline fw-medium"><?= htmlspecialchars($name) ?></span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow animate slideIn" aria-labelledby="userDropdown">
                            <li><div class="dropdown-header">Xin chào, <?= htmlspecialchars($name) ?></div></li>
                            
                            <li><a class="dropdown-item" href="student/profile">
                                <i class="bi bi-person me-2"></i> Hồ sơ cá nhân
                            </a></li>

                            <?php if ($role == 1): ?>
                            <li><a class="dropdown-item" href="instructor/dashboard">
                                <i class="bi bi-easel me-2"></i> Dashboard giảng viên
                            </a></li>
                            <?php endif; ?>

                            <?php if ($role == 2): ?>
                            <li><a class="dropdown-item" href="admin/dashboard">
                                <i class="bi bi-shield-lock me-2"></i> Quản trị hệ thống
                            </a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="auth/logout" onclick="confirmLogout(event)">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a href="auth/login" class="btn btn-outline-primary">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a href="auth/register" class="btn btn-primary">Đăng ký</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<script>
function confirmLogout(event) {
    event.preventDefault(); // Ngăn chặn chuyển trang ngay lập tức
    
    // Kiểm tra xem Bootstrap đã được load chưa
    if (typeof bootstrap === 'undefined') {
        // Nếu chưa có bootstrap (ví dụ footer chưa load), fallback về confirm thường
        if(confirm('Bạn có chắc chắn muốn đăng xuất?')) {
            window.location.href = 'auth/logout';
        }
        return;
    }

    const modalHtml = `
    <div class="modal fade" id="logoutModal" tabindex="-1" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger fw-bold">Xác nhận đăng xuất</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-box-arrow-right text-danger display-4 mb-3 d-block"></i>
                    <p class="fs-5">Bạn có chắc chắn muốn đăng xuất khỏi hệ thống?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Không</button>
                    <a href="auth/logout" class="btn btn-danger px-4">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>`;

    // Xóa modal cũ nếu có
    const existingModal = document.getElementById('logoutModal');
    if (existingModal) {
        existingModal.remove();
    }

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
    modal.show();
}
</script>