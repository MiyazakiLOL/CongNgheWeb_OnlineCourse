<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Tạo Danh mục Mới</h1>
<form method="POST">
    <label>Name: <input type="text" name="name"></label>
    <label>Description: <textarea name="description"></textarea></label>
    <button type="submit" name="create">Tạo</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>