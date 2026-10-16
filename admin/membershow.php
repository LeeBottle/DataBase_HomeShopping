<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<?php 

if ($UserID != 'admin') {
	echo ("<script>
		window.alert('관리자만 접근 가능한 기능입니다')
		history.go(-1)
		</script>");
    exit;
} 

$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db', "root", "apmsetup");
mysql_select_db("shopmall",   $con);
	
$result = mysql_query("select * from member order by uname", $con);
$total = mysql_num_rows($result);

echo ("
	<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=26% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>회원 목록 조회<b></font></td>
	<td align=right><font size=4>[<a href=admin.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black''><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table><br> ");
	   
$i = 0;	

echo ("
	<table border=1 cellspacing=0 width=690 bgcolor=white>
	<tr height=35>
	<td align=center width=60><font size=2><b>ID</b></td>
	<td align=center width=50><font   size=2><b>이름</b></td>
	<td align=center width=340><font size=2><b>주소</b></td>
	<td align=center width=100><font size=2><b>전화번호</b></td>
	<td align=center width=100><font size=2><b>이메일</b></td>
	<td align=center width=40><font size=2><b>승인</b></td></tr>
");	

while($i < $total):
	$uid = mysql_result($result, $i, "UID");
	$uname = mysql_result($result, $i, "UNAME");
	$zip = mysql_result($result, $i, "ZIPCODE");
	$addr1 = mysql_result($result, $i, "ADDR1");
	$addr2 = mysql_result($result, $i, "ADDR2");
	$mphone = mysql_result($result, $i, "MPHONE");
	$email = mysql_result($result, $i, "EMAIL");
	$approved = mysql_result($result, $i, "APPROVED");

	$address = "(" . $zip .   ")" . "&nbsp;" . $addr1 . "&nbsp;" .   $addr2;
	
    echo ("<tr height=30><td align=center><font size=2>$uid</td>
		<td align=center><font size=2>$uname</td>
		<td><font size=2>$address</td>
		<td align=center><font size=2>$mphone</td>
		<td align=center><font size=2>$email</td>");
		
	if ($approved == 0) {
		echo ("<td align=center><a href=memberchange.php?uid=$uid><font size=2>대기</a></td></tr>");
	} else {
		echo ("<td align=center><a href=memberchange.php?uid=$uid><font size=2>완료</a></td></tr>");
	}
	      
	$i++;
endwhile;

echo ("</table>");
mysql_close($con);

?>

</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
