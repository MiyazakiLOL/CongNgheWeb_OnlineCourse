<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-collection"></i> Khóa học của tôi</h2>
        <a href="<?= BASE_URL ?>instructor/course/create.php" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Tạo khóa học mới
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($courses)): ?>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên khóa học</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td>#<?= $c['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($c['title']) ?></strong>
                                    <br><small class="text-muted">Ngày tạo: <?= date('d/m/Y', strtotime($c['created_at'])) ?></small>
                                </td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($c['category_name'] ?? 'Khác') ?></span></td>
                                <td><?= number_format($c['price']) ?> đ</td>
                                <td><span class="badge bg-success">Đang hoạt động</span></td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>instructor/edit/<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <a href="<?= BASE_URL ?>instructor/delete/<?= $c['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 bg-light rounded">
            <p class="text-muted">Bạn chưa có khóa học nào.</p>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>