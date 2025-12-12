<?php 
// Giả định rằng biến $BASE_URL đã được định nghĩa và có sẵn ở đây
// Ví dụ: $BASE_URL = 'http://localhost/ten_du_an/';
// Nếu không, bạn phải include file chứa định nghĩa $BASE_URL

if (!defined('BASE_URL')) {
    // Nếu bạn đang chạy trên localhost/onlinecourse/
    define('BASE_URL', '/onlinecourse/'); 
}

?>
<?php $title = "Đăng nhập"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Chào mừng trở lại!</h2>

                    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Chúc mừng!</strong> Bạn đã đăng ký thành công!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= htmlspecialchars($BASE_URL ?? '') ?>auth/login">
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
                        Chưa có tài khoản? 
                        <a href="<?= htmlspecialchars($BASE_URL ?? '') ?>auth/register" class="text-primary">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
<script>
    // Sử dụng Bootstrap native JS để đóng alert an toàn hơn
    setTimeout(() => {
        const alertBox = document.querySelector('.alert-dismissible');
        if (alertBox) {
            // Khởi tạo đối tượng Alert của Bootstrap
            const bsAlert = new bootstrap.Alert(alertBox);
            bsAlert.close();

            // Nếu không dùng Bootstrap JS, dùng đoạn code cũ:
            // alertBox.classList.add('fade');
            // setTimeout(() => alertBox.remove(), 500); 
        }
    }, 4000);
</script>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>