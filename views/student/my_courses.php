<?php 
$title = "Khóa học của tôi";
include __DIR__ . '/../layouts/header.php'; 
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Khóa học của tôi</h2>

    <?php if (empty($myCourses)): ?>
        <div class="alert alert-info text-center">
            <p class="mb-3">Bạn chưa đăng ký khóa học nào.</p>
            <a href="<?= BASE_URL ?>/course/index" class="btn btn-primary">Khám phá khóa học ngay</a>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($myCourses as $course): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/assets/uploads/courses/<?= !empty($course['image']) ? $course['image'] : 'default.png' ?>" 
                             class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" 
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($course['title']) ?></h5>
                            
                            <p class="card-text text-muted small mb-2">
                                <i class="bi bi-person-circle"></i> GV: <?= htmlspecialchars($course['instructor_name']) ?>
                            </p>
                            
                            <div class="progress mb-3" style="height: 10px;">
                                <?php $progress = $course['progress'] ?? 0; ?>
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: <?= $progress ?>%" 
                                     aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted mb-3 d-block"><?= $progress ?>% hoàn thành</small>

                            <div class="mt-auto">
                                <a href="<?= BASE_URL ?>/index.php?controller=course&action=learn&id=<?= $course['course_id'] ?>" 
                                   class="btn btn-primary w-100 fw-bold">
                                    <i class="bi bi-play-circle-fill"></i> TIẾP TỤC HỌC
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>