<style>
    .custom-footer {
        background-color: #1c1d1f; /* Màu nền tối giống trong ảnh */
        color: #fff;
        font-size: 14px;
        padding-top: 40px;
        padding-bottom: 20px;
        margin-top: auto; /* Đẩy footer xuống đáy nếu nội dung ngắn */
    }

    .custom-footer h6 {
        font-weight: 700;
        margin-bottom: 15px;
        color: #fff;
    }

    .custom-footer ul {
        padding-left: 0;
        list-style: none;
    }

    .custom-footer ul li {
        margin-bottom: 8px;
    }

    .custom-footer ul li a {
        color: #d1d7dc; /* Màu chữ xám nhạt */
        text-decoration: none;
        transition: color 0.2s;
    }

    .custom-footer ul li a:hover {
        color: #fff; /* Hover chuyển màu trắng */
        text-decoration: underline;
    }

    .footer-bottom {
        border-top: 1px solid #3e4143;
        margin-top: 30px;
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .logo-text {
        font-weight: bold;
        font-size: 1.5rem;
        color: #fff;
    }
</style>

<footer class="custom-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <h6>Chủ đề Hot</h6>
                <ul>
                    <li><a href="#">Lập trình Python</a></li>
                    <li><a href="#">Phát triển Web</a></li>
                    <li><a href="#">Machine Learning</a></li>
                    <li><a href="#">Phân tích dữ liệu</a></li>
                    <li><a href="#">Marketing Online</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <h6>Chứng chỉ IT</h6>
                <ul>
                    <li><a href="#">Amazon AWS</a></li>
                    <li><a href="#">Microsoft Azure</a></li>
                    <li><a href="#">Cisco CCNA</a></li>
                    <li><a href="#">Google Cloud</a></li>
                    <li><a href="#">Cybersecurity</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h6>Phát triển sự nghiệp</h6>
                <ul>
                    <li><a href="#">Kỹ năng lãnh đạo</a></li>
                    <li><a href="#">Quản lý dự án</a></li>
                    <li><a href="#">Giao tiếp hiệu quả</a></li>
                    <li><a href="#">Tiếng Anh thương mại</a></li>
                    <li><a href="#">Năng suất làm việc</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h6>Về chúng tôi</h6>
                <ul>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Hỗ trợ & Giúp đỡ</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="d-flex align-items-center">
                <span class="logo-text me-4">OnlineCourse</span>
                <small class="text-muted">© <?= date('Y') ?> Bản quyền thuộc về OnlineCourse.</small>
            </div>
            
            <div>
                <button class="btn btn-outline-light btn-sm">
                    <i class="bi bi-globe"></i> Tiếng Việt
                </button>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>