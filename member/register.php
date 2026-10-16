<?php
/**
 * 회원가입 처리 (비밀번호 단방향 암호화 및 Prepared Statement 적용)
 */

if (empty($uid)) {
    echo ("<script>
        alert('사용자 ID를 입력하세요.');
        history.go(-1);
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

// 1. 아이디 중복 체크 (Prepared Statement)
$stmt = $db->prepare("SELECT COUNT(*) FROM member WHERE uid = :uid");
$stmt->execute([':uid' => $uid]);
if ($stmt->fetchColumn() > 0) {
    echo ("<script>
        alert('이미 사용 중인 아이디입니다. 다른 아이디를 입력해 주세요.');
        history.go(-1);
    </script>");
    exit;
}

// 2. 비밀번호 현대 단방향 암호화 (Bcrypt 해싱)
$hashed_password = password_hash($upass1, PASSWORD_DEFAULT);

// 기본값 처리
$mphone = isset($mphone) ? trim($mphone) : '';
$email  = isset($email) ? trim($email) : '';
$zip    = isset($zip) ? trim($zip) : '';
$addr1  = isset($addr1) ? trim($addr1) : '';
$addr2  = isset($addr2) ? trim($addr2) : '';

// 3. 안전한 데이터 삽입 (Prepared Statement로 SQL Injection 원천 차단)
$sql = "INSERT INTO member (uid, upass, uname, mphone, email, zipcode, addr1, addr2, approved, point) 
        VALUES (:uid, :upass, :uname, :mphone, :email, :zip, :addr1, :addr2, 1, 1000)";

$stmt = $db->prepare($sql);
$success = $stmt->execute([
    ':uid'   => $uid,
    ':upass' => $hashed_password,
    ':uname' => $uname,
    ':mphone'=> $mphone,
    ':email' => $email,
    ':zip'   => $zip,
    ':addr1' => $addr1,
    ':addr2' => $addr2
]);

if ($success) {
    echo ("<script>
        alert('MARBLE House 회원가입을 축하드립니다!\\n(신규 가입 축하금 1,000 포인트가 적립되었습니다.)');
        location.href = '../product/p-list.php';
    </script>");
} else {
    echo ("<script>
        alert('회원가입 처리에 실패했습니다. 잠시 후 다시 시도해 주세요.');
        history.go(-1);
    </script>");
}
?>
