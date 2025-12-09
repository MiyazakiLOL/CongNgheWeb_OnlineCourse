<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="courses-page">
    <div class="page-header">
        <h1>Tất cả khóa học</h1>
        <p class="subtitle">Khám phá và đăng ký các khóa học của chúng tôi</p>
    </div>

    <div class="courses-search">
        <form method="GET" action="/course" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm khóa học..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" class="btn btn-search">Tìm kiếm</button>
        </form>
    </div>

    <?php if (empty($courses)): ?>
        <div class="alert alert-info">
            <p>Không tìm thấy khóa học nào. Vui lòng thử tìm kiếm khác.</p>
        </div>
    <?php else: ?>
        <div class="courses-grid">
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <div class="course-header">
                        <h3><?= htmlspecialchars($course['title']) ?></h3>
                        <span class="course-category"><?= htmlspecialchars($course['category_id'] ?? 'Khác') ?></span>
                    </div>
                    
                    <p class="course-description">
                        <?= htmlspecialchars(substr($course['description'], 0, 120)) ?>...
                    </p>
                    
                    <div class="course-footer">
                        <a href="/course/detail/<?= $course['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.courses-page { padding: 30px 20px; max-width: 1200px; margin: 0 auto; }

.page-header { text-align: center; margin-bottom: 40px; }
.page-header h1 { font-size: 32px; margin: 0 0 10px 0; color: #333; }
.subtitle { font-size: 16px; color: #666; margin: 0; }

.courses-search { margin-bottom: 30px; }
.search-form { display: flex; gap: 10px; max-width: 500px; margin: 0 auto; }
.search-form input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
.btn-search { padding: 12px 30px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
.btn-search:hover { background-color: #0056b3; }

.alert { padding: 20px; border-radius: 8px; text-align: center; }
.alert-info { background-color: #e7f3ff; color: #004085; border: 1px solid #b3d9ff; }

.courses-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }

.course-card { background: white; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
.course-card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

.course-header { padding: 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd; }
.course-header h3 { margin: 0 0 10px 0; font-size: 18px; color: #333; }
.course-category { display: inline-block; background-color: #007bff; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; }

.course-description { padding: 20px; color: #666; font-size: 14px; line-height: 1.5; margin: 0; }

.course-footer { padding: 15px 20px; border-top: 1px solid #ddd; text-align: center; }

.btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; cursor: pointer; border: none; font-size: 14px; font-weight: bold; }
.btn-primary { background-color: #007bff; color: white; }
.btn-primary:hover { background-color: #0056b3; }
</style>
