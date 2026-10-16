<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>
<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style="border: thin solid; border-radius:10px;"><font color=white size=5><b>게시판 검색<b></font></td>
	<td align=right><font size=4>[<a href=show.php?board=<?php echo h($board); ?> style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><b>전체목록</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<?php
$board = isset($board) ? trim($board) : 'customer';
$field = isset($_POST['field']) ? trim($_POST['field']) : (isset($_GET['field']) ? trim($_GET['field']) : 'topic');
$key   = isset($_POST['key']) ? trim($_POST['key']) : (isset($_GET['key']) ? trim($_GET['key']) : '');

// 허용된 검색 필드만 허용 (SQL Injection 방지)
$allowed_fields = ['writer', 'topic', 'content'];
if (!in_array($field, $allowed_fields, true)) {
    $field = 'topic';
}

echo ("<style type='text/css'>
	#t1 {border-bottom:2px dotted red; background-color:#27272B; padding:5px; color:white;}
	#t2 {border-bottom:2px dotted red; background-color:#BABABC; padding:5px;}
	#t3 {border-bottom:2px dotted red; background-color:gray; padding-top:5px; padding-bottom:5px;}
	#t4 {color:#F2F2F2; font-size:40px; font-weight:bold; padding:15px;}
	a {text-decoration:none; color:black;}
	a:hover { text-decoration:underline; color:red;}
	.pg {color: white;}
</style>");

$db = getDB();

if (empty($key)) {
    $stmt = $db->query("SELECT * FROM board ORDER BY id DESC");
    $total = $stmt->rowCount();
} else {
    $stmt = $db->prepare("SELECT * FROM board WHERE {$field} LIKE :key ORDER BY id DESC");
    $stmt->execute([':key' => "%{$key}%"]);
    $total = $stmt->rowCount();
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo("
	<table border=0 align=center width=690><tr id=t1><td>
		<table border=0 width=690 align=center>
		<tr id=t1>
		<td align=right width=50><b>번호</b></td>
		<td align=center width=100><b>글쓴이</b></td>
		<td align=center width=400><b>제목</b></td>
		<td align=center width=150><b>날짜</b></td>
		<td align=left width=50><b>조회</b></td>
		</tr></table>
	</table>
	<table border=0 width=690 align=center>
");

if (!$total) {
    echo("<tr id=t2><td colspan=5 align=center><br>[<b>" . h($key) . "</b>]에 대한 검색 결과가 없습니다.<br><br></td></tr>");
} else {
    foreach ($results as $row) {
        $id = (int)$row['id'];
        $writer = h($row['writer']);
        $topic = h($row['topic']);
        $wdate = substr($row['wdate'], 0, 10);
        $hit = (int)$row['hit'];

        // 댓글 수 조회
        $memoStmt = $db->prepare("SELECT COUNT(*) FROM boardmemo WHERE id = :id");
        $memoStmt->execute([':id' => $id]);
        $memoCount = (int)$memoStmt->fetchColumn();

        $commentTag = ($memoCount > 0) ? " [{$memoCount}]" : "";

        echo("
            <tr bgcolor='#BABABC' id=t2>
            <td align=center width=50>{$id}</td>
            <td align=center width=100>{$writer}</td>
            <td align=left width=400><a href=content.php?board=" . h($board) . "&id={$id}>{$topic}{$commentTag}</a></td>
            <td align=center width=150>{$wdate}</td>
            <td align=center width=50>{$hit}</td>
            </tr>
        ");
    }
}

echo ("</table><br>");

// 검색 폼
echo ("<table width=690 align=center>
<tr><td width=500 align=right>
<form method=post action=search.php?board=" . h($board) . ">
<select name=field>
	<option value=topic " . ($field === 'topic' ? 'selected' : '') . ">제목</option>
	<option value=writer " . ($field === 'writer' ? 'selected' : '') . ">글쓴이</option>
	<option value=content " . ($field === 'content' ? 'selected' : '') . ">내용</option>
</select>
<input type=text name=key size=20 value='" . h($key) . "'>
<input type=submit value='▶' style='background-color:orange; border-radius:10px; font-weight:bold; cursor:pointer;'>
</form>
</td>
<td align=right><a href=input.php?board=" . h($board) . "><input type=button value='글쓰기' style='background-color:orange; border-radius:10px; font-weight:bold; cursor:pointer;'></a>
</td></tr></table>");
?>
</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
