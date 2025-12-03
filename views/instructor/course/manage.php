<h2>Danh sách khóa học của tôi</h2>
<a href="/onlinecourse/index.php?route=course/create" class="btn btn-primary">+ Tạo khóa học</a>
<table class="table">
  <thead><tr><th>Tiêu đề</th><th>Giá</th><th>Thời lượng</th><th>Hành động</th></tr></thead>
  <tbody>
    <?php foreach ($courses as $c): ?>
      <tr>
        <td><?php echo htmlspecialchars($c['title']); ?></td>
        <td><?php echo number_format($c['price']); ?> VNĐ</td>
        <td><?php echo (int)$c['duration_weeks']; ?> tuần</td>
        <td>
          <a href="/onlinecourse/index.php?route=course/edit&id=<?php echo $c['id']; ?>" class="btn btn-warning">Sửa</a>
          <a href="/onlinecourse/index.php?route=course/delete&id=<?php echo $c['id']; ?>" class="btn btn-danger" onclick="return confirm('Xóa khóa học?');">Xóa</a>
          <a href="/onlinecourse/index.php?route=lesson/manage&course_id=<?php echo $c['id']; ?>" class="btn btn-info">Quản lý bài học</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>