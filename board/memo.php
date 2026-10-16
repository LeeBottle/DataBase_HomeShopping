<?php 

function check($message) {
	echo ("
		<script>
		window.alert(\"$message\");
		history.go(-1);
		</script>
	");
	exit;
}

if (!$wname) check("이름을 입력하세요");
if (!$wmemo) check("내용을 입력하세요");
$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db', "root", "apmsetup");
mysql_select_db("shopmall", $con);
$wdate = date("Y-m-d-H:i:s");

mysql_query("insert into boardmemo(name,wdate,message,id,passwd) values('$wname', '$wdate','$wmemo',$id,'$wpasswd')", $con);

mysql_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>");

?>
