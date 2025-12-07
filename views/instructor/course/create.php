<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Tạo khóa học mới</h2>

<form method="post" action="/onlinecourse/index.php?route=course/store" enctype="multipart/form-data">
  <div class="form-group">
    <label>Tiêu đề *</label>
    <input type="text" name="title" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Mô tả</label>
    <textarea name="description" class="form-control" rows="5"></textarea>
  </div>

  <div class="form-group">
    <label>Danh mục</label>
    <select name="category_id" class="form-control">
      <?php foreach ($categories as $cat): ?>
        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Giá (VNĐ)</label>
    <input type="number" name="price" class="form-control" step="0.01">
  </div>

  <div class="form-group">
    <label>Thời lượng (tuần)</label>
    <input type="number" name="duration_weeks" class="form-control" min="1">
  </div>

  <div class="form-group">
    <label>Cấp độ</label>
    <select name="level" class="form-control">
      <option value="Beginner">Beginner</option>
      <option value="Intermediate">Intermediate</option>
      <option value="Advanced">Advanced</option>
    </select>
  </div>

  <div class="form-group">
    <label>Ảnh minh họa</label>
    <input type="file" name="image" class="form-control">
  </div>

  <button type="submit" class="btn btn-success">Lưu khóa học</button>
  <a href="/onlinecourse/index.php?route=course/myCourses" class="btn btn-secondary">Hủy</a>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>