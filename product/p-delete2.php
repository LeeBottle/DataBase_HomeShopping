<?php
/**
 * 상품 삭제 처리 (p-delete2.php)
 */

if (empty($UserID) || $UserID !== 'admin') {
    echo ("<script>
        alert('관리자만 접근 가능한 기능입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

$code = isset($_POST['code']) ? trim($_POST['code']) : (isset($_GET['code']) ? trim($_GET['code']) : '');

if (empty($code)) {
    echo ("<script>alert('삭제할 상품 코드가 올바르지 않습니다.'); history.go(-1);</script>");
    exit;
}

$db = getDB();

// 기존 이미지 파일명 조회
$stmt = $db->prepare("SELECT userfile FROM product WHERE code = :code");
$stmt->execute([':code' => $code]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product && !empty($product['userfile'])) {
    $filepath = __DIR__ . '/../photo/' . $product['userfile'];
    if (file_exists($filepath)) {
        @unlink($filepath);
    }
}

// 상품 및 상품 리뷰 함께 삭제
$delStmt = $db->prepare("DELETE FROM product WHERE code = :code");
$delStmt->execute([':code' => $code]);

$delMemo = $db->prepare("DELETE FROM productmemo WHERE code = :code");
$delMemo->execute([':code' => $code]);

echo ("<script>
    alert('상품이 정상적으로 삭제되었습니다.');
    location.href = 'p-adminlist.php';
</script>");
?>
