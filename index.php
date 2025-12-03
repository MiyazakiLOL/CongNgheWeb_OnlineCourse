<?php
// index.php – nằm trong htdocs/onlinecourse/index.php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        }
    }
});

// LẤY URL ĐÚNG KHI DỰ ÁN NẰM TRONG THƯ MỤC CON
$request_uri = $_SERVER['REQUEST_URI'];

// Loại bỏ query string (?xxx=yyy)
$request_uri = explode('?', $request_uri)[0];

// Lấy base path thực tế (ví dụ: /onlinecourse)
$script_name = $_SERVER['SCRIPT_NAME'];           // vd: /onlinecourse/index.php
$base_path   = dirname($script_name);             // vd: /onlinecourse
if ($base_path === '/' || $base_path === '\\') {
    $base_path = '';
}

// Cắt bỏ base path khỏi request_uri
$uri = $request_uri;
if ($base_path !== '' && strpos($request_uri, $base_path) === 0) {
    $uri = substr($request_uri, strlen($base_path));
}
$uri = trim($uri, '/');
if ($uri === 'index.php') $uri = ''; // tránh trường hợp truy cập trực tiếp index.php

// Nếu vẫn rỗng → trang chủ
if ($uri === '') {
    $controller = 'HomeController';
    $method     = 'index';
    $params     = [];
} else {
    $segments = explode('/', $uri);

    $controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
    $method     = !empty($segments[1]) ? $segments[1] : 'index';
    $params     = count($segments) > 2 ? array_slice($segments, 2) : [];
}

// Kiểm tra controller tồn tại
$controllerFile = __DIR__ . "/controllers/$controller.php";
if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1><p>Controller <strong>$controller</strong> không tồn tại.</p>";
    exit;
}

$instance = new $controller();

if (!method_exists($instance, $method)) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1><p>Phương thức <strong>$method</strong> không tồn tại trong $controller.</p>";
    exit;
}

// Gọi hàm
call_user_func_array([$instance, $method], $params);