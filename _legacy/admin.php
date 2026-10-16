<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<br>
<table  width=100% cellspacing=0 >
<tr><td width=18% height=20 align=center bgcolor=black style="border: thin solid; border-radius:10px;"><font color=white size=5><b>관리 메뉴<b></font></td>
	<td align=right><font size=4>[<a href=index.html style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><b>Back</b></a>]</td></tr>
<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
</table>
<br>
<table border=0 width=100% align=left>
<tr><td><font size=5><b>▶회원관리</b></td>
<tr><td><a href=membershow.php style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><font size=4>&nbsp &nbsp회원 목록 조회</a></td></tr>
<tr><td width=40><font size=8><b>- - - - - - - - - - - - - - - - - - -</b></td></tr>
<tr><td><font size=5><b>▶상품관리</b></td></tr>
<tr><td><a href=p-input.php style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><font size=4>&nbsp &nbsp신규 판매상품 등록</a></td></tr>
<tr><td><a href=orderlist.php style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><font size=4>&nbsp &nbsp주문 내역 조회</a></td></tr>
<tr><td width=40><font size=8><b>- - - - - - - - - - - - - - - - - - -</b></td></tr>
<tr><td><font size=5><b>▶주문관리</b></td></tr>
</tr><td><a href=p-adminlist.php style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><font size=4>&nbsp &nbsp판매상품 수정/삭제</a></td></tr>
</table>

</td></tr>
</table>
<? include ("bottom.html");   ?>
