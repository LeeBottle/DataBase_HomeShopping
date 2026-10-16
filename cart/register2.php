<?php
/**
 * 회원 정보 수정 처리 (비밀번호 단방향 암호화 적용)
 */

if (empty($UserID)) {
    echo ("<script>
        alert('로그인이 필요한 서비스입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

if (empty($upass1)) {
    echo ("<script>
        alert('비밀번호를 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

if ($upass1 !== $upass2) {
    echo ("<script>
        alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
        history.go(-1);
    </script>");
    exit;
}

if (empty($uname)) {
    echo ("<script>
        alert('이름을 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

$db = getDB();

// 비밀번호 단방향 해싱
$hashed_password = password_hash($upass1, PASSWORD_DEFAULT);

$mphone = isset($mphone) ? trim($mphone) : '';
$email  = isset($email) ? trim($email) : '';
$zip    = isset($zip) ? trim($zip) : '';
$addr1  = isset($addr1) ? trim($addr1) : '';
$addr2  = isset($addr2) ? trim($addr2) : '';

$stmt = $db->prepare("UPDATE member SET upass = :upass, uname = :uname, mphone = :mphone, email = :email, zipcode = :zip, addr1 = :addr1, addr2 = :addr2 WHERE uid = :uid");

$success = $stmt->execute([
    ':upass' => $hashed_password,
    ':uname' => $uname,
    ':mphone'=> $mphone,
    ':email' => $email,
    ':zip'   => $zip,
    ':addr1' => $addr1,
    ':addr2' => $addr2,
    ':uid'   => $UserID
]);

if ($success) {
    // 세션의 회원 이름도 함께 업데이트
    $_SESSION['UserName'] = $uname;
    echo ("<script>
        alert('회원 정보 수정이 완료되었습니다. 보안을 위해 다시 로그인해 주세요.');
        location.href = '../member/logout.php';
    </script>");
} else {
    echo ("<script>
        alert('회원 정보 수정에 실패했습니다. 다시 시도해 주세요.');
        history.go(-1);
    </script>");
}
?>
