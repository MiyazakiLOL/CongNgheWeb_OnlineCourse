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