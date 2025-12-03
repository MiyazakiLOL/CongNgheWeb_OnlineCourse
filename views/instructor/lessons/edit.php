<?php
// views/instructor/lessons/edit.php
// Biến sẵn có: $lesson, $course
?>
<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Chỉnh sửa bài học: <?php echo htmlspecialchars($lesson['title']); ?></h2>

<form method="post" action="/onlinecourse/index.php?route=lesson/update">
  <input type="hidden" name="id" value="<?php echo (int)$lesson['id']; ?>">
  <div class="form-group">
    <label>Tiêu đề *</label>
    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($lesson['title']); ?>" required>
  </div>
  <div class="form-group">
    <label>Nội dung</label>
    <textarea name="content" rows="6" class="form-control"><?php echo htmlspecialchars($lesson['content']); ?></textarea>
  </div>
  <div class="form-group">
    <label>Video URL</label>
    <input type="text" name="video_url" class="form-control" value="<?php echo htmlspecialchars($lesson['video_url']); ?>">
  </div>
  <div class="form-group">
    <label>Thứ tự</label>
    <input type="number" name="order" class="form-control" value="<?php echo (int)$lesson['order']; ?>" min="1">
  </div>
  <button class="btn btn-success" type="submit">Cập nhật</button>
  <a class="btn btn-secondary" href="/onlinecourse/index.php?route=lesson/manage&course_id=<?php echo (int)$course['id']; ?>">Hủy</a>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>