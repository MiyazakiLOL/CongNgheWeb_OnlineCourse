<h2>Chỉnh sửa khóa học</h2>

<form method="POST">
    <label>Tiêu đề:</label><br>
    <input type="text" name="title" value="<?= $course['title'] ?>" required><br><br>

    <label>Mô tả:</label><br>
    <textarea name="description"><?= $course['description'] ?></textarea><br><br>

    <label>Danh mục (category_id):</label><br>
    <input type="number" name="category_id" value="<?= $course['category_id'] ?>"><br><br>

    <button type="submit">Cập nhật</button>
</form>

<a href="<?= $base_url ?>/course/myCourses">Quay lại</a>
