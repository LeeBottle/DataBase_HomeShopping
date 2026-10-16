<?php
/**
 * 게시판 댓글 삭제 처리 (cdelete.php)
 */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$board = isset($_GET['board']) ? trim($_GET['board']) : 'customer';
$wdate = isset($_GET['wdate']) ? trim($_GET['wdate']) : '';

if (!$id || empty($wdate)) {
    echo ("<script>
        alert('삭제할 댓글 정보가 올바르지 않습니다.');
        history.go(-1);
    </script>");
    exit;
}

$db = getDB();

$stmt = $db->prepare("DELETE FROM boardmemo WHERE id = :id AND wdate = :wdate");
$success = $stmt->execute([
    ':id'    => $id,
    ':wdate' => $wdate
]);

if ($success) {
    echo ("<script>
        alert('댓글이 정상적으로 삭제되었습니다.');
        location.href = 'content.php?board={$board}&id={$id}';
    </script>");
} else {
    echo ("<script>
        alert('댓글 삭제에 실패했습니다.');
        history.go(-1);
    </script>");
}
?>
