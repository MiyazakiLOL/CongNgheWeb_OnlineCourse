<?php
// Kiểm tra session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="container my-courses">
    <h2>Khóa học của tôi</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="/course/create" class="btn btn-primary mb-3">+ Tạo khóa học mới</a>

    <?php if (empty($courses)): ?>
        <p class="text-muted">Bạn chưa tạo khóa học nào. <a href="/course/create">Tạo khóa học đầu tiên</a></p>
    <?php else: ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['id']) ?></td>
                        <td><?= htmlspecialchars($course['title']) ?></td>
                        <td><?= htmlspecialchars(substr($course['description'], 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($course['category_id'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/course/edit/<?= $course['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="/course/lessons/<?= $course['id'] ?>" class="btn btn-sm btn-info">Quản lý bài học</a>
                            <a href="/course/materials/<?= $course['id'] ?>" class="btn btn-sm btn-secondary">Tài liệu</a>
                            <a href="/course/delete/<?= $course['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa khóa học này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.my-courses {
    padding: 20px;
}
.alert {
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 15px;
}
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.btn {
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    border: none;
    font-size: 14px;
}
.btn-primary {
    background-color: #007bff;
    color: white;
}
.btn-primary:hover {
    background-color: #0056b3;
}
.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
}
.btn-warning {
    background-color: #ffc107;
    color: black;
}
.btn-warning:hover {
    background-color: #e0a800;
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}
.btn-danger:hover {
    background-color: #c82333;
}
.btn-info {
    background-color: #17a2b8;
    color: white;
}
.btn-info:hover {
    background-color: #138496;
}
.btn-secondary {
    background-color: #6c757d;
    color: white;
}
.btn-secondary:hover {
    background-color: #5a6268;
}
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.table-dark {
    background-color: #343a40;
    color: white;
}
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
.mb-3 {
    margin-bottom: 15px;
}
.text-muted {
    color: #6c757d;
}
</style>
