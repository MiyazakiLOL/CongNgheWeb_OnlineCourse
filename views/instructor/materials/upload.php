<?php
// Kiểm tra session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra course_id từ URL
$course_id = $_GET['course_id'] ?? null;
?>

<div class="container upload-materials">
    <h2>Đăng tải tài liệu</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="/course/uploadMaterial" enctype="multipart/form-data" class="upload-form">
        <div class="form-group">
            <label for="course_id">Khóa học:</label>
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id ?? '') ?>" required>
            <p><strong>Course ID:</strong> <?= htmlspecialchars($course_id ?? 'Chưa chỉ định') ?></p>
        </div>

        <div class="form-group">
            <label for="title">Tên tài liệu:</label>
            <input type="text" id="title" name="title" placeholder="Ví dụ: Slide bài 1, PDF tài liệu học tập" required>
        </div>

        <div class="form-group">
            <label for="file">Chọn tệp:</label>
            <input type="file" id="file" name="file" required>
            <small class="text-muted">
                Loại tệp hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, TXT, JPG, PNG, MP4, WebM
                <br>Dung lượng tối đa: 100MB
            </small>
        </div>

        <div class="form-group">
            <label for="description">Mô tả (tùy chọn):</label>
            <textarea id="description" name="description" placeholder="Mô tả ngắn về tài liệu này" rows="4"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Đăng tải</button>
            <a href="/course/myCourses" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

<style>
.upload-materials {
    padding: 20px;
    max-width: 600px;
}

.upload-form {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.form-group input[type="text"],
.form-group input[type="hidden"],
.form-group input[type="file"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.form-group input[type="file"] {
    padding: 5px;
    cursor: pointer;
}

.form-group textarea {
    resize: vertical;
}

.form-group small.text-muted {
    color: #666;
    font-size: 12px;
    display: block;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.alert {
    padding: 12px 15px;
    border-radius: 4px;
    margin-bottom: 20px;
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

p {
    margin: 0;
    padding: 8px 0;
}
</style>
