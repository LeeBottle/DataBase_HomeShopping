<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>배송지 우편번호 검색 결과</title>
<script language='JavaScript'>
	function okzip(zip, address) {
		opener.document.buy.zip.value = zip;
		opener.document.buy.addr1.value = address;
		opener.document.buy.addr2.value = '';
		opener.document.buy.addr2.focus();
		self.close();
	}
</script>
</head>
<body style="background-color:#F7F7F7; margin:10px;">

<?php 
$key = isset($_POST['key']) ? trim($_POST['key']) : (isset($_GET['key']) ? trim($_GET['key']) : '');

$db = getDB();

if (empty($key)) {
    echo ("<center><br><font size=2 color=red>검색할 동 이름을 입력해 주세요.</font><br><br>
          <a href='javascript:history.go(-1)'>[다시 검색]</a></center>");
    exit;
}

$stmt = $db->prepare("SELECT * FROM zipcode WHERE dong LIKE :key");
$stmt->execute([':key' => "%{$key}%"]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($rows);

echo ("<center>
	<font size=2>[<b>" . h($key) . "</b>]으로 검색한 결과입니다. 우편번호를 선택하세요</font><br><br>
	<table border=1 align=center width=420 cellpadding=4 cellspacing=0 bgcolor=white style='border-collapse:collapse; border:1px solid #ccc;'>");

if ($total === 0) {
    echo ("<tr><td align=center><font size=2 color=gray>검색 결과가 없습니다.</font></td></tr>");
} else {
    foreach ($rows as $row) {
        $zip = h($row['zipcode']);
        $sido = h($row['sido']);
        $gugun = h($row['gugun']);
        $dong = h($row['dong']);
        $bunji = h($row['bunji']);
        $address = "{$sido} {$gugun} {$dong}";

        echo ("<tr><td><font size=2>&nbsp;<a href=\"javascript:okzip('{$zip}', '{$address}')\" style='font-weight:bold; color:blue;'>{$zip}</a>&nbsp;&nbsp;&nbsp;&nbsp;{$address} {$bunji}</td></tr>");
    }
}

echo ("</table><br><a href='javascript:history.go(-1)' style='font-size:12px; color:#555;'>[다시 검색하기]</a></center>");
?>
</body>
</html>
