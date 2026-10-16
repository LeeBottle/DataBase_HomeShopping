<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>글 수정<b></font></td>
	<td align=right><font size=4>[<a href=show.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>


<?php 
$con=mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);

$result=mysql_query("select * from board where id=$id",$con);
$filename = mysql_result($result, 0,  "filename");
// 수정하고자 하는 원본 게시물에서 수정 가능한 항목을 추출함
$writer=mysql_result($result,0,"writer");
$topic=mysql_result($result,0,"topic");
$content=mysql_result($result,0,"content");
$email=mysql_result($result,0,"email");
$filename =mysql_result($result, 0,"filename");
echo("<table align=center id=t2><tr><td>
		<form method=post action=mprocess.php?board=$board&id=$id enctype='multipart/form-data'>
		<table width=700 border=0 align=center>
		<tr>
			<td width=100 align=right>이름 </td>
			<td width=600><input type=text name=writer size=20 value='$writer'></td>
		</tr>
		<tr>
			<td align=right>Email </td>
			<td><input type=text name=email size=40 value='$email'></td>
		</tr>
		<tr>
			<td align=right>제목 </td>
			<td><input type=text name=topic size=60 value='$topic'></td>
		</tr>
		<tr>
			<td align=right valign=top>내용 </td>
			<td><textarea name=content rows=12 cols=60 id=summernote>$content</textarea></td>
		</tr>
		<tr>
			<td align=right>첨부파일</td>
			<td><input type=file name='userfile' size=45 maxlength=80>$filename</td>
		</tr>
		<tr>
			<td align=right>암호 </td>
			<td><input type=password name=passwd size=15></td>
		</tr>
		<tr>
			<td align=right colspan=2>
			<input type=submit value=수정완료>
			<input type=reset value=지우기>
			<a href=show.php?board=$board><input type=button value='취소'></a></td>
		</tr>
		</table>
	</table>
	</form>");

mysql_close($con);

?>
</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
