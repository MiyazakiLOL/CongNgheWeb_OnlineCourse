<?php 
$title = "OnlineCourse - Học mọi lúc mọi nơi"; 
include __DIR__ . '/../layouts/header.php'; 
?>

<section class="hero-udemy text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white">Học kỹ năng mới – Mở ra cơ hội mới</h1>
                <p class="lead my-4 text-white-50">Hàng ngàn khóa học chất lượng từ giảng viên hàng đầu Việt Nam</p>
                
                <form action="<?= BASE_URL ?>/course/index" method="GET" class="d-flex gap-2 flex-wrap bg-white p-2 rounded shadow-sm">
                    <input type="hidden" name="controller" value="course">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="keyword" class="form-control border-0 form-control-lg" placeholder="Bạn muốn học gì hôm nay?">
                    <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="<?= BASE_URL ?>/assets/img/hero-illustration.svg" alt="Learning" class="img-fluid" style="max-height: 400px;">
            <div class="col-lg-6 text-center">
                <img src="assets/uploads/hero-illustration.jpg" alt="Learning" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h3 class="fw-bold mb-4">Khám phá theo danh mục</h3>
        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 col-6">
                <a href="<?= BASE_URL ?>/course/index?category_id=<?= $cat['id'] ?>" class="text-decoration-none text-dark">
                    <div class="category-btn text-center p-4 h-100 border transition-hover">
                        <i class="bi bi-code-slash fs-1 text-primary"></i>
                        <h6 class="mt-3 mb-0 fw-bold"><?= htmlspecialchars($cat['name']) ?></h6>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4">Khóa học nổi bật</h3>
        <div class="row g-4">
            <?php foreach ($featuredCourses as $course): ?>
            <div class="col-lg-3 col-md-6">
                
                <a href="<?= BASE_URL ?>/course/detail/<?= $course['id'] ?>" class="text-decoration-none text-dark d-block h-100 course-link-wrapper">
                    <div class="card course-card h-100 border-0 shadow-sm">
                        
                        <div class="position-relative">
                            <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= !empty($course['image']) ? $course['image'] : 'default-course.png' ?>" 
                                 class="card-img-top course-img" 
                                 alt="<?= htmlspecialchars($course['title']) ?>"
                                 style="height: 180px; object-fit: cover;">
                            
                            <?php if(rand(0,1)==1): ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Bán chạy</span>
                <div class="card course-card h-100">
                    <img src="<?= $course['image'] ? '/assets/uploads/courses/'.$course['image'] : '/assets/img/course-default.jpg' ?>" 
                         class="card-img-top course-img" alt="<?= $course['title'] ?>">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h6>
                        <p class="text-muted small"><?= htmlspecialchars($course['instructor_name'] ?? ($course['instructor_display_name'] ?? 'Giảng viên')) ?></p>
                        <div class="d-flex align-items-center mb-2">
                            <span class="rating me-2">4.8 ★</span>
                            <span class="text-muted small">(<?= rand(100,5000) ?>)</span>
                        </div>
                        <div class="mt-auto">
                            <?php $price = isset($course['price']) ? (float)$course['price'] : 0.0; ?>
                            <span class="price-current"><?= number_format($price) ?>đ</span>
                            <?php if($price > 200000): ?>
                                <span class="price-original ms-2"><?= number_format($price * 2) ?>đ</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate-2" title="<?= htmlspecialchars($course['title']) ?>">
                                <?= htmlspecialchars($course['title']) ?>
                            </h6>
                            
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($course['instructor_name'] ?? 'Giảng viên') ?>
                            </p>
                            
                            <div class="d-flex align-items-center mb-2">
                                <span class="fw-bold text-warning me-1">4.8</span>
                                <i class="bi bi-star-fill text-warning small"></i>
                                <i class="bi bi-star-fill text-warning small"></i>
                                <i class="bi bi-star-fill text-warning small"></i>
                                <i class="bi bi-star-fill text-warning small"></i>
                                <i class="bi bi-star-half text-warning small"></i>
                                <span class="text-muted small ms-2">(<?= rand(100,5000) ?>)</span>
                            </div>
                            
                            <div class="mt-auto d-flex align-items-center">
                                <?php if($course['price'] == 0): ?>
                                    <span class="fw-bold text-success fs-5">Miễn phí</span>
                                <?php else: ?>
                                    <span class="fw-bold fs-5"><?= number_format($course['price']) ?>đ</span>
                                    <?php if($course['price'] > 0): ?>
                                        <span class="text-muted text-decoration-line-through ms-2 small">
                                            <?= number_format($course['price'] * 1.3) ?>đ
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>