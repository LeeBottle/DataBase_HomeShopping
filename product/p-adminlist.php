<?php  include (__DIR__ . "/../top.php"); 
if (empty($UserID) || $UserID !== 'admin') {
    echo ("<script>
        alert('관리자만 접근 가능한 기능입니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}
?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<?php 

$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);
$result = mysql_query("select * from product order by name", $con);

$total = mysql_num_rows($result);
echo("<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=26% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>상품 목록 조회<b></font></td>
	<td align=right><font size=4>[<a href=../admin/admin.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>");

echo ("<table border=1 width=690>
	<tr><td align=center><font size=2>상품코드</td>
	<td colspan=2 align=center><font size=2>상품명</td>
	<td align=center><font size=2>권장가격</td>
	<td align=center><font size=2>판매가격</td>
	<td align=center><font size=2>원산지</td>
	<td align=center><font size=2>수정/삭제</td></tr>");
							
if (!$total) {

  echo("<tr><td colspan=7 align=center>아직 등록된 상품이 없습니다</td></tr>");

} else {

	$counter = 0;
	
	while ($counter < $total) :

		$code=mysql_result($result,$counter,"code");
		$name=mysql_result($result,$counter,"name");
		$userfile=mysql_result($result,$counter,"userfile");
		$price1=mysql_result($result,$counter,"price1");
		$price2=mysql_result($result,$counter,"price2");
		$contry=mysql_result($result,$counter,"contry");

		echo ("
		   <tr><td width=100 align=center><font size=2>$code</td>
			 <td align=center width=30><img src=../photo/$userfile width=40 height=40 border=0></td>
			   <td width=350 align=left><a href=p-show.php?code=$code><font size=2>$name</a></td>
			   <td align=right width=70><font size=2><strike>$price1&nbsp;원</strike></td>
			   <td align=right width=70><font size=2>$price2&nbsp;원</td>
			  ");
		if($contry == "국내산"){
			echo("
			   <td align=right width=70><font size=2>국내산</td>
			  ");
		}else{
			echo("
			   <td align=right width=70><font size=2>수입산</td>
			");
		}
		echo ("
			   <td width=75 align=center><font size=2><a href=p-modify.php?code=$code>수정</a>/<a href=p-delete.php?code=$code>삭제</a></td></tr>");

		$counter++;
	endwhile;
}

echo ("</table>");
	     
mysql_close($con);

?>

</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
