<?php 

if ($newnum < 1 || $newnum > 100) {
	echo ("<script>
		window.alert('변경하고자 하는 수량이 범위를 초과합니다')
		history.go(-1)
		</script>");
    exit;
}
	
$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("update shoppingbag set quantity=$newnum where session='$Session' and pcode='$pcode'", $con);

mysql_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=showbag.php'>");

?>
