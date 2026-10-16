<?php
/**
 * 로그인 처리 (현대화된 세션 인증)
 */

if (empty($uid)) {
    echo ("<script>
        alert('아이디를 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

if (empty($upass)) {
    echo ("<script>
        alert('비밀번호를 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db', "root", "apmsetup");
mysql_select_db("shopmall", $con);

$result = mysql_query("select * from member where uid='$uid'", $con);
$total = mysql_num_rows($result);

if (!$total) {
    echo ("<script>
        alert('아이디가 존재하지 않습니다.');
        history.go(-1);
    </script>");
    exit;
}

$pass = mysql_result($result, 0, "upass");
$uname = mysql_result($result, 0, "uname");
$approved = (int)mysql_result($result, 0, "approved");

if ($approved === 0) {
    echo ("<script>
        alert('관리자의 회원 승인이 완료되지 않았습니다.');
        history.go(-1);
    </script>");
    exit;
}

// 비밀번호 검증 (평문 및 해시 모두 지원)
$is_valid_password = ($pass === $upass) || (function_exists('password_verify') && password_verify($upass, $pass));

if (!$is_valid_password) {
    echo ("<script>
        alert('비밀번호가 맞지 않습니다.');
        history.go(-1);
    </script>");
    exit;
}

// -----------------------------------------------------------------------------
// 서버 사이드 세션(Session) 기반 인증 상태 저장
// -----------------------------------------------------------------------------
$_SESSION['UserID'] = $uid;
$_SESSION['UserName'] = $uname;
$_SESSION['is_admin'] = ($uid === 'admin');

// 하위 호환성을 위한 쿠키 동기화 (전역 경로 '/' 적용)
setcookie("UserID", $uid, 0, "/");
setcookie("UserName", $uname, 0, "/");
setcookie("Session", session_id(), 0, "/");

mysql_close($con);

echo ("<script>
    alert('{$uname}님 환영합니다!');
</script>
<meta http-equiv='Refresh' content='0; url=../product/p-list.php'>");
?>
