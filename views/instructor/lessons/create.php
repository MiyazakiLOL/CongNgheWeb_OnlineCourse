<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="custom-body-bg">
    <div class="lesson-form-container">
        <h2 style="text-align: center; margin-bottom: 25px; color: #333;">Thêm bài học mới</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/lesson/store/<?= $course['id'] ?>" class="lesson-form">
            
            <div class="form-group">
                <label for="title">Tiêu đề bài học (*):</label>
                <input type="text" id="title" name="title" placeholder="Ví dụ: Giới thiệu HTML" required>
            </div>

            <div class="form-group">
                <label for="order">Thứ tự hiển thị:</label>
                <input type="number" id="order" name="order" value="1" min="0" placeholder="Nhập số thứ tự (1, 2, 3...)">
            </div>

            <div class="form-group">
                <label for="video_url">Video URL (Youtube/Drive...):</label>
                <input type="url" id="video_url" name="video_url" placeholder="Ví dụ: https://youtube.com/watch?v=...">
            </div>

            <div class="form-group">
                <label for="content">Nội dung / Mô tả:</label>
                <textarea id="content" name="content" placeholder="Nhập nội dung bài học..." rows="6"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Tạo bài học</button>
                <a href="<?= BASE_URL ?>/lesson/manage/<?= $course['id'] ?>" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* CSS Tùy chỉnh (Không dùng Grid Bootstrap) */
    .custom-body-bg {
        padding: 50px 0;
        background-color: #f0f2f5; /* Màu nền nhẹ cho toàn vùng */
        min-height: 80vh; /* Đảm bảo chiều cao tối thiểu */
    }

    .lesson-form-container { 
        padding: 30px; 
        max-width: 700px; 
        margin: 0 auto; /* CĂN GIỮA: margin trên/dưới = 0, trái/phải = auto */
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Đổ bóng đẹp hơn */
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
        border-color: #007bff;
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