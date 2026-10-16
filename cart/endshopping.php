<?php
/**
 * 최종 주문 결제 완료 처리 (endshopping.php)
 */

if (empty($UserID)) {
    echo ("<script>alert('로그인이 필요한 서비스입니다.'); location.href = '../product/p-list.php';</script>");
    exit;
}

$receiver = isset($_POST['receiver']) ? trim($_POST['receiver']) : '';
$phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$addr1    = isset($_POST['addr1']) ? trim($_POST['addr1']) : '';
$addr2    = isset($_POST['addr2']) ? trim($_POST['addr2']) : '';
$zip      = isset($_POST['zip']) ? trim($_POST['zip']) : '';
$message  = isset($_POST['message']) ? trim($_POST['message']) : '';
$point    = isset($_POST['point']) ? (int)$_POST['point'] : 0;

if (empty($receiver)) {
    echo ("<script>alert('수신자 이름을 입력해 주세요.'); history.go(-1);</script>");
    exit;
}

if (empty($phone)) {
    echo ("<script>alert('수신자 연락처를 입력해 주세요.'); history.go(-1);</script>");
    exit;
}

if (empty($addr1)) {
    echo ("<script>alert('배송지 주소를 입력해 주세요.'); history.go(-1);</script>");
    exit;
}

$db = getDB();

// 1. 장바구니에 담긴 상품 확인
$bagStmt = $db->prepare("SELECT * FROM shoppingbag WHERE session = :session");
$bagStmt->execute([':session' => $Session]);
$items = $bagStmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($items)) {
    echo ("<script>alert('장바구니가 비어 있습니다.'); location.href = '../cart/showbag.php';</script>");
    exit;
}

// 2. 포인트 적립 계산 (버그 수정: 올바른 기존 포인트 추출 및 누적)
$pointStmt = $db->prepare("SELECT point FROM member WHERE uid = :uid");
$pointStmt->execute([':uid' => $UserID]);
$cur_point = (int)$pointStmt->fetchColumn();
$total_point = $cur_point + $point;

$updatePoint = $db->prepare("UPDATE member SET point = :point WHERE uid = :uid");
$updatePoint->execute([':point' => $total_point, ':uid' => $UserID]);

// 3. 고유 주문번호 생성 (중복 PK 에러 완벽 방지)
$buydate = date("Y-m-d H:i:s");
$ordernum = strtoupper(substr($UserID, 0, 3)) . "-" . date("Ymd") . "-" . substr(md5(uniqid(rand(), true)), 0, 5);

$address = "(" . $zip . ") " . $addr1 . " " . $addr2;

// 4. 주문 수령인 정보 저장
$recStmt = $db->prepare("INSERT INTO receivers (id, session, sender, receiver, phone, address, message, buydate, ordernum, status) 
                         VALUES (:id, :session, :sender, :receiver, :phone, :address, :message, :buydate, :ordernum, 1)");
$recStmt->execute([
    ':id'       => $UserID,
    ':session'  => $Session,
    ':sender'   => $UserName,
    ':receiver' => $receiver,
    ':phone'    => $phone,
    ':address'  => $address,
    ':message'  => $message,
    ':buydate'  => $buydate,
    ':ordernum' => $ordernum
]);

// 5. 상세 주문 품목 내역 저장 (orderlist)
$orderStmt = $db->prepare("INSERT INTO orderlist (id, session, pcode, quantity, ordernum) 
                           VALUES (:id, :session, :pcode, :quantity, :ordernum)");

foreach ($items as $item) {
    $orderStmt->execute([
        ':id'       => $UserID,
        ':session'  => $Session,
        ':pcode'    => $item['pcode'],
        ':quantity' => (int)$item['quantity'],
        ':ordernum' => $ordernum
    ]);
}

// 6. 구매 완료 후 장바구니 비우기
$delBag = $db->prepare("DELETE FROM shoppingbag WHERE session = :session");
$delBag->execute([':session' => $Session]);

// 7. 다음 주문을 위한 새로운 장바구니 세션 토큰 갱신
$_SESSION['Session'] = session_regenerate_id(true) ? session_id() : md5(uniqid());

echo ("<script>
    alert('구매가 정상적으로 처리되었습니다!\\n주문번호: {$ordernum}\\n(적립 포인트: +{$point}P, 누적 포인트: {$total_point}P)\\n\\n[My Page]에서 주문 내역을 확인하실 수 있습니다.');
    location.href = '../mypage/mypage.php';
</script>");
?>
