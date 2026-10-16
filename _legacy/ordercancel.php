<?

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
	 
$result = mysql_query("select * from receivers where ordernum='$ordernum'", $con);
$total = mysql_num_rows($result);

if ($total) {
	$session = mysql_result($result, 0, "session");
 
	mysql_query("delete from receivers where ordernum='$ordernum'", $con);
	mysql_query("delete from orderlist where session='$session'", $con);
}

echo ("<meta http-equiv='Refresh' content='0; url=mypage.php'>");

mysql_close($con);
	   
?>
