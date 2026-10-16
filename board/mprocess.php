<?php
/**
 * 게시글 수정 처리 (mprocess.php)
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($id) ? (int)$id : 0);
$board = isset($_GET['board']) ? trim($_GET['board']) : (isset($board) ? trim($board) : 'customer');

$writer  = isset($_POST['writer']) ? trim($_POST['writer']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$topic   = isset($_POST['topic']) ? trim($_POST['topic']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
$passwd  = isset($_POST['passwd']) ? trim($_POST['passwd']) : '';

if (!$id) {
    echo ("<script>
        alert('잘못된 접근입니다.');
        location.href = 'show.php?board={$board}';
    </script>");
    exit;
}

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

// 기존 글 정보 및 파일명 조회
$stmt = $db->prepare("SELECT filename, filesize, passwd FROM board WHERE id = :id");
$stmt->execute([':id' => $id]);
$origin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$origin) {
    echo ("<script>
        alert('존재하지 않는 게시글입니다.');
        history.go(-1);
    </script>");
    exit;
}

$filename = $origin['filename'];
$filesize = $origin['filesize'];

// 신규 첨부파일 업로드 처리
if (!empty($_FILES['userfile']['name']) && !empty($_FILES['userfile']['tmp_name'])) {
    $savedir = __DIR__ . '/../pds';
    if (!is_dir($savedir)) {
        mkdir($savedir, 0777, true);
    }

    // 기존 파일 삭제
    if (!empty($filename) && file_exists("{$savedir}/{$filename}")) {
        @unlink("{$savedir}/{$filename}");
    }

    $filename = basename($_FILES['userfile']['name']);
    $filesize = (string)$_FILES['userfile']['size'];
    move_uploaded_file($_FILES['userfile']['tmp_name'], "{$savedir}/{$filename}");
}

// 비밀번호가 입력된 경우 암호화 업데이트, 미입력 시 기존 비밀번호 유지
if (!empty($passwd)) {
    $hashed_passwd = password_hash($passwd, PASSWORD_DEFAULT);
    $sql = "UPDATE board SET writer = :writer, email = :email, topic = :topic, content = :content, 
            filename = :filename, filesize = :filesize, passwd = :passwd WHERE id = :id";
    $params = [
        ':writer'   => $writer,
        ':email'    => $email,
        ':topic'    => $topic,
        ':content'  => $content,
        ':filename' => $filename,
        ':filesize' => $filesize,
        ':passwd'   => $hashed_passwd,
        ':id'       => $id
    ];
} else {
    $sql = "UPDATE board SET writer = :writer, email = :email, topic = :topic, content = :content, 
            filename = :filename, filesize = :filesize WHERE id = :id";
    $params = [
        ':writer'   => $writer,
        ':email'    => $email,
        ':topic'    => $topic,
        ':content'  => $content,
        ':filename' => $filename,
        ':filesize' => $filesize,
        ':id'       => $id
    ];
}

$updateStmt = $db->prepare($sql);
$success = $updateStmt->execute($params);

if ($success) {
    echo ("<script>
        alert('게시글이 성공적으로 수정되었습니다.');
        location.href = 'content.php?board={$board}&id={$id}';
    </script>");
} else {
    echo ("<script>
        alert('게시글 수정에 실패했습니다.');
        history.go(-1);
    </script>");
}
?>
