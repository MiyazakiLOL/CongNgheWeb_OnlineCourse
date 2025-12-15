<?php 
$title = "Danh sách khóa học"; 
include __DIR__ . '/../layouts/header.php'; 
?>

<div class="main-container">
    <div class="header-section text-center mb-5">
        <h2 class="fw-bold">Tất cả khóa học</h2>
        <p class="text-secondary">Khám phá và nâng cao kỹ năng của bạn ngay hôm nay</p>
    </div>

    <div class="search-section mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="<?= BASE_URL ?>/index.php" method="GET" class="search-form position-relative">
                    <input type="hidden" name="controller" value="course">
                    <input type="hidden" name="action" value="index">
                    
                    <input type="text" 
                           name="keyword" 
                           class="form-control form-control-lg rounded-pill ps-4 pe-5 border-2" 
                           placeholder="Tìm kiếm khóa học (Ví dụ: PHP, React...)" 
                           value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                    
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 rounded-pill text-primary">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="course-list">
        <?php if (!empty($courses)): ?>
            <?php foreach($courses as $c): ?>
                <div class="course-item">
                    <a href="<?= BASE_URL ?>/course/detail/<?php echo $c['id']; ?>" class="course-link-wrapper text-decoration-none text-dark d-block h-100">
                        
                        <div class="card h-100 border-0 shadow-sm course-card-hover" style="border-radius: 16px; overflow: hidden;">
                            
                            <div class="course-thumb position-relative" style="padding-top: 56.25%;">
                                <img src="<?= BASE_URL ?>/assets/uploads/courses/<?php echo !empty($c['image']) ? $c['image'] : 'default-course.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($c['title']); ?>"
                                     class="position-absolute top-0 start-0 w-100 h-100"
                                     style="object-fit: cover;">
                                
                                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                     style="background: rgba(0,0,0,0.4); opacity: 0; transition: 0.3s;">
                                    <span class="btn btn-light rounded-pill fw-bold px-4">Xem chi tiết</span>
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="course-title fw-bold mb-2 text-truncate-2" title="<?php echo htmlspecialchars($c['title']); ?>">
                                    <?php echo htmlspecialchars($c['title']); ?>
                                </h5>

                                <p class="text-muted small mb-2">
                                    <i class="fa-solid fa-chalkboard-user me-1"></i>
                                    <?php echo htmlspecialchars($c['instructor_name'] ?? 'Giảng viên'); ?>
                                </p>
                                
                                <div class="course-price mb-3">
                                    <?php if($c['price'] == 0): ?>
                                        <span class="text-primary fw-bold fs-5">Miễn phí</span>
                                    <?php else: ?>
                                        <span class="fw-bold fs-5"><?php echo number_format($c['price']); ?>đ</span>
                                    <?php endif; ?>
                                </div>

                                <div class="course-meta mt-auto d-flex justify-content-between text-secondary small pt-3 border-top">
                                    <span title="Số học viên">
                                        <i class="fa-solid fa-users me-1"></i> 1.2k
                                    </span>
                                    <span title="Số bài học">
                                        <i class="fa-solid fa-play-circle me-1"></i> <?php echo rand(10, 50); ?>
                                    </span>
                                    <span title="Thời lượng">
                                        <i class="fa-regular fa-clock me-1"></i> <?php echo $c['duration_weeks']; ?> tuần
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <img src="<?= BASE_URL ?>/assets/img/empty-search.svg" alt="No result" style="width: 150px; opacity: 0.5;">
                <p class="mt-3 text-muted">Không tìm thấy khóa học nào phù hợp với từ khóa "<strong><?= htmlspecialchars($keyword) ?></strong>".</p>
                <a href="<?= BASE_URL ?>/course/index" class="btn btn-outline-primary mt-2">Xem tất cả khóa học</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>