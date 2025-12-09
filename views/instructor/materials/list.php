<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="materials-management">
    <h2>Quản lý tài liệu - <?= htmlspecialchars($course['title'] ?? '') ?></h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="/material/upload/<?= htmlspecialchars($course['id']) ?>" class="btn btn-primary mb-3">+ Tải lên tài liệu</a>

    <?php if (empty($materials)): ?>
        <p class="text-muted">Chưa có tài liệu nào. <a href="/material/upload/<?= htmlspecialchars($course['id']) ?>">Tải lên tài liệu đầu tiên</a></p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Tệp</th>
                    <th>Kích thước</th>
                    <th>Ngày upload</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materials as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['id']) ?></td>
                        <td><?= htmlspecialchars($m['title']) ?></td>
                        <td><?= htmlspecialchars($m['filename']) ?></td>
                        <td>
                            <?php
                            $file_path = __DIR__ . '/../../' . $m['file_path'];
                            if (file_exists($file_path)) {
                                echo formatFileSize(filesize($file_path));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($m['uploaded_at'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/material/download/<?= $m['id'] ?>" class="btn btn-sm btn-info">Tải</a>
                            <a href="/material/delete/<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa tài liệu?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="/course/myCourses" class="btn btn-secondary mt-3">Quay lại</a>
</div>

<?php
function formatFileSize($bytes)
{
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>

<style>
.materials-management { padding: 20px; }

.alert { padding: 15px; border-radius: 4px; margin-bottom: 15px; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; display: inline-block; cursor: pointer; border: none; font-size: 14px; font-weight: bold; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
.btn-secondary { background-color: #6c757d; color: white; }
.btn-secondary:hover { background-color: #5a6268; }
.btn-info { background-color: #17a2b8; color: white; }
.btn-info:hover { background-color: #138496; }
.btn-danger { background-color: #dc3545; color: white; }
.btn-danger:hover { background-color: #c82333; }
.btn-sm { padding: 5px 10px; font-size: 12px; }
.mb-3 { margin-bottom: 15px; }
.mt-3 { margin-top: 15px; }
.text-muted { color: #6c757d; }

.table { width: 100%; border-collapse: collapse; margin-top: 15px; }
.table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
.table-striped tbody tr:nth-child(odd) { background-color: #f9f9f9; }
</style>
