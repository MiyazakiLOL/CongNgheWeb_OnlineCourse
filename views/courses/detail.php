<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($course['title']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="margin-top: 20px;">
        <a href="index.php?controller=course&action=index">← Quay lại danh sách</a>
        
        <div style="display: flex; gap: 30px; margin-top: 20px;">
            <div style="flex: 2;">
                <h1><?php echo htmlspecialchars($course['title']); ?></h1>
                <p class="meta">
                    Giảng viên: <strong><?php echo htmlspecialchars($course['instructor_name']); ?></strong> | 
                    Danh mục: <?php echo htmlspecialchars($course['category_name']); ?>
                </p>
                <hr>
                <h3>Mô tả khóa học</h3>
                <div class="description">
                    <?php echo nl2br(htmlspecialchars($course['description'])); ?>
                </div>
                
                <h3>Nội dung bài học</h3>
                <p><em>(Danh sách bài học sẽ được cập nhật...)</em></p>
            </div>

            <div style="flex: 1; border: 1px solid #ddd; padding: 20px; height: fit-content; border-radius: 8px;">
                <img src="assets/uploads/courses/<?php echo $course['image'] ? $course['image'] : 'default.jpg'; ?>" style="width:100%; margin-bottom: 15px;">
                
                <h2 style="color: #d9534f;"><?php echo number_format($course['price']); ?> VNĐ</h2>
                <p>Cấp độ: <?php echo $course['level']; ?></p>
                <p>Thời lượng: <?php echo $course['duration_weeks']; ?> tuần</p>

                <?php if($isEnrolled): ?>
                    <button disabled style="width:100%; padding: 15px; background: green; color: white; border: none;">Đã Đăng Ký</button>
                    <a href="index.php?controller=student&action=course_progress&id=<?php echo $course['id']; ?>" style="display:block; text-align:center; margin-top:10px;">Vào học ngay</a>
                <?php else: ?>
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="course">
                        <input type="hidden" name="action" value="enroll">
                        <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                        
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn đăng ký khóa học này?')" 
                                style="width:100%; padding: 15px; background: #007bff; color: white; border: none; cursor: pointer; font-size: 16px;">
                            Đăng Ký Ngay
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>