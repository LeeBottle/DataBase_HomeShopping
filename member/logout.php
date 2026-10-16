<?php
/**
 * 로그아웃 처리 (현대화된 세션 파기)
 */

// 1. 서버 세션 변수 초기화 및 세션 파기
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// 2. 브라우저 쿠키 만료
setcookie("UserID", "", time() - 3600, "/");
setcookie("UserName", "", time() - 3600, "/");
setcookie("Session", "", time() - 3600, "/");

echo ("<script>
    alert('로그아웃 되었습니다.');
</script>
<meta http-equiv='Refresh' content='0; url=../product/p-list.php'>");
?>
