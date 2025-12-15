<?php
// index.php – htdocs/onlinecourse/index.php

session_start();
define('BASE_URL', '/onlinecourse');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . $host . '/'; // Điều chỉnh nếu dự án chạy trong thư mục con

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . "/controllers/$class.php",
        __DIR__ . "/models/$class.php",
        __DIR__ . "/config/$class.php"
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// LẤY URL ĐÚNG KHI DỰ ÁN NẰM TRONG THƯ MỤC CON

$controller = '';
$method = '';
$params = [];

// [SỬA] BƯỚC 1: Kiểm tra xem có tham số controller gửi lên kiểu truyền thống không?
// (Đây là cái Form Đăng ký cần)
if (isset($_REQUEST['controller'])) {
    $controller = ucfirst($_REQUEST['controller']) . 'Controller';
    $method     = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
    // ID và các tham số khác sẽ nằm trong $_POST hoặc $_GET, không cần xử lý params ở đây
} 
// [SỬA] BƯỚC 2: Nếu không có, thì mới dùng logic đường dẫn thân thiện cũ của bạn
else {
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

$script_name = $_SERVER['SCRIPT_NAME']; // /onlinecourse/index.php
$base_path   = dirname($script_name);   // /onlinecourse

if ($base_path === '/' || $base_path === '\\') {
    $base_path = '';
}

// Cắt base path
if ($base_path && strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

$uri = trim($request_uri, '/');

if ($uri === '' || $uri === 'index.php') {
    $controller = 'HomeController';
    $method = 'index';
    $params = [];
} else {
    $segments = explode('/', $uri);

    $controller = ucfirst($segments[0]) . 'Controller';
    $method     = $segments[1] ?? 'index';
    $params     = array_slice($segments, 2);
}

// ================= ROUTE QUẢN LÝ BÀI HỌC =================
// instructor/lessons/manage/{course_id}
if (
    isset($segments[0], $segments[1], $segments[2], $segments[3]) &&
    $segments[0] === 'instructor' &&
    $segments[1] === 'lessons' &&
    $segments[2] === 'manage'
) {
    require_once __DIR__ . '/controllers/LessonController.php';
    $controller = new LessonController();
    $controller->manage($segments[3]);
    exit;
}
}



// ========================
// KIỂM TRA CONTROLLER
// ========================
$controllerFile = __DIR__ . "/controllers/$controller.php";
if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>
          <p>Controller <strong>$controller</strong> không tồn tại.</p>";
    exit;
}

$instance = new $controller();

if (!method_exists($instance, $method)) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>
          <p>Method <strong>$method</strong> không tồn tại trong $controller.</p>";
    exit;
}

if ($controller == 'InstructorController') {
    if ($method == 'courses') {
        // Lấy tham số từ URL
        // Ví dụ URL: /instructor/courses/edit/1 
        // -> $params[0] là 'edit' (action)
        // -> $params[1] là '1' (id)
        
        $action = isset($params[0]) ? $params[0] : 'list';
        $id = isset($params[1]) ? $params[1] : null;

        // Gọi hàm courses() thay vì createCourse() hay editCourse()
        $instance->courses($action, $id);
        
        // Dừng script tại đây để không chạy xuống logic mặc định bên dưới
        exit; 
    }
}

if ($controller == 'LessonController') {
    // Lấy ID từ tham số URL (params[0])
    $id = isset($params[0]) ? $params[0] : null;

    switch ($method) {
        case 'manage': // Quản lý bài học của khóa học (ID = course_id)
            if ($id) $instance->manage($id);
            break;

        case 'create': // Form tạo bài học (ID = course_id)
            if ($id) $instance->create($id);
            break;

        case 'store': // Xử lý lưu (ID = course_id)
            if ($id) $instance->store($id);
            break;

        case 'edit': // Form sửa (ID = lesson_id)
            if ($id) $instance->edit($id);
            break;

        case 'update': // Xử lý sửa (ID = lesson_id)
            if ($id) $instance->update($id);
            break;

        case 'delete': // Xóa (ID = lesson_id)
            if ($id) $instance->delete($id);
            break;
            
        default:
            header('Location: ' . BASE_URL . '/instructor/dashboard');
            break;
    }
    exit;
}

// Gọi hàm
call_user_func_array([$instance, $method], $params);
