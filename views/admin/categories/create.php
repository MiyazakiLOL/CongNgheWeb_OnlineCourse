<?php 
// SỬA: Dùng ../../ để lùi 2 cấp thư mục (categories -> admin -> views)
include __DIR__ . '/../../layouts/header.php'; 
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Tạo Danh mục Mới</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        
                        <div class="mb-3">
                            <label class="form-label">Tên danh mục (*):</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Lập trình Web">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mô tả:</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Mô tả ngắn về danh mục này..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                            
                            <button type="submit" name="create" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Tạo mới
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// SỬA: Dùng ../../ cho footer luôn
include __DIR__ . '/../../layouts/footer.php'; 
?>