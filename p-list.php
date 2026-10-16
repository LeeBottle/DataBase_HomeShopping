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
 
if   (!isset($class)) $class=0;

switch($class) {
   case 0: 
       $result = mysql_query("select * from product order by hit desc", $con);
		break;
   default:
       $result = mysql_query("select * from product where class=$class order by hit desc", $con);
		break;
}

$total = mysql_num_rows($result);
	
echo   ("<table border=0 cellspacing=0 width=690><tr>");

if (!$total){
	echo ("<td align=center><font color=red>등록된 상품이 없습니다.</td>");
} elseif ($class == 1) {
	echo("<tr><td><img src='cow.png'><font style='font-size:30pt; '><b>Beef</b></td></tr>
		<tr><td bgcolor=orange height=10 colspan=5></td></tr>
		<tr>");
	$counter = 0;
	while ($counter < $total &&   $counter < 16 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1  color=green width=100%></td></tr><tr>");

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
} elseif ($class == 2) {
	echo("<tr><td><img src='pork.png'><font style='font-size:30pt; '><b>Pork</b></td></tr>
		<tr><td bgcolor=orange height=10 colspan=5></td></tr>
		<tr>");
	$counter = 0;
	while ($counter < $total &&   $counter < 16 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1  color=green width=100%></td></tr><tr>");

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
} elseif ($class == 3) {
	echo("<tr><td><img src='chicken.png'><font style='font-size:30pt; '><b>Chicken</b></td></tr>
		<tr><td bgcolor=orange height=10 colspan=5></td></tr>
		<tr>");
	$counter = 0;
	while ($counter < $total &&   $counter < 16 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1  color=green width=100%></td></tr><tr>");

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
} elseif ($class == 4) {
	echo("<tr><td><img src='others.png'><font style='font-size:30pt; '><b>Others</b></td></tr>
		<tr><td bgcolor=orange height=10 colspan=5></td></tr>
		<tr>");
	$counter = 0;
	while ($counter < $total &&   $counter < 16 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1  color=green width=100%></td></tr><tr>");

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
} elseif ($class == 5) {
	echo("<tr><td><img src='processed.png'><font style='font-size:30pt; '><b>Processed</b></td></tr>
		<tr><td bgcolor=orange height=10 colspan=5></td></tr>
		<tr>");
	$counter = 0;
	while ($counter < $total &&   $counter < 16 ) :
		
			if ($counter > 0 && ($counter % 5) == 0 ) echo ("</tr><tr><td colspan=5><hr size=1  color=green width=100%></td></tr><tr>");

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
} else{
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
