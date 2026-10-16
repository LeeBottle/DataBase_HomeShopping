<?

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("delete from shoppingbag where session='$Session' and pcode='$pcode'", $con);

mysql_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=showbag.php'>");

?>
