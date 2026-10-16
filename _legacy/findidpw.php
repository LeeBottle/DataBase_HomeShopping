<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<center><font size=3><b>사용자 ID 찾기</b></center>
<table align=center border=0 width=400>
<form method=post action=findid.php onsubmit="if(!this.uname.value ||   !this.email.value) return false;">
<tr><td align=right><font size=2>이름(실명)</td>
<td align=left><input type=text   size=20 name=uname></td></tr>
<tr><td align=right><font size=2>이메일주소</td>
<td align=left><input type=text   size=40 name=email></td></tr>
<tr><td align=center colspan=2><input type=submit value='아이디 확인'></tr>
</form>
</table>
<br><br>
<center><font size=3><b>사용자 비밀번호 찾기</b></center>
<table align=center border=0 width=400>
<form method=post action=findpw.php onsubmit="if(!this.uid.value ||   !this.uname.value || !this.email.value) return false;">
<tr><td align=right><font size=2>사용자ID</td>
<td align=left><input type=text size=20 name=uid></td></tr>
<tr><td align=right><font size=2>이름(실명)</td>
<td align=left><input type=text size=20 name=uname></td></tr>
<tr><td   align=right><font style='font-size:10pt; font-family:Tahoma;'>이메일주소</td>
<td align=left><input type=text size=40 name=email></td></tr>
<tr><td align=center colspan=2><input type=submit value='비밀번호 확인'></tr>
</form>
</table>

</td></tr>
</table>
<? include ("bottom.html");   ?>
