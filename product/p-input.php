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

<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>상품등록<b></font></td>
	<td align=right><font size=4>[<a href=../admin/admin.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<table border=0 width=650>
<form method=post action=p-process.php enctype='multipart/form-data'>
<tr>
<td width=100 align=right>상품분류</td>
<td width=550>
	<select name=class>
	<option value=1>Beef</option>
	<option value=2>Pork</option>
	<option value=3>Chicken</option>
	<option value=4>Others</option>
	<option value=5>Processed</option>
	</select>
</td>
</tr>
<tr>
<td align=right>상품코드</td>
<td><input type=text name=code size=20></td>
</tr>
<tr>
<td align=right>상품이름</td>
<td><input type=text name=name size=70></td>
</tr>
<tr>
<td align=right>상품설명</td>
<td><textarea name=content rows=15 cols=75></textarea></td>
</tr>
<tr>
<td align=right>원산지</td>
<td>
	<input type=radio name=contrysl value='국내산'>국내산
	<input type=radio name=contrysl value='수입산'>수입산
	<input type=text name=contry size=15></td>
</tr>
<tr>
<td align=right>정상가격</td>
<td><input type=text name=price1 size=15>원</td>
</tr>
<tr>
<td align=right>할인가격</td>
<td><input type=text name=price2 size=15>원</td>
</tr>
<tr>
<td align=right>상품사진</td>
<td><input type=file size=30 name=userfile></td>
</tr>
<tr>
<td align=right colspan=5>
<input style='background-color:orange; border-radius:10px;' type=submit value=등록하기></td>
</tr>
</form>
</table>

</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
