<?php $title = "Tạo Danh mục Mới"; ?>

<div class="container py-5">
    <h2 class="mb-4">Tạo Danh mục Mới</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tạo danh mục</button>
        <a href="./views/admin/dashboard.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>