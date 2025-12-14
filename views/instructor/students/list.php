<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-people-fill"></i> Quản lý Học viên</h2>
            <p class="text-muted">Danh sách các học viên đang tham gia khóa học của bạn.</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/instructor/dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại Dashboard
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Học viên</th>
                            <th>Khóa học tham gia</th>
                            <th>Ngày đăng ký</th>
                            <th>Tiến độ</th>
                            <th>Trạng thái</th>
                            <th class="text-end pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $stu): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($stu['fullname']) ?>&background=random" 
                                                 class="rounded-circle me-3" 
                                                 width="40" height="40" alt="Avatar">
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($stu['fullname']) ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($stu['email']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?= htmlspecialchars($stu['course_title']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($stu['enrolled_date'])) ?></td>
                                    <td style="width: 15%;">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-primary fw-bold"><?= $stu['progress'] ?>%</span>
                                            <div class="progress flex-grow-1" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: <?= $stu['progress'] ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($stu['status'] == 'active'): ?>
                                            <span class="badge bg-success-subtle text-success">Đang học</span>
                                        <?php elseif ($stu['status'] == 'completed'): ?>
                                            <span class="badge bg-primary-subtle text-primary">Hoàn thành</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Đã hủy</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="mailto:<?= htmlspecialchars($stu['email']) ?>" class="btn btn-sm btn-outline-primary" title="Gửi email">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="80" class="mb-3 opacity-50">
                                    <p class="text-muted">Chưa có học viên nào đăng ký khóa học của bạn.</p>
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