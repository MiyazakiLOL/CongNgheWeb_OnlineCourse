<?php 
include __DIR__ . '/../../layouts/header.php'; 
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh sách Danh mục</h1>
        
        <div>
            <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            
            <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Tạo mới
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><strong><?= htmlspecialchars($category['name']) ?></strong></td>
                            <td><?= htmlspecialchars($category['description']) ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/admin/categories/edit/<?= $category['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                
                                <a href="<?= BASE_URL ?>/admin/categories/delete/<?= $category['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                   <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-3">Chưa có danh mục nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>