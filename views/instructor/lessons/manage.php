<?php
// views/instructor/lessons/manage.php
// Biến sẵn có: $course, $lessons
?>
<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Quản lý bài học: <?php echo htmlspecialchars($course['title']); ?></h2>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<a class="btn btn-primary" href="/onlinecourse/index.php?route=lesson/create&course_id=<?php echo (int)$course['id']; ?>">+ Thêm bài học</a>
<a class="btn btn-info" href="/onlinecourse/index.php?route=lesson/manage&course_id=<?php echo (int)$course['id']; ?>">
  Quản lý bài học
</a>
<table class="table" style="margin-top: 16px;">
  <thead>
    <tr>
      <th>Order</th>
      <th>Tiêu đề</th>
      <th>Video URL</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lessons as $l): ?>
      <tr>
        <td><?php echo (int)$l['order']; ?></td>
        <td><?php echo htmlspecialchars($l['title']); ?></td>
        <td><?php echo htmlspecialchars($l['video_url']); ?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="/onlinecourse/index.php?route=lesson/edit&id=<?php echo (int)$l['id']; ?>">Sửa</a>
          <a class="btn btn-sm btn-danger" href="/onlinecourse/index.php?route=lesson/delete&id=<?php echo (int)$l['id']; ?>"
             onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>