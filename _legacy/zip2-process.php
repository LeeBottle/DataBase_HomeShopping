<script language='JavaScript'>
	function okzip(zip, address) {
		opener.document.buy.zip.value = zip;
		opener.document.buy.addr1.value =   address;
		opener.buy.addr2.value='';
		opener.buy.addr2.focus();
		self.close();
	}
</script>
<?
$con = mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall",   $con);
	
mysql_query("set names   'euckr'");
$result = mysql_query("select * from zipcode where dong like '%$key%'", $con);
$total = mysql_num_rows($result);
	  	
$i = 0;
echo ("<center>
	<font size=2>[<b>$key</b>]으로 검색한 결과입니다. 우편번호를 선택하세요
	<table border=1 align=center   width=420 height=130 cellpadding=3 cellspacing=0>");
	
while($i < $total):
	$zip = mysql_result($result, $i, "ZIPCODE");
	$sido = mysql_result($result, $i, "SIDO");
	$gugun = mysql_result($result, $i,  "GUGUN");
	$dong = mysql_result($result, $i,  "DONG");
	$bunji = mysql_result($result, $i,  "BUNJI");
	$address = $sido .  "&nbsp;" . $gugun . "&nbsp;" .  $dong;

	echo ("<tr><td><font size=2>&nbsp;<a href=\"javascript: okzip('$zip', '$address')\">$zip</a>&nbsp;&nbsp;&nbsp;&nbsp;$address $bunji </td></tr>");
			  
	$i++;
endwhile;

echo ("</table>");
mysql_close($con);
?>
