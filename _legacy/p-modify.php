<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>상품수정<b></font></td>
	<td align=right><font size=4>[<a href=p-adminlist.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<?

$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("select * from product where code='$code'", $con);

$class=mysql_result($result,0,"class");
$name=mysql_result($result,0,"name");
$contry=mysql_result($result,0,"contry");
$price1=mysql_result($result,0,"price1");
$price2=mysql_result($result,0,"price2");
$content=mysql_result($result,0,"content");
$userfile=mysql_result($result,0,"userfile");
		
echo ("
    <table align=center border=0 width=650>     
	<form method=post action=p-modify2.php?code=$code enctype='multipart/form-data'>
	<tr><td width=100 align=center>상품코드</td>
	<td width=550><b>$code</b></td></tr>
	<tr><td align=center>상품분류</td>
	<td><select name=class>");

switch($class) {
    case 1:
		echo ("<option value=1 selected>Beef</option>
			<option value=2>Pork</option>
            <option value=3>Chciken</option>
			<option value=4>Others</option>
            <option value=5>Processed</option>");
		break;
	case 2:
		echo ("<option value=1>Beef</option>
			<option value=2 selected>Pork</option>
            <option value=3>Chciken</option>
			<option value=4>Others</option>
            <option value=5>Processed</option>");
		break;
	case 3:
       echo ("<option value=1Beef</option>
			<option value=2>Pork</option>
            <option value=3 selected>>Chciken</option>
			<option value=4>Others</option>
            <option value=5>Processed</option>");
		break;
	case 4:
       echo ("<option value=1>Beef</option>
			<option value=2>Pork</option>
            <option value=3>Chciken</option>
			<option value=4 selected>Others</option>
            <option value=5>Processed</option>");
		break;
	case 5:
       echo ("<option value=1 >Beef</option>
			<option value=2>Pork</option>
            <option value=3>Chciken</option>
			<option value=4>Others</option>
            <option value=5selected>Processed</option>");
		break;
}

echo ("</select></td></tr>
	<tr><td align=center>상품이름</td><td><input type=text name=name size=70 value='$name'></td></tr>
	<tr><td align=center>상품설명</td><td><textarea name=content rows=15 cols=75>$content</textarea></td></tr>
	<tr><td align=center>원산지</td>
		<td>");
if($contry == '국내산'){
	echo("<input type=radio name=contrysl value='국내산' checked='checked'>국내산
		<input type=radio name=contrysl value='수입산'>수입산
		<input type=text name=contry size=15></td></tr>");
}else{
	echo("<input type=radio name=contrysl value='국내산'>국내산
		<input type=radio name=contrysl value='수입산' checked='checked'>수입산
		<input type=text name=contry size=15 value=$contry></td></tr>");
}
echo("		
	<tr><td align=center>정상가격</td><td><input type=text name=price1 size=15 value=$price1>원</td></tr>
	<tr><td align=center>할인가격</td><td><input type=text name=price2 size=15 value=$price2>원</td></tr>
	<tr><td align=center>상품사진</td><td><input type=file size=30 name=userfile><-- $userfile</td></tr>
	<tr><td align=right colspan=2><input style='background-color:orange; border-radius:10px;' type=submit value=수정완료></tr>
	</form>
	</table>");

mysql_close($con);

?>

</td></tr>
</table>
<? include ("bottom.html");   ?>
