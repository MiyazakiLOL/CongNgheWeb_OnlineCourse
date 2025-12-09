<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="student-courses-page">
    <h1>Khóa học của tôi</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($courses)): ?>
        <div class="empty-state">
            <p>Bạn chưa đăng ký khóa học nào.</p>
            <a href="/course" class="btn btn-primary">Khám phá khóa học</a>
        </div>
    <?php else: ?>
        <div class="enrolled-courses">
            <?php foreach ($courses as $enrollment): ?>
                <div class="course-enrollment-card">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($enrollment['course_title'] ?? $enrollment['title'] ?? 'Khóa học') ?></h3>
                        <p class="course-description">
                            <?= htmlspecialchars(substr($enrollment['description'], 0, 100)) ?>...
                        </p>
                        
                        <div class="progress-info">
                            <span class="progress-label">Tiến độ:</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= $enrollment['progress'] ?? 0 ?>%"></div>
                            </div>
                            <span class="progress-percent"><?= $enrollment['progress'] ?? 0 ?>%</span>
                        </div>

                        <div class="card-footer">
                            <a href="/course/detail/<?= $enrollment['course_id'] ?>" class="btn btn-primary">Tiếp tục học</a>
                            <a href="/enrollment/unenroll/<?= $enrollment['id'] ?>" class="btn btn-danger" onclick="return confirm('Huỷ đăng ký khóa học?');">Huỷ đăng ký</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.student-courses-page { padding: 30px 20px; max-width: 1000px; margin: 0 auto; }

.student-courses-page h1 { font-size: 28px; margin: 0 0 25px 0; color: #333; }

.alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.empty-state { text-align: center; padding: 60px 20px; background: #f9f9f9; border-radius: 8px; }
.empty-state p { font-size: 16px; color: #666; margin: 0 0 20px 0; }

.enrolled-courses { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

.course-enrollment-card { background: white; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
.course-enrollment-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

.card-content { padding: 20px; }
.card-content h3 { margin: 0 0 10px 0; font-size: 18px; color: #333; }
.course-description { margin: 0 0 15px 0; color: #666; font-size: 13px; line-height: 1.5; }

.progress-info { margin: 15px 0; }
.progress-label { display: block; font-size: 12px; font-weight: bold; color: #666; margin-bottom: 5px; }
.progress-bar { width: 100%; height: 8px; background: #e9ecef; border-radius: 4px; overflow: hidden; }
.progress-fill { height: 100%; background: linear-gradient(90deg, #28a745, #20c997); transition: width 0.3s; }
.progress-percent { font-size: 12px; color: #666; margin-left: 10px; }

.card-footer { display: flex; gap: 10px; margin-top: 15px; }

.btn { padding: 10px 15px; text-decoration: none; border-radius: 4px; cursor: pointer; border: none; font-size: 13px; font-weight: bold; flex: 1; text-align: center; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
.btn-danger { background-color: #dc3545; color: white; }
.btn-danger:hover { background-color: #c82333; }
</style>
