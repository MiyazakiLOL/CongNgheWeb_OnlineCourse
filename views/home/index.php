<?php 
$title = "OnlineCourse - Học mọi lúc mọi nơi"; 
include __DIR__ . '/../layouts/header.php'; 
?>

<section class="hero-udemy text-white py-5" style="background: linear-gradient(to right, #1c1d1f, #2d2f31);">
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
            <div class="col-lg-6 text-center">
                <img src="<?= BASE_URL ?>/assets/uploads/hero-illustration.jpg" onerror="this.src='https://img.freepik.com/free-vector/online-learning-isometric-concept_1284-17947.jpg'" alt="Learning" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://img.freepik.com/free-vector/learning-concept-illustration_114360-6186.jpg" alt="Why Choose Us" class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-md-6 ps-md-5">
                <h6 class="text-primary fw-bold text-uppercase">Về chúng tôi</h6>
                <h2 class="fw-bold mb-4">Tại sao nên học ở OnlineCourse?</h2>
                <p class="text-muted lead mb-4" style="line-height: 1.8;">
                    Chúng tôi hiểu rằng việc tự học có thể gặp nhiều khó khăn. Tại OnlineCourse, chúng tôi cam kết mang đến trải nghiệm học tập tốt nhất.
                    Nền tảng cung cấp lộ trình rõ ràng, nội dung được cập nhật liên tục theo xu hướng công nghệ mới nhất.
                    Bạn có thể học mọi lúc, mọi nơi trên mọi thiết bị với sự hỗ trợ nhiệt tình từ cộng đồng và giảng viên.
                    Chứng chỉ hoàn thành khóa học giúp bạn làm đẹp hồ sơ xin việc và thăng tiến trong sự nghiệp.
                    Đừng chỉ học, hãy làm chủ kiến thức và thay đổi tương lai của bạn ngay hôm nay.
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> <span>Học phí linh hoạt</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> <span>Truy cập trọn đời</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> <span>Giảng viên uy tín</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> <span>Cấp chứng chỉ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light border-top border-bottom">
    <div class="container text-center">
        <h3 class="fw-bold mb-5">Các ngôn ngữ & Công nghệ tiêu biểu</h3>
        <div class="d-flex flex-wrap justify-content-center gap-4 align-items-center">
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px; transition: transform 0.3s;">
                <i class="bi bi-filetype-php fs-1 text-primary"></i>
                <span class="fw-bold mt-2">PHP</span>
            </div>
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-filetype-py fs-1 text-warning"></i>
                <span class="fw-bold mt-2">Python</span>
            </div>
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-filetype-java fs-1 text-danger"></i>
                <span class="fw-bold mt-2">Java</span>
            </div>
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <span class="fs-1 fw-bold text-primary">C++</span>
                <span class="fw-bold mt-2">C++</span>
            </div>
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-filetype-js fs-1 text-warning"></i>
                <span class="fw-bold mt-2">JavaScript</span>
            </div>
            <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-filetype-jsx fs-1 text-info"></i>
                <span class="fw-bold mt-2">ReactJS</span>
            </div>
             <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-database fs-1 text-secondary"></i>
                <span class="fw-bold mt-2">SQL</span>
            </div>
             <div class="bg-white p-3 rounded shadow-sm d-flex flex-column align-items-center" style="width: 120px;">
                <i class="bi bi-filetype-html fs-1 text-danger"></i>
                <span class="fw-bold mt-2">HTML5</span>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #e3f2fd;">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Người dẫn đường</h6>
            <h3 class="fw-bold">Đội ngũ giảng viên hàng đầu</h3>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($latestInstructors)): ?>
                <?php foreach ($latestInstructors as $inst): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center p-3 hover-card">
                        <div class="card-body">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($inst['fullname']) ?>&background=random&size=128" 
                                 class="rounded-circle mb-3 border border-3 border-white shadow-sm" 
                                 alt="<?= htmlspecialchars($inst['fullname']) ?>" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($inst['fullname']) ?></h5>
                            <p class="text-muted small mb-3">Giảng viên cấp cao</p>
                            
                            <p class="card-text small text-secondary">
                                "Chia sẻ kiến thức là niềm đam mê. Tôi mong muốn giúp các bạn tiếp cận công nghệ một cách dễ dàng nhất."
                            </p>
                            
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="#" class="text-secondary"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="text-secondary"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="text-secondary"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Đang cập nhật danh sách giảng viên...</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <h3 class="fw-bold mb-4">Khám phá theo danh mục</h3>
        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 col-6">
                <a href="<?= BASE_URL ?>/course/index?category_id=<?= $cat['id'] ?>" class="text-decoration-none text-dark">
                    <div class="category-btn text-center p-4 h-100 border rounded transition-hover bg-light">
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
            <div class="col-lg-3 col-md-6 mb-4"> 
                <a href="<?= BASE_URL ?>/course/detail/<?= $course['id'] ?>" class="text-decoration-none text-dark d-block h-100 course-link-wrapper">
                    <div class="card course-card h-100 border-0 shadow-sm transition-hover">
                        <div class="position-relative">
                            <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= !empty($course['image']) ? $course['image'] : 'default-course.png' ?>" 
                                 class="card-img-top course-img" 
                                 alt="<?= htmlspecialchars($course['title']) ?>"
                                 style="height: 180px; object-fit: cover;">
                            <?php if(rand(0,1)==1): ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Bán chạy</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate-2" title="<?= htmlspecialchars($course['title']) ?>">
                                <?= htmlspecialchars($course['title']) ?>
                            </h6>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($course['instructor_name'] ?? ($course['instructor_display_name'] ?? 'Giảng viên')) ?>
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <span class="fw-bold text-warning me-1">4.8</span>
                                <div class="small text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="text-muted small ms-2">(<?= rand(100,5000) ?>)</span>
                            </div>
                            <div class="mt-auto d-flex align-items-center">
                                <?php $price = isset($course['price']) ? (float)$course['price'] : 0.0; ?>
                                <?php if($price == 0): ?>
                                    <span class="fw-bold text-success fs-5">Miễn phí</span>
                                <?php else: ?>
                                    <span class="fw-bold fs-5 text-primary"><?= number_format($price) ?>đ</span>
                                    <?php if($price > 0): ?>
                                        <span class="text-muted text-decoration-line-through ms-2 small"><?= number_format($price * 1.3) ?>đ</span>
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

<section class="py-5 bg-dark text-white">
    <div class="container">
        <h3 class="fw-bold mb-5 text-center">Học viên nói gì về chúng tôi?</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card bg-secondary bg-opacity-25 text-white border-0 h-100 p-3">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text fst-italic">"Khóa học PHP rất thực tế, giảng viên hỗ trợ nhiệt tình. Nhờ OnlineCourse mà tôi đã kiếm được công việc lập trình đầu tiên với mức lương mong đợi."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&background=random" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="fw-bold mb-0">Nguyễn Văn A</h6>
                                <small class="text-white-50">Lập trình viên Backend</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary bg-opacity-25 text-white border-0 h-100 p-3">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text fst-italic">"Nội dung phong phú và cập nhật liên tục. Tôi đặc biệt thích cách chia nhỏ bài giảng, rất dễ tiếp thu cho người mới bắt đầu học code."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://ui-avatars.com/api/?name=Tran+Thi+B&background=random" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="fw-bold mb-0">Trần Thị B</h6>
                                <small class="text-white-50">Sinh viên IT</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary bg-opacity-25 text-white border-0 h-100 p-3">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                        <p class="card-text fst-italic">"Giá cả hợp lý cho sinh viên nhưng chất lượng thì tuyệt vời. Hệ thống bài tập thực hành giúp tôi nhớ kiến thức lâu hơn rất nhiều."</p>
                        <div class="d-flex align-items-center mt-4">
                            <img src="https://ui-avatars.com/api/?name=Le+Minh+C&background=random" class="rounded-circle me-3" width="50">
                            <div>
                                <h6 class="fw-bold mb-0">Lê Minh C</h6>
                                <small class="text-white-50">Freelancer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>