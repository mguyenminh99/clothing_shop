<?php

use App\Controllers\HomeController;
use App\Middleware\MiddlewareHelper;

// Home routes - có thể truyền số lần request tùy ý
$router->get('/', [HomeController::class, 'index'], [MiddlewareHelper::rateLimit()]); // 1 request/second

// maintenance routes
$router->get('/maintenance', [HomeController::class, 'maintenance']); // 10 requests/hour

// Topic routes
// $router->group('/topic', function ($router) {
//     $router->get('/', [TopicController::class, 'index']);
//     $router->get('/{category}', [TopicController::class, 'Category'])
//         ->where('category', '[a-zA-Z\-]+');
//     $router->get('/{category}/{id}', [TopicController::class, 'Detail'])
//         ->where([
//             'category' => '[a-zA-Z\-]+',
//             'id' => '[0-9]+'
//         ]);
// }, [MiddlewareHelper::rateLimit()]);

// Location-based routes - must be placed after specific routes to avoid conflicts
// $router->get('/{city}', [HomeController::class, 'index'], [MiddlewareHelper::rateLimit(50, 3600)]); // city only route
// $router->get('/{city}/{district}', [HomeController::class, 'index'], [MiddlewareHelper::rateLimit(50, 3600)]); // city/district route


// ================================================================
// Lightweight cache clear endpoint (protect with token) ||| 
// Để xóa cache, vào file config.php, thêm CACHE_ADMIN_TOKEN = 'your_token_here'
// Vào đường dẫn xóa all http://localhost/your-app/_cache/flush?token=your_token_here 
// Để xóa cache theo prefix, vào đường dẫn http://localhost/your-app/_cache/flush?token=your_token_here&prefix=your_prefix_here
$router->get('/_cache/flush', function () {
    $token = $_GET['token'] ?? '';
    $expected = Config::get('CACHE_ADMIN_TOKEN', '');
    if (!$expected || !hash_equals((string)$expected, (string)$token)) {
        http_response_code(403);
        echo 'forbidden';
        return;
    }

    $prefix = $_GET['prefix'] ?? null;
    if ($prefix) {
        $deleted = Cache::deleteByPrefix($prefix);
        echo "deleted:$deleted entries with prefix '$prefix'";
    } else {
        Cache::flush();
        echo 'flushed';
    }
    exit();
});