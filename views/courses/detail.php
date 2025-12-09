<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="course-detail-page">
    <div class="course-header">
        <h1><?= htmlspecialchars($course['title'] ?? 'Khóa học') ?></h1>
        <p class="course-meta">
            <span class="category"><?= htmlspecialchars($course['category_id'] ?? 'Khác') ?></span>
            <span class="instructor">Giảng viên ID: <?= htmlspecialchars($course['instructor_id']) ?></span>
        </p>
    </div>

    <div class="course-content">
        <div class="main-content">
            <section class="description-section">
                <h2>Về khóa học</h2>
                <p><?= nl2br(htmlspecialchars($course['description'] ?? '')) ?></p>
            </section>

            <section class="lessons-section">
                <h2>Danh sách bài học</h2>
                <?php if (empty($lessons)): ?>
                    <p class="text-muted">Khóa học này chưa có bài học nào.</p>
                <?php else: ?>
                    <div class="lessons-list">
                        <?php foreach ($lessons as $lesson): ?>
                            <div class="lesson-item">
                                <div class="lesson-header">
                                    <h4><?= htmlspecialchars($lesson['title']) ?></h4>
                                    <?php if ($lesson['video_url']): ?>
                                        <span class="video-badge">📹 Có video</span>
                                    <?php endif; ?>
                                </div>
                                <p class="lesson-preview">
                                    <?= htmlspecialchars(substr($lesson['content'], 0, 100)) ?>...
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <?php if (!empty($materials)): ?>
                <section class="materials-section">
                    <h2>Tài liệu hỗ trợ</h2>
                    <div class="materials-list">
                        <?php foreach ($materials as $material): ?>
                            <div class="material-item">
                                <span class="material-icon">📄</span>
                                <span class="material-name"><?= htmlspecialchars($material['title']) ?></span>
                                <a href="/material/download/<?= $material['id'] ?>" class="btn btn-sm btn-secondary">Tải</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <div class="sidebar">
            <div class="enrollment-card">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id']): ?>
                    <button class="btn btn-primary btn-large" onclick="enrollCourse(<?= $course['id'] ?>)">Đăng ký khóa học</button>
                <?php else: ?>
                    <p class="text-center">Vui lòng <a href="/auth/login">đăng nhập</a> để đăng ký khóa học</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function enrollCourse(courseId) {
    if (confirm('Bạn muốn đăng ký khóa học này?')) {
        window.location.href = '/enrollment/enroll/' + courseId;
    }
}
</script>

<style>
.course-detail-page { padding: 30px 20px; max-width: 1200px; margin: 0 auto; }

.course-header { margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 20px; }
.course-header h1 { margin: 0 0 10px 0; font-size: 36px; color: #333; }
.course-meta { margin: 0; font-size: 14px; color: #666; }
.category { display: inline-block; background-color: #007bff; color: white; padding: 4px 12px; border-radius: 20px; margin-right: 15px; }
.instructor { color: #666; }

.course-content { display: grid; grid-template-columns: 1fr 300px; gap: 30px; }
.main-content { }

section { margin-bottom: 40px; }
section h2 { font-size: 24px; margin: 0 0 20px 0; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
section p { color: #666; line-height: 1.6; margin: 0; }

.description-section { }

.lessons-section { }
.lessons-list { }
.lesson-item { background: #f9f9f9; border: 1px solid #ddd; border-radius: 6px; padding: 15px; margin-bottom: 15px; }
.lesson-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
.lesson-header h4 { margin: 0; color: #333; }
.video-badge { background-color: #28a745; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
.lesson-preview { color: #666; font-size: 13px; margin: 10px 0 0 0; }

.materials-section { }
.materials-list { }
.material-item { display: flex; align-items: center; gap: 10px; background: #f0f0f0; padding: 12px; border-radius: 4px; margin-bottom: 10px; }
.material-icon { font-size: 20px; }
.material-name { flex: 1; }

.sidebar { }
.enrollment-card { background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; }
.btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; cursor: pointer; border: none; font-size: 14px; font-weight: bold; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
.btn-large { width: 100%; padding: 15px; font-size: 16px; }
.btn-secondary { background-color: #6c757d; color: white; padding: 5px 10px; font-size: 12px; }
.btn-secondary:hover { background-color: #5a6268; }
.btn-sm { padding: 5px 10px; font-size: 12px; }
.text-muted { color: #6c757d; }
.text-center { text-align: center; }
.text-center a { color: #007bff; text-decoration: none; }

@media (max-width: 768px) {
    .course-content { grid-template-columns: 1fr; }
    .sidebar { order: -1; }
}
</style>
