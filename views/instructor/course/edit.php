<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Chỉnh sửa khóa học</h4>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/instructor/courses/update/<?= $course['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên khóa học (*)</label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($course['title']) ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $course['category_id'] ? 'selected' : '' ?>>
                                            <?= $cat['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá (VNĐ)</label>
                                <input type="number" name="price" class="form-control" value="<?= $course['price'] ?>" min="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trình độ</label>
                                <select name="level" class="form-select">
                                    <option value="Beginner" <?= $course['level'] == 'Beginner' ? 'selected' : '' ?>>Cơ bản</option>
                                    <option value="Intermediate" <?= $course['level'] == 'Intermediate' ? 'selected' : '' ?>>Trung cấp</option>
                                    <option value="Advanced" <?= $course['level'] == 'Advanced' ? 'selected' : '' ?>>Nâng cao</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thời lượng (Tuần)</label>
                                <input type="number" name="duration_weeks" class="form-control" value="<?= $course['duration_weeks'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($course['description']) ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/instructor/dashboard" class="btn btn-secondary">Hủy bỏ</a>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>