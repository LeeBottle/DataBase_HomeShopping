<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<?

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("select * from product where code='$code'", $con);
$total = mysql_num_rows($result);

$name=mysql_result($result,0,"name");
$content=mysql_result($result,0,"content");
$content=nl2br($content);
$contry=mysql_result($result,0,"contry");
$price1=mysql_result($result,0,"price1");
$price2=mysql_result($result,0,"price2");
$userfile=mysql_result($result,0,"userfile");
$per= 100 - (( $price2 / $price1 * 100 ) % 100 );

// 상품의 조회수를 읽어와서 1 증가시킨 다음 업데이트 쿼리를 적용
$hit=mysql_result($result,0,"hit");
$hit++;
mysql_query("update product set hit=$hit where code='$code'", $con);

?>
	<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style="border: thin solid; border-radius:10px;"><font color=white size=5><b>상품 내용<b></font></td>
	<td align=right><font size=4>[<a href=index.html style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>

<?
echo ("
	
	<table width=650 border=0>
    <tr><td width=250 align=center>
	<a href=# onclick=\"window.open('./photo/$userfile', '_new', 'width=450, height=450')\"><img src='./photo/$userfile' width=150 border=1></a></td>
    <td width=400 valign=top>
    <table border=0 width=100%>
	  <tr><td width=80 align=right>상품코드: </td>
	  <td width=320>&nbsp;&nbsp;$code</td></tr>
	  <tr><td align=right>상품이름: </td>
	  <td>&nbsp;&nbsp;$name</td></tr>
	  <tr><td align=right>원산지: </td>
	  <td>&nbsp;&nbsp;$contry</td></tr>
	  <tr><td align=right>상품가격: </td>
	  <td>&nbsp;&nbsp;<strike>$price1&nbsp;원</strike></td></tr>
	  <tr><td align=right>할인가격: </td>
	  <td>&nbsp;&nbsp;<b>$price2&nbsp;원 <font color=red>$per%</b></font></td></tr>
	</table>
	</td>
	</tr>
	</table>	
	<br>
	<table width=650 border=0>
		<tr><td align=center>[상품 상세 설명]</td></tr>
		<tr><td><hr size=1></td></tr>
		<tr><td>$content</td></tr>
	</table>
	<table border=0 width=80%>
    	 <tr><td colspan=2 height=100 valign=bottom align=right>
	     <form method=post action=tobag.php?code=$code>
	     <input type=text size=3 name=quantity value=1>&nbsp;
	     <input style='background-color:orange; border-radius:10px;' type=submit value=담기>
	     </td></tr></form>
	</table> 
");


			
$con =   mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall",   $con);
$result =  mysql_query("select * from productmemo where code='$code' order by wdate desc", $con);
$total =  mysql_num_rows($result);

echo("<table align=center>");
if (!$total)   {
	echo ("<table border=1 align=center cellspacing=0 width=80%><tr id=t1><td>
				<table align=center border=0 width=700>
				<tr id=t1 align=center><td width=50>번호</td><td width=100>이름</td>
				<td width=150>작성일자</td><td width=400>댓글내용</td></tr></td>
				</table>
			</table>
			<table align=center><tr><td>등록된 한줄 리뷰가 없습니다.</td></tr></table>");
		
} 
else{
	echo ("
			<table align=center border=1 cellspacing=0 width=700 align=center>
				<tr align=center>
				<td width=50>번호</td>
				<td width=80>이름</td>
				<td width=150>작성일자</td>
				<td width=300>댓글내용</td>
				<td width=80>별점</td></tr>
	");

	$pagesize =   5;	// 한 페이지에 보여 줄 메모 글의 개수
	if ($mcpage ==  '') $mcpage = 1; 
	$endpage = (int)($total / $pagesize);
	if ( ($total % $pagesize) != 0 ) $endpage = $endpage + 1;
	$i = 0;	
	while ( $i   < $pagesize ) :
		$counter = $pagesize * ($mcpage - 1) + $i;
		if ($counter == $total) break;
		$num=$i+1;
		$name2 = mysql_result($result, $counter, "name");
		$wdate = mysql_result($result, $counter, "wdate");
		$date=substr($wdate,0,16);
		$message = mysql_result($result,   $counter, "message");
		$star = mysql_result($result,   $counter, "star");
		echo ("
			<tr bgcolor=white><td align=center>$num</td><td align=center>$name2</td>
			<td align=center>$date</td><td>$message</td><td>$star 개</td></tr>
		");
		$i++;
	endwhile;
	echo ("</table>");
	}


echo("<form method=post align=center action=p-memo.php>
			<table border=0 align=center>
			<tr><td>
			댓글
			<input type=text size=30 name=wmemo>
			암호
			<input type=password name=wpasswd size=15>&nbsp;&nbsp;</td>
			<td rowspan=2><input type=submit value=등록></td></tr>
			<tr><td align=center><font style='color:#F6D52F; font-size:18px;'>
				<input type=radio name=star value=1>★</option>
				<input type=radio name=star value=2>★★</option>
				<input type=radio name=star value=3>★★★</option>
				<input type=radio name=star value=4>★★★★</option>
				<input type=radio name=star value=5>★★★★★</option></td></tr>
			</select></font>
			</table>
			<input type=hidden name=code value=$code>
			</form>");
?>
</table>
</td></tr>
</table>
<? include ("bottom.html");   ?>
