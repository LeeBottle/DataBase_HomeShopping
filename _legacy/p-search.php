<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<?

			
if (!$key) {
	echo("<script>
		window.alert('검색어를 입력하세요');
		history.go(-1);
		</script>");
	exit;
}

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$result=mysql_query("select * from product where name like '%$key%' ",$con);
$total = @mysql_num_rows($result);

echo("
   <br>
	<table  width=100% cellspacing=0 >
	<tr><td width=22% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>검색어:$key</b></font></td>
	<td>&nbsp찾은 개수:<b>$total</b> 개</td>
	<td align=right><font size=4>[<a href=show.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=3></td></tr>
   </table>
 <br>
 <table>
");

if (!$total){
	echo("<tr id=t2><td colspan=5 align=center>검색된 상품이 없습니다.</td></tr>");
} else {
	$counter = 0;
	while ($counter < $total &&   $counter < 26 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1 color=green width=100%></td></tr><tr>");

			$code=mysql_result($result,$counter,"code");
			$name=mysql_result($result,$counter,"name");
			$userfile=mysql_result($result,$counter,"userfile");
			$price2=mysql_result($result,$counter,"price2");

			switch(strlen($price2)) {
				case 6: 
				   $price2 = substr($price2, 0, 3) . "," . substr($price2, 3,   3);
				   break;
				case 5:
				   $price2 = substr($price2, 0, 2) . "," . substr($price2, 2,   3);
				   break;
				case 4:
				   $price2 = substr($price2, 0, 1) . "," . substr($price2, 1,   3);
				   break;	   
			}
			
			echo ("<td width=135  align=center><a href=p-show.php?code=$code> <img src='./photo/$userfile' width=100 border=0><br><font color=blue style='text- decoration:none;   font-size:10pt;'>$name</a></font><br>");
			echo ("<font color=red   size=2><b>$price2&nbsp;원</b></font></td>");

			$counter++;
	endwhile;
}
echo ("<table width=690 align=center>
<tr><td width=500 align=right>
<form method=post action=p-search.php?board=$board >
<b>상품검색 </b><input type=text name=key size=20 height=70>
<input type=image src=search.png width=25 height=25 title='검색'>
</td>
</form>
</tr></table>");
echo ("</tr></table>");

	
mysql_close($con);

?>
 
</td></tr>
</table>
<? include ("bottom.html");   ?>
