<div class="lesson-management">
    <h2>Danh sách bài học</h2>

    <a href="/course/createLesson/<?= htmlspecialchars($course['id']) ?>" class="btn btn-primary mb-3">+ Thêm bài học</a>

    <?php if (empty($lessons)): ?>
        <p class="text-muted">Chưa có bài học nào. <a href="/course/createLesson/<?= htmlspecialchars($course['id']) ?>">Tạo bài học đầu tiên</a></p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Video URL</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $l): ?>
                    <tr>
                        <td><?= htmlspecialchars($l['id']) ?></td>
                        <td><?= htmlspecialchars($l['title']) ?></td>
                        <td><?= htmlspecialchars(substr($l['content'] ?? '', 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($l['video_url'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/course/editLesson/<?= $l['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="/course/deleteLesson/<?= $l['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bài học?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.lesson-management { padding: 20px; }
.btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; display: inline-block; cursor: pointer; border: none; font-size: 14px; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
.btn-warning { background-color: #ffc107; color: black; }
.btn-warning:hover { background-color: #e0a800; }
.btn-danger { background-color: #dc3545; color: white; }
.btn-danger:hover { background-color: #c82333; }
.btn-sm { padding: 5px 10px; font-size: 12px; }
.mb-3 { margin-bottom: 15px; }
.text-muted { color: #6c757d; }
.table { width: 100%; border-collapse: collapse; margin-top: 15px; }
.table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
.table-striped tbody tr:nth-child(odd) { background-color: #f9f9f9; }
</style>
