<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Đăng ký</h1>
<form method="POST" action="/auth/register">
    <label>Username: <input type="text" name="username"></label>
    <label>Họ tên: <input type="text" name="fullname" required></label>
    <label>Email: <input type="email" name="email"></label>
    <label>Password: <input type="password" name="password"></label>
    <label>Role: 
        <select name="role">
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
        </select>
    </label>
    <button type="submit">Đăng ký</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>