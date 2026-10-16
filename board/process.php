<?php
/**
 * 게시글 등록 처리 (Prepared Statement 및 안전한 입력 검증)
 */

$writer  = isset($_POST['writer']) ? trim($_POST['writer']) : (isset($writer) ? $writer : '');
$topic   = isset($_POST['topic']) ? trim($_POST['topic']) : (isset($topic) ? $topic : '');
$content = isset($_POST['content']) ? trim($_POST['content']) : (isset($content) ? $content : '');
$passwd  = isset($_POST['passwd']) ? trim($_POST['passwd']) : (isset($passwd) ? $passwd : '');
$email   = isset($_POST['email']) ? trim($_POST['email']) : (isset($email) ? $email : '');

if (empty($writer)) {
    echo ("<script>
        alert('이름을 입력하세요.');
        history.go(-1);
    </script>");
    exit;
}

if (empty($topic)) {
    echo ("<script>
        alert('제목을 입력하세요.');
        history.go(-1);
    </script>");
    exit;
}

if (empty($content)) {
    echo ("<script>
        alert('내용을 입력하세요.');
        history.go(-1);
    </script>");
    exit;
}

$db = getDB();

// 신규 글 ID 계산
$stmt = $db->query("SELECT COALESCE(MAX(id), 0) + 1 FROM board");
$new_id = (int)$stmt->fetchColumn();

// 첨부파일 처리
$filename = '';
$filesize = '';

if (!empty($_FILES['userfile']['name']) && !empty($_FILES['userfile']['tmp_name'])) {
    $savedir = __DIR__ . '/../pds';
    if (!is_dir($savedir)) {
        mkdir($savedir, 0777, true);
    }
    $filename = basename($_FILES['userfile']['name']);
    $filesize = (string)$_FILES['userfile']['size'];
    move_uploaded_file($_FILES['userfile']['tmp_name'], "{$savedir}/{$filename}");
}

$wdate = date("Y-m-d H:i:s");
$email = isset($email) ? trim($email) : '';
$passwd = isset($passwd) ? trim($passwd) : '';
$board = isset($board) ? trim($board) : 'customer';

// 비밀번호 단방향 암호화
$hashed_passwd = !empty($passwd) ? password_hash($passwd, PASSWORD_DEFAULT) : '';

$insert_sql = "INSERT INTO board (id, writer, email, passwd, topic, content, hit, wdate, space, filename, filesize) 
               VALUES (:id, :writer, :email, :passwd, :topic, :content, 0, :wdate, 0, :filename, :filesize)";

$stmt = $db->prepare($insert_sql);
$stmt->execute([
    ':id'       => $new_id,
    ':writer'   => $writer,
    ':email'    => $email,
    ':passwd'   => $hashed_passwd,
    ':topic'    => $topic,
    ':content'  => $content,
    ':wdate'    => $wdate,
    ':filename' => $filename,
    ':filesize' => $filesize
]);

echo ("<meta http-equiv='Refresh' content='0; url=show.php?board={$board}'>");
?>
