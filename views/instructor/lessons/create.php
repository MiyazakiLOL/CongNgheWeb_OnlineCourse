<?php
// views/instructor/lessons/create.php
// Biến sẵn có: $course
?>
<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Thêm bài học cho khóa: <?php echo htmlspecialchars($course['title']); ?></h2>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<form method="post" action="/onlinecourse/index.php?route=lesson/store">
  <input type="hidden" name="course_id" value="<?php echo (int)$course['id']; ?>">
  <div class="form-group">
    <label>Tiêu đề *</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Nội dung</label>
    <textarea name="content" rows="6" class="form-control"></textarea>
  </div>
  <div class="form-group">
    <label>Video URL</label>
    <input type="text" name="video_url" class="form-control" placeholder="https://...">
  </div>
  <div class="form-group">
    <label>Thứ tự</label>
    <input type="number" name="order" class="form-control" value="1" min="1">
  </div>
  <button class="btn btn-success" type="submit">Lưu</button>
  <a class="btn btn-secondary" href="/onlinecourse/index.php?route=lesson/manage&course_id=<?php echo (int)$course['id']; ?>">Hủy</a>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>