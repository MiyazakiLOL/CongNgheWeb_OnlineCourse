<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Sửa Danh mục</h1>
    
    <?php if (isset($category)): ?>
        <form method="POST" action="" class="mt-3">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label">Tên danh mục:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Mô tả:</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
            </div>
            
            <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
            <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-secondary">Hủy</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Không tìm thấy danh mục!</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>