<?

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("select approved from member where uid='$uid'", $con);
$total = mysql_num_rows($result);

if ($total > 0) {
	$status = mysql_result($result, 0,   "approved");
	if ($status == 0) $status = 1;
	else $status = 0;
} else {
	echo ("<script>
		window.alert('회원 정보 조회에 실패했습니다');
		history.go(1);
		</script>");
	exit;
}

$result = mysql_query("update member set approved=$status where uid='$uid'", $con);

if ($result) {
	switch ($status) {
		case   1:
			echo ("<script>
				  window.alert('승인이 완료되었습니다');
				  history.go(1);
				  </script>");
			break;
		case 0:
			echo ("<script>
				  window.alert('대기 상태로 변경합니다');
				  history.go(1);
				  </script>");
			break;	
	}
} else {
	echo ("<script>
		 window.alert('회원 상태 변경에 실패했습니다');
		 history.go(1);
		</script>");
}	
	
mysql_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=membershow.php'>");

?>
