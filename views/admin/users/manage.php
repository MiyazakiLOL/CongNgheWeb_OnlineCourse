<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Quản lý Người dùng</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['role'] ?></td>
        <td><?= $user['active'] ? 'Active' : 'Inactive' ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <select name="role" onchange="this.form.submit()">
                    <option value="0" <?= $user['role']==0?'selected':'' ?>>Học viên</option>
                    <option value="1" <?= $user['role']==1?'selected':'' ?>>Giảng viên</option>
                    <option value="2" <?= $user['role']==2?'selected':'' ?>>Admin</option>

                </select>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>