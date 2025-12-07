<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Chỉnh sửa khóa học</h2>

<form method="post" action="/onlinecourse/index.php?route=course/update" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo (int)$course['id']; ?>">

  <div class="form-group">
    <label>Tiêu đề *</label>
    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($course['title']); ?>" required>
  </div>

  <div class="form-group">
    <label>Mô tả</label>
    <textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($course['description']); ?></textarea>
  </div>

  <div class="form-group">
    <label>Danh mục</label>
    <select name="category_id" class="form-control">
      <?php foreach ($categories as $cat): ?>
        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $course['category_id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($cat['name']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label>Giá (VNĐ)</label>
    <input type="number" name="price" class="form-control" step="0.01" value="<?php echo $course['price']; ?>">
  </div>

  <div class="form-group">
    <label>Thời lượng (tuần)</label>
    <input type="number" name="duration_weeks" class="form-control" min="1" value="<?php echo $course['duration_weeks']; ?>">
  </div>

  <div class="form-group">
    <label>Cấp độ</label>
    <select name="level" class="form-control">
      <option value="Beginner" <?php if ($course['level']=='Beginner') echo 'selected'; ?>>Beginner</option>
      <option value="Intermediate" <?php if ($course['level']=='Intermediate') echo 'selected'; ?>>Intermediate</option>
      <option value="Advanced" <?php if ($course['level']=='Advanced') echo 'selected'; ?>>Advanced</option>
    </select>
  </div>

  <div class="form-group">
    <label>Ảnh minh họa</label>
    <?php if (!empty($course['image'])): ?>
      <p><img src="/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>" width="150"></p>
    <?php endif; ?>
    <input type="file" name="image" class="form-control">
  </div>

  <button type="submit" class="btn btn-success">Cập nhật khóa học</button>
  <a href="/onlinecourse/index.php?route=course/myCourses" class="btn btn-secondary">Hủy</a>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>