<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Danh sách Danh mục</h1>
<a href="/admin/categories/create">Tạo mới</a>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($categories as $category): ?>
    <tr>
        <td><?= $category['id'] ?></td>
        <td><?= $category['name'] ?></td>
        <td><?= $category['description'] ?></td>
        <td>
            <a href="/admin/categories/edit/<?= $category['id'] ?>">Sửa</a>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                <button type="submit" name="delete">Xóa</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
PHP// views/admin/categories/create.php
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Tạo Danh mục Mới</h1>
<form method="POST">
    <label>Name: <input type="text" name="name"></label>
    <label>Description: <textarea name="description"></textarea></label>
    <button type="submit" name="create">Tạo</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
PHP// views/admin/categories/edit.php
<?php include __DIR__ . '/../layouts/header.php'; ?>
<!-- Giả sử load category data -->
<h1>Sửa Danh mục</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?= $category['id'] ?>">
    <label>Name: <input type="text" name="name" value="<?= $category['name'] ?>"></label>
    <label>Description: <textarea name="description"><?= $category['description'] ?></textarea></label>
    <button type="submit" name="update">Cập nhật</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>