<?php 

$title = $course['title']; // Đặt title cho tab trình duyệt
include __DIR__ . '/../layouts/header.php'; 
?>

<div class="course-detail-container">
    <div class="container py-5">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/course/index">Khóa học</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($course['title']) ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <h1 class="course-detail-title fw-bold mb-3"><?= htmlspecialchars($course['title']) ?></h1>
                
                <p class="course-desc text-secondary mb-4">
                    <?= nl2br(htmlspecialchars($course['description'])) ?>
                </p>

                <div class="d-flex align-items-center mb-4 author-box">
                    <img src="<?= BASE_URL ?>/assets/uploads/avatars/default.png" class="rounded-circle me-3" width="50" height="50" alt="Author">
                    <div>
                        <span class="d-block small text-muted">Được giảng dạy bởi</span>
                        <strong class="text-dark"><?= htmlspecialchars($course['instructor_name']) ?></strong>
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Bạn sẽ học được gì?</h5>
                        <div class="row">
                            <div class="col-md-6"><i class="bi bi-check-circle-fill text-success me-2"></i> Hiểu rõ bản chất kiến thức</div>
                            <div class="col-md-6"><i class="bi bi-check-circle-fill text-success me-2"></i> Làm được dự án thực tế</div>
                            <div class="col-md-6"><i class="bi bi-check-circle-fill text-success me-2"></i> Tư duy lập trình hiện đại</div>
                            <div class="col-md-6"><i class="bi bi-check-circle-fill text-success me-2"></i> Kỹ năng debug và tối ưu code</div>
                        </div>
                    </div>
                </div>

                <div class="curriculum-section mb-5">
                    <h4 class="fw-bold mb-3">Nội dung khóa học</h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <strong>Phần 1: Giới thiệu tổng quan</strong>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-play-circle me-2"></i> Giới thiệu khóa học <span class="float-end small text-muted">02:30</span></li>
                                        <li class="list-group-item"><i class="bi bi-play-circle me-2"></i> Cài đặt môi trường <span class="float-end small text-muted">05:15</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <strong>Phần 2: Kiến thức trọng tâm</strong>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="bi bi-play-circle me-2"></i> Bài học số 1 <span class="float-end small text-muted">10:00</span></li>
                                        <li class="list-group-item"><i class="bi bi-file-earmark-text me-2"></i> Bài tập trắc nghiệm</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="course-sidebar sticky-top" style="top: 90px; z-index: 1;">
                    <div class="card border-0 shadow-lg overflow-hidden">
                        
                        <div class="position-relative">
                            <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= !empty($course['image']) ? $course['image'] : 'default-course.png' ?>" class="card-img-top" alt="Course Image">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-play-circle-fill text-white display-1 opacity-75"></i>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="mb-3 text-center">
                                <?php if($course['price'] == 0): ?>
                                    <h2 class="text-primary fw-bold">Miễn phí</h2>
                                <?php else: ?>
                                    <h2 class="text-primary fw-bold"><?= number_format($course['price']) ?> đ</h2>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <?php if (isset($isEnrolled) && $isEnrolled): ?>
                                        <button class="btn btn-success btn-lg fw-bold">ĐÃ ĐĂNG KÝ - VÀO HỌC</button>
                                    <?php else: ?>
                                  <form action="<?= BASE_URL ?>/index.php?controller=course&action=enroll&id=<?= $course['id'] ?>" method="POST">
                                        <button type="submit" class="btn btn-primary btn-lg fw-bold w-100">ĐĂNG KÝ NGAY</button>
                                   </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-primary btn-lg fw-bold">ĐĂNG NHẬP ĐỂ HỌC</a>
                                <?php endif; ?>
                            </div>

                            <ul class="list-unstyled text-secondary mb-0">
                                <li class="mb-2"><i class="bi bi-bar-chart-fill me-2"></i> Trình độ: <strong><?= $course['level'] ?></strong></li>
                                <li class="mb-2"><i class="bi bi-clock-fill me-2"></i> Thời lượng: <strong><?= $course['duration_weeks'] ?> tuần</strong></li>
                                <li class="mb-2"><i class="bi bi-film me-2"></i> Tổng số bài học: <strong>25</strong></li>
                                <li><i class="bi bi-infinity me-2"></i> Truy cập trọn đời</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>