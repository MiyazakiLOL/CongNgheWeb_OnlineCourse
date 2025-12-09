<h2>Tạo khóa học mới</h2>

<form method="POST">
    <label>Tiêu đề:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Mô tả:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Danh mục (category_id):</label><br>
    <input type="number" name="category_id"><br><br>

    <button type="submit">Tạo khóa học</button>
</form>

<a href="<?= $base_url ?>/course/myCourses">Quay lại</a>
