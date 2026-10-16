<?php
/**
 * MARBLE House - 공통 부트스트랩 (모든 PHP 파일 실행 전 자동 호출)
 */

// PHP 8.2 환경에서 불필요한 미정의 변수(Undefined variable) Warning 억제
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', '0');

// 0. 경량 .env 파일 자동 로더
$env_path = __DIR__ . '/../.env';
if (file_exists($env_path)) {
    $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val);
            if (!getenv($key)) {
                putenv("{$key}={$val}");
                $_ENV[$key] = $val;
            }
        }
    }
}

// 1. 현대 데이터베이스 레이어 (PDO) 로드
require_once __DIR__ . '/database.php';

// 2. 세션 시작 (이미 시작되지 않은 경우)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. 고유 장바구니 세션 토큰 유지
if (empty($_SESSION['Session'])) {
    $_SESSION['Session'] = session_id();
}

// 4. 인증 상태 변수 바인딩 (서버 세션 Source of Truth)
$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
$UserName = isset($_SESSION['UserName']) ? $_SESSION['UserName'] : '';
$Session = $_SESSION['Session'];

// 5. URL 파라미터($_GET) 및 폼 데이터($_POST) 안전 수신
// 보안: UserID, UserName, Session 등 핵심 인증/세션 변수는 외부 입력으로 덮어쓰지 못하도록 보호
$protected_vars = ['UserID', 'UserName', 'Session', 'con', 'db', 'stmt'];

if (!empty($_GET)) {
    foreach ($_GET as $k => $v) {
        if (!in_array($k, $protected_vars, true)) {
            $GLOBALS[$k] = $v;
            $$k = $v;
        }
    }
}

if (!empty($_POST)) {
    foreach ($_POST as $k => $v) {
        if (!in_array($k, $protected_vars, true)) {
            $GLOBALS[$k] = $v;
            $$k = $v;
        }
    }
}

// 6. XSS 방어용 안전 출력 헬퍼 함수
if (!function_exists('h')) {
    function h($str) {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}
