<script   language='JavaScript'>
	function   okzip(zip, address) {
		opener.document.comma.zip.value = zip;
		opener.document.comma.addr1.value =   address;
		opener.comma.addr2.value='';
		opener.comma.addr2.focus();
		self.close();
	}
</script>

<?
$con = mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall", $con);
	
mysql_query("set names 'euckr'");
$result = mysql_query("select * from zipcode where dong like '%$key%'", $con);
$total = mysql_num_rows($result);
	  	
$i = 0;
	
echo ("
	<center>
	<font size=2>[<b>$key</b>]으로 검색한 결과입니다. 우편번호를 선택하세요
	<table border=1 align=center width=420 height=130 cellpadding=3 cellspacing=0>
");
	
while($i <  $total):
	$zip = mysql_result($result, $i, "ZIPCODE");
	$sido = mysql_result($result, $i, "SIDO");
	$gugun = mysql_result($result, $i, "GUGUN");
	$dong = mysql_result($result, $i, "DONG");
	$bunji = mysql_result($result, $i, "BUNJI");

	$address = $sido . " " . $gugun   . " " .  $dong;

	echo ("<tr><td><font size=2>&nbsp;<a href=\"javascript: okzip('$zip',   '$address')\">$zip</a>&nbsp;&nbsp;&nbsp;&nbsp;$sido   $gugun $dong $bunji </td></tr>");
			  
	$i++;
endwhile;

echo ("</table>");
mysql_close($con);

?>
