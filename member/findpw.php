<?php
/**
 * 비밀번호 찾기 (임시 비밀번호 발급 및 해싱 저장)
 */

if (empty($uid) || empty($uname) || empty($email)) {
    echo ("<script>
        alert('아이디, 이름, 이메일을 모두 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

$db = getDB();

$stmt = $db->prepare("SELECT COUNT(*) FROM member WHERE uid = :uid AND uname = :uname AND email = :email");
$stmt->execute([
    ':uid'   => $uid,
    ':uname' => $uname,
    ':email' => $email
]);

if ($stmt->fetchColumn() == 0) {
    echo ("<script>
        alert('입력하신 정보와 일치하는 회원 정보를 찾을 수 없습니다.');
        history.go(-1);
    </script>");
    exit;
}

// 8자리 랜덤 영문/숫자 임시 비밀번호 생성
$temp_pw = substr(bin2hex(random_bytes(4)), 0, 8);
$hashed_temp_pw = password_hash($temp_pw, PASSWORD_DEFAULT);

// DB 업데이트
$updateStmt = $db->prepare("UPDATE member SET upass = :upass WHERE uid = :uid");
$updateStmt->execute([
    ':upass' => $hashed_temp_pw,
    ':uid'   => $uid
]);

echo ("<script>
    alert('고객님의 임시 비밀번호가 발급되었습니다.\\n\\n[ 임시 비밀번호: {$temp_pw} ]\\n\\n로그인 후 마이페이지에서 비밀번호를 꼭 변경해 주세요.');
    location.href = '../product/p-list.php';
</script>");
?>
