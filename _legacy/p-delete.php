<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>


<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>상품삭제<b></font></td>
	<td align=right><font size=4>[<a href=p-adminlist.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<?

$con=mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall", $con);

$result = mysql_query("select * from product where code='$code'", $con);

$name=mysql_result($result,0,"name");
		
echo ("
    <table border=0 width=650 align=center>
	<tr><td width=100 align=center>상품코드</td>
     <td width=550><b>$code</b></td></tr>
	<tr><td align=center>상품이름</td><td><b>$name</b></td></tr>
	<tr><td colspan=2 height=50 align=center valign=center>위 상품을 삭제하시겠습니까?</td></tr> 
	<tr><td colspan=2 align=right><form method=post action=p-delete2.php?code=$code><input style='background-color:orange; border-radius:10px;' type=submit value='삭제 확인'></form></td></tr>

	</table>");
	
mysql_close($con);

?>

</td></tr>
</table>
<? include ("bottom.html");   ?>
