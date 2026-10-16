<?php
/**
 * 회원 탈퇴 처리 (간소화된 원클릭 처리)
 */

if (empty($UserID)) {
    echo ("<script>
        alert('로그인이 필요한 서비스입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

if ($UserID === 'admin') {
    echo ("<script>
        alert('관리자(admin) 계정은 탈퇴할 수 없습니다.');
        location.href = '../mypage/mypage.php';
    </script>");
    exit;
}

$action = isset($_GET['action']) ? trim($_GET['action']) : '';

if ($action !== 'do') {
    echo ("<script>
        location.href = '../mypage/mypage.php';
    </script>");
    exit;
}

$db = getDB();

// 1. 회원 정보 삭제
$delMember = $db->prepare("DELETE FROM member WHERE uid = :uid");
$delMember->execute([':uid' => $UserID]);

// 2. 장바구니 내역 정리
$delBag = $db->prepare("DELETE FROM shoppingbag WHERE id = :uid");
$delBag->execute([':uid' => $UserID]);

// 3. 세션 및 쿠키 완전 파기
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

setcookie("UserID", "", time() - 3600, "/");
setcookie("UserName", "", time() - 3600, "/");
setcookie("Session", "", time() - 3600, "/");

echo ("<script>
    alert('회원 탈퇴가 완료되었습니다.\\n그동안 이용해 주셔서 감사합니다.');
    location.href = '../product/p-list.php';
</script>");
?>
