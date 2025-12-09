<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khóa học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <div class="main-container">
        <div class="header-section">
            <h2>Khóa học nổi bật</h2>
            <p class="sub-title">Những khóa học có số lượng học viên theo dõi nhiều nhất</p>
        </div>

        <div class="search-section">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="controller" value="course">
                <input type="hidden" name="action" value="index">
                <input type="text" name="keyword" placeholder="Tìm kiếm khóa học..." value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <div class="course-list">
            <?php if (!empty($courses)): ?>
                <?php foreach($courses as $c): ?>
                    <div class="course-item">
                        <a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>" class="course-link">
                            
                            <div class="course-thumb">
                                <img src="assets/uploads/courses/<?php echo !empty($c['image']) ? $c['image'] : 'default-course.png'; ?>" alt="<?php echo htmlspecialchars($c['title']); ?>">
                                <div class="overlay">
                                    <button class="btn-view">Xem khóa học</button>
                                </div>
                            </div>

                            <div class="course-info">
                                <h3 class="course-title"><?php echo htmlspecialchars($c['title']); ?></h3>
                                
                                <div class="course-price">
                                    <?php if($c['price'] == 0): ?>
                                        <span class="free">Miễn phí</span>
                                    <?php else: ?>
                                        <span class="paid"><?php echo number_format($c['price']); ?>đ</span>
                                    <?php endif; ?>
                                </div>

                                <div class="course-meta">
                                    <span title="Số học viên">
                                        <i class="fa-solid fa-users"></i> 
                                        12.5k </span>
                                    <span title="Số bài học">
                                        <i class="fa-solid fa-play-circle"></i> 
                                        <?php echo rand(10, 50); ?> </span>
                                    <span title="Thời lượng">
                                        <i class="fa-regular fa-clock"></i> 
                                        <?php echo $c['duration_weeks'] * 2; ?>h </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không tìm thấy khóa học nào phù hợp.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>