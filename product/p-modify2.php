<?php
/**
 * 상품 수정 처리 (p-modify2.php)
 */

if (empty($UserID) || $UserID !== 'admin') {
    echo ("<script>
        alert('관리자만 접근 가능한 기능입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

$code     = isset($_POST['code']) ? trim($_POST['code']) : (isset($_GET['code']) ? trim($_GET['code']) : '');
$name     = isset($_POST['name']) ? trim($_POST['name']) : '';
$class    = isset($_POST['class']) ? (int)$_POST['class'] : 1;
$contrysl = isset($_POST['contrysl']) ? trim($_POST['contrysl']) : '';
$contry   = isset($_POST['contry']) ? trim($_POST['contry']) : '';
$price1   = isset($_POST['price1']) ? (int)$_POST['price1'] : 0;
$price2   = isset($_POST['price2']) ? (int)$_POST['price2'] : 0;
$content  = isset($_POST['content']) ? trim($_POST['content']) : '';

if (empty($code)) {
    echo ("<script>alert('상품 코드가 올바르지 않습니다.'); history.go(-1);</script>");
    exit;
}

if (empty($name)) {
    echo ("<script>alert('상품명을 입력하세요.'); history.go(-1);</script>");
    exit;
}

$final_contry = ($contrysl === '수입산') ? $contry : $contrysl;
if (empty($final_contry)) {
    echo ("<script>alert('원산지를 입력하세요.'); history.go(-1);</script>");
    exit;
}

if ($price1 <= 0 || $price2 <= 0) {
    echo ("<script>alert('가격을 올바르게 입력하세요.'); history.go(-1);</script>");
    exit;
}

$db = getDB();

// 기존 상품 조회
$stmt = $db->prepare("SELECT userfile FROM product WHERE code = :code");
$stmt->execute([':code' => $code]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo ("<script>alert('존재하지 않는 상품입니다.'); history.go(-1);</script>");
    exit;
}

$userfile_name = $product['userfile'];
$savedir = __DIR__ . '/../photo';

// 신규 파일 업로드 여부 확인
if (!empty($_FILES['userfile']['name']) && !empty($_FILES['userfile']['tmp_name'])) {
    if (!is_dir($savedir)) {
        mkdir($savedir, 0777, true);
    }

    // 기존 사진 삭제
    if (!empty($userfile_name) && file_exists("{$savedir}/{$userfile_name}")) {
        @unlink("{$savedir}/{$userfile_name}");
    }

    $origin_name = basename($_FILES['userfile']['name']);
    $userfile_name = $origin_name;

    if (file_exists("{$savedir}/{$userfile_name}")) {
        $ext = pathinfo($origin_name, PATHINFO_EXTENSION);
        $base_name = pathinfo($origin_name, PATHINFO_FILENAME);
        $userfile_name = $base_name . '_' . time() . '.' . $ext;
    }

    move_uploaded_file($_FILES['userfile']['tmp_name'], "{$savedir}/{$userfile_name}");
}

$sql = "UPDATE product SET class = :class, name = :name, content = :content, contry = :contry, 
        price1 = :price1, price2 = :price2, userfile = :userfile WHERE code = :code";

$updateStmt = $db->prepare($sql);
$success = $updateStmt->execute([
    ':class'    => $class,
    ':name'     => $name,
    ':content'  => $content,
    ':contry'   => $final_contry,
    ':price1'   => $price1,
    ':price2'   => $price2,
    ':userfile' => $userfile_name,
    ':code'     => $code
]);

if ($success) {
    echo ("<script>
        alert('상품 정보가 성공적으로 수정되었습니다.');
        location.href = 'p-adminlist.php';
    </script>");
} else {
    echo ("<script>alert('상품 정보 수정에 실패했습니다.'); history.go(-1);</script>");
}
?>
