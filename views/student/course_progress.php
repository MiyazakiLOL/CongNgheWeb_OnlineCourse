<?php 
// views/courses/course_progress.php

$title = "Đang học: " . htmlspecialchars($course['title']);
include __DIR__ . '/../layouts/header.php'; 

// --- 1. LOGIC TÌM BÀI TRƯỚC / BÀI SAU ---
$prev_lesson_id = null;
$next_lesson_id = null;
$current_index = -1;

// Tìm vị trí của bài hiện tại trong mảng $lessons
foreach ($lessons as $index => $les) {
    if ($currentLesson && $les['id'] == $currentLesson['id']) {
        $current_index = $index;
        break;
    }
}

// Xác định ID bài trước và bài sau
if ($current_index !== -1) {
    if (isset($lessons[$current_index - 1])) {
        $prev_lesson_id = $lessons[$current_index - 1]['id'];
    }
    if (isset($lessons[$current_index + 1])) {
        $next_lesson_id = $lessons[$current_index + 1]['id'];
    }
}
?>

<div class="bg-dark text-white py-2 mb-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="<?= BASE_URL ?>/index.php?controller=course&action=detail&id=<?= $course['id'] ?>" class="text-white text-decoration-none fw-bold">
            <i class="bi bi-chevron-left"></i> Quay lại chi tiết khóa học
        </a>
        <span class="d-none d-md-block"><?= htmlspecialchars($course['title']) ?></span>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        
        <div class="col-lg-8 mb-4">
            <?php if ($currentLesson): ?>
                <div class="ratio ratio-16x9 bg-black rounded shadow overflow-hidden mb-3">
                    <?php if (!empty($currentLesson['video_url'])): ?>
                        <iframe src="<?= $currentLesson['video_url'] ?>" title="Bài giảng video" allowfullscreen></iframe>
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center text-secondary h-100">
                            <div class="text-center">
                                <i class="bi bi-play-btn display-4"></i>
                                <p class="mt-2">Bài học này không có video.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <?php if ($prev_lesson_id): ?>
                        <a href="<?= BASE_URL ?>/index.php?controller=course&action=learn&id=<?= $course['id'] ?>&lesson_id=<?= $prev_lesson_id ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Bài trước
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary btn-sm" disabled>Bài đầu tiên</button>
                    <?php endif; ?>

                    <?php if ($next_lesson_id): ?>
                        <a href="<?= BASE_URL ?>/index.php?controller=course&action=learn&id=<?= $course['id'] ?>&lesson_id=<?= $next_lesson_id ?>" class="btn btn-primary btn-sm">
                            Bài tiếp theo <i class="bi bi-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-primary btn-sm" disabled>Đã hết bài</button>
                    <?php endif; ?>
                </div>

                <h2 class="fw-bold text-primary mb-3"><?= htmlspecialchars($currentLesson['title']) ?></h2>
                <div class="bg-light p-4 rounded border mb-4">
                    <h5 class="fw-bold"><i class="bi bi-file-text"></i> Nội dung bài học</h5>
                    <div class="text-secondary mt-2">
                        <?= nl2br(htmlspecialchars($currentLesson['content'])) ?>
                    </div>
                </div>

                <div class="materials-section">
                    <h5 class="fw-bold mb-3"><i class="bi bi-paperclip"></i> Tài liệu đính kèm</h5>
                    <?php if (!empty($materials)): ?>
                        <div class="list-group">
                            <?php foreach ($materials as $file): ?>
                                <?php 
                                    // Icon theo loại file
                                    $icon = 'bi-file-earmark'; 
                                    if (strpos($file['file_type'], 'pdf') !== false) $icon = 'bi-file-earmark-pdf text-danger';
                                    elseif (strpos($file['file_type'], 'doc') !== false) $icon = 'bi-file-earmark-word text-primary';
                                    elseif (strpos($file['file_type'], 'zip') !== false) $icon = 'bi-file-earmark-zip text-warning';
                                ?>
                                <a href="<?= BASE_URL . $file['file_path'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" download>
                                    <span>
                                        <i class="bi <?= $icon ?> me-2"></i>
                                        <?= htmlspecialchars($file['filename']) ?>
                                    </span>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-download"></i> Tải về</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted fst-italic small">Không có tài liệu nào cho bài học này.</p>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="alert alert-warning text-center p-5">
                    <h4>Chưa có bài học nào!</h4>
                    <p>Nội dung khóa học đang được cập nhật.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul"></i> Danh sách bài học</h6>
                    <small><?= count($lessons) ?> bài học</small>
                </div>
                
                <div class="list-group list-group-flush overflow-auto custom-scrollbar" style="max-height: 70vh;">
                    <?php foreach ($lessons as $index => $les): ?>
                        <?php 
                            $isActive = ($currentLesson && $les['id'] == $currentLesson['id']);
                        ?>
                        <a href="<?= BASE_URL ?>/index.php?controller=course&action=learn&id=<?= $course['id'] ?>&lesson_id=<?= $les['id'] ?>" 
                           class="list-group-item list-group-item-action py-3 <?= $isActive ? 'active-lesson' : '' ?>"
                           id="lesson-<?= $les['id'] ?>"> <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <small class="fw-bold text-muted">Bài <?= $index + 1 ?></small>
                                    <h6 class="mb-0 mt-1 fw-bold text-dark lesson-title"><?= htmlspecialchars($les['title']) ?></h6>
                                </div>
                                <?php if($isActive): ?>
                                    <i class="bi bi-play-circle-fill text-primary fs-4"></i>
                                <?php else: ?>
                                    <i class="bi bi-play-circle text-muted fs-5"></i>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .active-lesson {
        background-color: #e7f1ff !important; /* Xanh rất nhạt */
        border-left: 4px solid #0d6efd !important;
    }
    .lesson-title {
        font-size: 0.95rem;
        line-height: 1.4;
    }
    /* Tùy chỉnh thanh cuộn cho đẹp */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ccc; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #aaa; 
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var activeLesson = document.querySelector('.active-lesson');
        if (activeLesson) {
            activeLesson.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>