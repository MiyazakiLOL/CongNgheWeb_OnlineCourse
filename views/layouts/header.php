<!-- views/layouts/header.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'OnlineCourse - Học mọi lúc mọi nơi' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <base href="/onlinecourse/">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-udemy sticky-top">
        <div class="container">
            <a class="navbar-brand logo" href="/onlinecourse/">OnlineCourse</a>

            <div class="d-none d-lg-block mx-4 flex-grow-1">
                <div class="search-box d-flex">
                    <input type="text" class="form-control" placeholder="Tìm kiếm khóa học...">
                    <button><i class="bi bi-search"></i></button>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/courses" class="text-dark text-decoration-none">Khóa học của tôi</a>
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                            <img src="<?= $_SESSION['user']['avatar'] ?? '/assets/uploads/avatars/default.png' ?>" 
                                 width="40" height="40" class="rounded-circle me-2" alt="Avatar">
                            <span class="d-none d-md-block"><?= $_SESSION['user']['fullname'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/student/profile">Hồ sơ</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/auth/logout">Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/onlinecourse/auth/login" class="btn btn-outline-dark">Đăng nhập</a>
                    <a href="/onlinecourse/auth/register" class="btn btn-dark">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>