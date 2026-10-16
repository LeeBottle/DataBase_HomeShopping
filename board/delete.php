<?php 
/**
 * 게시글 삭제 처리 (delete.php)
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($id) ? (int)$id : 0);
$board = isset($_GET['board']) ? trim($_GET['board']) : (isset($board) ? trim($board) : 'customer');

if (!$id) {
    echo ("<script>alert('삭제할 글 번호가 없습니다.'); history.go(-1);</script>");
    exit;
}

$db = getDB();

// 파일명 조회 및 삭제
$stmt = $db->prepare("SELECT filename FROM board WHERE id = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !empty($row['filename'])) {
    $filepath = __DIR__ . '/../pds/' . $row['filename'];
    if (file_exists($filepath)) {
        @unlink($filepath);
    }
}

// 본문 및 댓글 삭제
$delBoard = $db->prepare("DELETE FROM board WHERE id = :id");
$delBoard->execute([':id' => $id]);

$delMemo = $db->prepare("DELETE FROM boardmemo WHERE id = :id");
$delMemo->execute([':id' => $id]);

echo ("<script>
    alert('게시글이 삭제되었습니다.');
    location.href = 'show.php?board={$board}';
</script>");
?>
