<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="custom-body-bg">
    <div class="lesson-form-container">
        <h2 style="text-align: center; margin-bottom: 25px; color: #333;">Chỉnh sửa bài học</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($lesson)): ?>
            <form method="POST" action="<?= BASE_URL ?>/lesson/update/<?= $lesson['id'] ?>" class="lesson-form">
                
                <div class="form-group">
                    <label for="title">Tiêu đề bài học (*):</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($lesson['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="order">Thứ tự hiển thị:</label>
                    <input type="number" id="order" name="order" value="<?= htmlspecialchars($lesson['order'] ?? 0) ?>" min="0">
                </div>

                <div class="form-group">
                    <label for="video_url">Video URL (tuỳ chọn):</label>
                    <input type="url" id="video_url" name="video_url" value="<?= htmlspecialchars($lesson['video_url'] ?? '') ?>" placeholder="https://youtube.com/...">
                </div>

                <div class="form-group">
                    <label for="content">Nội dung / Mô tả:</label>
                    <textarea id="content" name="content" rows="6" required><?= htmlspecialchars($lesson['content'] ?? '') ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="<?= BASE_URL ?>/lesson/manage/<?= $lesson['course_id'] ?>" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        <?php else: ?>
            <div style="text-align: center; color: red;">Không tìm thấy bài học!</div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh căn giữa (Không dùng Bootstrap Grid) */
    .custom-body-bg {
        padding: 50px 0;
        background-color: #f0f2f5; /* Màu nền nhẹ */
        min-height: 80vh; 
        display: flex;
        justify-content: center; /* Căn giữa ngang */
        align-items: flex-start; /* Căn trên cùng */
    }

    .lesson-form-container { 
        width: 100%;
        max-width: 700px; /* Độ rộng tối đa của form */
        margin: 0 20px;   /* Margin 2 bên cho mobile */
        background: #fff;
        padding: 30px; 
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Đổ bóng */
    }

    .form-group { margin-bottom: 20px; }
    
    .form-group label { 
        display: block; 
        margin-bottom: 8px; 
        font-weight: bold; 
        color: #444; 
    }

    .form-group input[type="text"],
    .form-group input[type="url"],
    .form-group input[type="number"],
    .form-group textarea { 
        width: 100%; 
        padding: 12px; 
        border: 1px solid #ddd; 
        border-radius: 6px; 
        box-sizing: border-box; 
        font-family: Arial, sans-serif;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #0d6efd; /* Màu xanh khi focus */
        outline: none;
    }

    .form-group textarea { resize: vertical; }

    .form-actions { 
        display: flex; 
        gap: 15px; 
        margin-top: 30px; 
        justify-content: flex-end; /* Căn nút sang phải */
    }

    .btn { 
        padding: 12px 25px; 
        border: none; 
        border-radius: 6px; 
        cursor: pointer; 
        text-decoration: none; 
        display: inline-block; 
        font-size: 15px; 
        font-weight: bold; 
        transition: background-color 0.2s;
    }

    .btn-primary { background-color: #0d6efd; color: white; }
    .btn-primary:hover { background-color: #0b5ed7; }

    .btn-secondary { background-color: #6c757d; color: white; }
    .btn-secondary:hover { background-color: #5c636a; }
</style>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>