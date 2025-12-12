<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tạo khóa học mới</h4>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/instructor/courses/store" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label">Tên khóa học (*)</label>
                            <input type="text" name="title" class="form-control" required placeholder="Nhập tên khóa học...">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá (VNĐ)</label>
                                <input type="number" name="price" class="form-control" value="0" min="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trình độ</label>
                                <select name="level" class="form-select">
                                    <option value="Beginner">Cơ bản</option>
                                    <option value="Intermediate">Trung cấp</option>
                                    <option value="Advanced">Nâng cao</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thời lượng (Tuần)</label>
                                <input type="number" name="duration_weeks" class="form-control" value="4">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/instructor/dashboard" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu khóa học</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>