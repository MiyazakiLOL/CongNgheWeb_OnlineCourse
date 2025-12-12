<?php $title = "Sửa vai trò người dùng"; ?>

<div class="container py-5">
    <h2 class="mb-4">Sửa vai trò: <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?></h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Vai trò hiện tại</label>
            <select name="role" class="form-select" required>
                <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Học viên</option>
                <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Giảng viên</option>
                <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Quản trị viên</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật vai trò</button>
        <a href="/admin/dashboard" class="btn btn-secondary">Quay lại</a>
    </form>
</div>