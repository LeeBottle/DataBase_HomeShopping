<?php
/**
 * MARBLE House - Front Controller & Modern Router
 * 단일 진입점(Front Controller) 패턴 라우팅
 * 기존 디자인 및 URL 구조를 100% 보존하면서 직관적인 라우트를 지원합니다.
 */

// 요청 라우트 파라미터 (예: ?r=products, ?r=board 등)
$route = isset($_GET['r']) ? trim($_GET['r']) : '';

switch ($route) {
    case 'products':
    case 'product_list':
        require __DIR__ . '/product/p-list.php';
        break;

    case 'product_detail':
    case 'product_show':
        require __DIR__ . '/product/p-show.php';
        break;

    case 'product_search':
        require __DIR__ . '/product/p-search.php';
        break;

    case 'cart':
    case 'showbag':
        require __DIR__ . '/cart/showbag.php';
        break;

    case 'buy':
        require __DIR__ . '/cart/buy.php';
        break;

    case 'board':
    case 'board_list':
        require __DIR__ . '/board/show.php';
        break;

    case 'board_view':
    case 'board_content':
        require __DIR__ . '/board/content.php';
        break;

    case 'board_write':
        require __DIR__ . '/board/input.php';
        break;

    case 'mypage':
        require __DIR__ . '/mypage/mypage.php';
        break;

    case 'admin':
        require __DIR__ . '/admin/admin.php';
        break;

    case 'join':
        require __DIR__ . '/join.php';
        break;

    case 'login':
        require __DIR__ . '/member/login.php';
        break;

    case 'logout':
        require __DIR__ . '/member/logout.php';
        break;

    default:
        // 기본 진입 시 메인 상품 목록으로 자연스럽게 연결
        header("Location: product/p-list.php");
        exit;
}
