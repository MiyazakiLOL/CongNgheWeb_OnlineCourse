<?php $title = "Đăng nhập"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Chào mừng trở lại!</h2>

                    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
                        <!-- POPUP ĐĂNG KÝ THÀNH CÔNG -->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Chúc mừng!</strong> Bạn đã đăng ký thành công!
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="auth/login">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Đăng nhập</button>
                    </form>

                    <p class="text-center mt-4">
                        Chưa có tài khoản? <a href="auth/register" class="text-primary">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TỰ ĐỘNG TẮT POPUP SAU 4 GIÂY -->
<?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
<script>
    setTimeout(() => {
        const alertBox = document.querySelector('.alert');
        if (alertBox) {
            alertBox.classList.add('fade'); // hiệu ứng mờ
            setTimeout(() => alertBox.remove(), 500); // xóa hẳn khỏi DOM
        }
    }, 4000);
</script>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>