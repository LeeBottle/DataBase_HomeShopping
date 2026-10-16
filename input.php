<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>
<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>글쓰기<b></font></td>
	<td align=right><font size=4>[<a href=index.html style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>
<?   
echo("
		<form method=post action=process.php?board=$board enctype='multipart/form-data'>
		<table width=690 border=0 align=center>
		<tr>
			<td width=100 align=right>이름 </td>
			<td width=600><input type=text name=writer size=20></td>
		</tr>
		<tr>
			<td align=right>Email </td>
			<td><input type=text name=email size=40></td>
		</tr>
		<tr>
			<td align=right>제목 </td>
			<td><input type=text name=topic size=58></td>
		</tr>
		<tr>
			<td align=right valign=top>내용 </td>
			<td><textarea name=content rows=20 cols=60></textarea></td>
		</tr>
		<tr>
			<td align=right><font size=2>첨부파일</font></td>
			<td><input type=file name='userfile' size=45 maxlength=80></td>
		</tr>
		<tr>
			<td align=right>암호 </td>
			<td><input type=password name=passwd size=15></td>
		</tr>
		<tr>
			<td align=right colspan=2>
			<input type=submit value=등록하기>
			<input type=reset value=지우기>
			<a href=show.php?board=$board><input type=button value='취소'></a></td>
		</tr>
		</table>
		</form>
	</td></tr></table>
");

?>
</td></tr>
</table>
<? include ("bottom.html");   ?>
