<?

if (!$UserID) {
	echo ("<script>
		window.alert('로그인 사용자만 구매 가능합니다')
		history.go(-1)
		</script>");
      exit;
} 
if ($quantity < 1 || $quantity > 100) {
	echo ("<script>
		window.alert('변경하고자 하는 수량이 범위를 초과합니다')
		history.go(-1)
		</script>");
      exit;
}

if (!isset($quantity)) $quantity = 1;

$con =   mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

// 이미 쇼핑백에 담은 물건이면 수량만 보탬 
$result = mysql_query("select * from shoppingbag where session='$Session' and pcode='$code'", $con);
$total = mysql_num_rows($result);

if ($total) $oldnum = mysql_result($result, 0, "quantity");

if ($oldnum) {
     $quantity = $oldnum + $quantity;
     mysql_query("update shoppingbag set quantity=$quantity where   session='$Session' and pcode='$code'", $con);
} else {
     mysql_query("insert into shoppingbag(id, session, pcode, quantity) values ('$UserID','$Session', '$code', $quantity)", $con);
}

mysql_close($con);	//데이터베이스 연결해제

echo ("<meta http-equiv='Refresh' content='0; url=showbag.php'>");

?>
