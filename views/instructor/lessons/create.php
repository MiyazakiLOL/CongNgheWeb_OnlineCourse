<div class="lesson-form-container">
    <h2>Thêm bài học mới</h2>

    <form method="POST" class="lesson-form">
        <div class="form-group">
            <label for="title">Tiêu đề bài học:</label>
            <input type="text" id="title" name="title" placeholder="Ví dụ: Giới thiệu HTML" required>
        </div>

        <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" placeholder="Nhập nội dung bài học" rows="6" required></textarea>
        </div>

        <div class="form-group">
            <label for="video_url">Video URL (tuỳ chọn):</label>
            <input type="url" id="video_url" name="video_url" placeholder="Ví dụ: https://youtube.com/watch?v=...">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Tạo bài học</button>
            <a href="/course/myCourses" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

<style>
.lesson-form-container { padding: 20px; max-width: 700px; }
.lesson-form { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
.form-group input[type="text"],
.form-group input[type="url"],
.form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: Arial, sans-serif; }
.form-group textarea { resize: vertical; }
.form-actions { display: flex; gap: 10px; margin-top: 25px; }
.btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; font-weight: bold; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
.btn-secondary { background-color: #6c757d; color: white; }
.btn-secondary:hover { background-color: #5a6268; }
</style>
