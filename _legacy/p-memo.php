<?
function check($message) {
	echo ("
		<script>
		window.alert(\"$message\");
		history.go(-1);
		</script>
	");
	exit;
}

if (!$wmemo) {
	check("내용을 입력하세요");
}
if (!$star) {
	check("별점을 입력하세요");
}

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$wdate = date("Y-m-d-H:i:s");

mysql_query("insert into productmemo(name, wdate, message, code, id, passwd, star) values('$UserID', '$wdate', '$wmemo', '$code', '$UserID', '$wpasswd', '$star')", $con);
mysql_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=p-show.php?code=$code'>");

?>
