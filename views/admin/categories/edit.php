<div class="container mt-4"> <h1>Sửa Danh mục</h1>
    
    <?php if (isset($category)): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= htmlspecialchars($category['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/onlinecourse' ?>/admin/categories" class="btn btn-secondary">Hủy</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy thông tin danh mục.</p>
    <?php endif; ?>
</div>