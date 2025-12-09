<!DOCTYPE html>
<html>
<head>
    <title>Khóa học của tôi</title>
</head>
<body>

<h2>Danh sách khóa học của tôi</h2>

<a href="<?= $base_url ?>/course/create">+ Tạo khóa học mới</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Tên khóa học</th>
        <th>Mô tả</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($courses as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['title'] ?></td>
            <td><?= $c['description'] ?></td>
            <td>
                <a href="<?= $base_url ?>/course/edit/<?= $c['id'] ?>">Sửa</a> |
                <a href="<?= $base_url ?>/course/delete/<?= $c['id'] ?>" onclick="return confirm('Xóa khóa học?')">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
