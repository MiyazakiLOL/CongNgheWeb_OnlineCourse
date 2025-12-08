<?php $title = "OnlineCourse - Học mọi lúc mọi nơi"; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero -->
<section class="hero-udemy text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-black-50">Học kỹ năng mới – Mở ra cơ hội mới</h1>
                <p class="lead my-4 text-black-50">Hàng ngàn khóa học chất lượng từ giảng viên hàng đầu Việt Nam</p>
                <form class="d-flex gap-3 flex-wrap">
                    <input type="text" class="form-control form-control-lg" placeholder="Bạn muốn học gì hôm nay?">
                    <button class="btn btn-light btn-lg px-5">Tìm kiếm</button>
                </form>
            </div>
            <div class="col-lg-6 text-center">
                <img src="assets/uploads/hero-illustration.jpg" alt="Learning" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Danh mục -->
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Khám phá theo danh mục</h2>
        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 col-6">
                <a href="/courses?cat=<?= $cat['id'] ?>" class="text-decoration-none">
                    <div class="category-btn text-center p-4 h-100">
                        <i class="bi bi-code-slash fs-1 text-primary"></i>
                        <h6 class="mt-3 mb-0"><?= htmlspecialchars($cat['name']) ?></h6>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Khóa học nổi bật -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">Khóa học nổi bật</h2>
        <div class="row g-4">
            <?php foreach ($featuredCourses as $course): ?>
            <div class="col-lg-3 col-md-6">
                <div class="card course-card h-100">
                    <img src="<?= $course['image'] ? '/assets/uploads/courses/'.$course['image'] : '/assets/img/course-default.jpg' ?>" 
                         class="card-img-top course-img" alt="<?= $course['title'] ?>">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h6>
                        <p class="text-muted small"><?= $course['instructor_name'] ?></p>
                        <div class="d-flex align-items-center mb-2">
                            <span class="rating me-2">4.8 ★</span>
                            <span class="text-muted small">(<?= rand(100,5000) ?>)</span>
                        </div>
                        <div class="mt-auto">
                            <span class="price-current"><?= number_format($course['price']) ?>đ</span>
                            <?php if($course['price'] > 200000): ?>
                                <span class="price-original ms-2"><?= number_format($course['price'] * 2) ?>đ</span>
                            <?php endif; ?>
                        </div>
                        <?php if(rand(0,2)==1): ?><span class="bestseller-badge">Bán chạy</span><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>