<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= BASE_URL ?>/instructor/dashboard" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <h2 class="mb-0">
                    <i class="bi bi-journal-text"></i> Quản lý Bài học
                </h2>
            </div>
            <p class="text-muted mt-2 ms-5">
                Khóa học: <span class="fw-bold text-primary"><?= htmlspecialchars($course['title']) ?></span>
            </p>
        </div>
        
        <a href="<?= BASE_URL ?>/lesson/create/<?= $course['id'] ?>" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg"></i> Thêm bài học mới
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Thứ tự</th>
                            <th>Tên bài học</th>
                            <th>Video / Nội dung</th>
                            <th class="text-end pe-4" style="min-width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lessons)): ?>
                            <?php foreach ($lessons as $lesson): ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-secondary rounded-pill">Bài <?= $lesson['id'] ?></span>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($lesson['title']) ?></div>
                                    </td>
                                    <td>
                                        <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                            <i class="bi bi-link-45deg"></i> <?= htmlspecialchars($lesson['video_url'] ?? 'Không có video') ?>
                                        </small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="<?= BASE_URL ?>/lesson/edit/<?= $lesson['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Sửa bài học">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a href="<?= BASE_URL ?>/lesson/delete/<?= $lesson['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa bài học này không?');"
                                           title="Xóa bài học">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-film fs-1 d-block mb-3 opacity-50"></i>
                                        Khóa học này chưa có bài học nào.<br>
                                        Hãy bấm nút "Thêm bài học mới" để bắt đầu biên soạn.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>