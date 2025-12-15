<?php 
// Đảm bảo include đúng đường dẫn
include __DIR__ . '/../../layouts/header.php';
$title = "Sửa vai trò người dùng"; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Sửa vai trò: <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Vai trò hiện tại</label>
                            <select name="role" class="form-select" required>
                                <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Học viên</option>
                                <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Giảng viên</option>
                                <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Quản trị viên</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>