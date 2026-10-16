<?php
/**
 * 신규 상품 등록 처리 (p-process.php)
 */

if (empty($UserID) || $UserID !== 'admin') {
    echo ("<script>
        alert('관리자만 접근 가능한 기능입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

$code     = isset($_POST['code']) ? trim($_POST['code']) : '';
$name     = isset($_POST['name']) ? trim($_POST['name']) : '';
$class    = isset($_POST['class']) ? (int)$_POST['class'] : 1;
$contrysl = isset($_POST['contrysl']) ? trim($_POST['contrysl']) : '';
$contry   = isset($_POST['contry']) ? trim($_POST['contry']) : '';
$price1   = isset($_POST['price1']) ? (int)$_POST['price1'] : 0;
$price2   = isset($_POST['price2']) ? (int)$_POST['price2'] : 0;
$content  = isset($_POST['content']) ? trim($_POST['content']) : '';

if (empty($code)) {
    echo ("<script>alert('상품 코드를 입력하세요.'); history.go(-1);</script>");
    exit;
}

if (empty($name)) {
    echo ("<script>alert('상품명을 입력하세요.'); history.go(-1);</script>");
    exit;
}

if (empty($contrysl)) {
    echo ("<script>alert('원산지를 선택하세요.'); history.go(-1);</script>");
    exit;
}

$final_contry = ($contrysl === '수입산') ? $contry : $contrysl;
if ($contrysl === '수입산' && empty($final_contry)) {
    echo ("<script>alert('수입 원산지 국가명을 입력하세요.'); history.go(-1);</script>");
    exit;
}

if ($price1 <= 0 || $price2 <= 0) {
    echo ("<script>alert('상품 가격을 올바르게 입력하세요.'); history.go(-1);</script>");
    exit;
}

$userfile_name = '';

// PHP 8.2 규격 파일 업로드 처리
if (!empty($_FILES['userfile']['name']) && !empty($_FILES['userfile']['tmp_name'])) {
    $savedir = __DIR__ . '/../photo';
    if (!is_dir($savedir)) {
        mkdir($savedir, 0777, true);
    }

    $origin_name = basename($_FILES['userfile']['name']);
    $userfile_name = $origin_name;

    // 중복 파일명 방지
    if (file_exists("{$savedir}/{$userfile_name}")) {
        $ext = pathinfo($origin_name, PATHINFO_EXTENSION);
        $base_name = pathinfo($origin_name, PATHINFO_FILENAME);
        $userfile_name = $base_name . '_' . time() . '.' . $ext;
    }

    move_uploaded_file($_FILES['userfile']['tmp_name'], "{$savedir}/{$userfile_name}");
}

$db = getDB();

// 상품 코드 중복 검증
$checkStmt = $db->prepare("SELECT COUNT(*) FROM product WHERE code = :code");
$checkStmt->execute([':code' => $code]);
if ($checkStmt->fetchColumn() > 0) {
    echo ("<script>alert('이미 사용 중인 상품 코드입니다.'); history.go(-1);</script>");
    exit;
}

$sql = "INSERT INTO product (class, code, name, content, contry, price1, price2, userfile, hit) 
        VALUES (:class, :code, :name, :content, :contry, :price1, :price2, :userfile, 0)";

$stmt = $db->prepare($sql);
$success = $stmt->execute([
    ':class'    => $class,
    ':code'     => $code,
    ':name'     => $name,
    ':content'  => $content,
    ':contry'   => $final_contry,
    ':price1'   => $price1,
    ':price2'   => $price2,
    ':userfile' => $userfile_name
]);

if ($success) {
    echo ("<script>
        alert('상품이 성공적으로 등록되었습니다.');
        location.href = 'p-adminlist.php';
    </script>");
} else {
    echo ("<script>alert('상품 등록에 실패했습니다.'); history.go(-1);</script>");
}
?>
