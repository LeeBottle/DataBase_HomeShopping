<?php
$base = (file_exists("left.php")) ? "./" : "../";
if (!isset($UserID) || !$UserID) { ?>

<table width=170 cellspacing=0 cellpadding=0 align=center>
<tr><td>
<form method=post action=<?php echo $base; ?>member/login.php onsubmit="if(!this.uid.value 
|| !this.upass.value) return false;">
<table style="border: thin solid; border-radius:10px;" border=0 width=170 bgcolor='000000' >
        <tr><td align=right><font color=white style='font-size:12pt;'><b>ID: </b></font></td><td><input type=text size=10 name=uid></td>
		<td rowspan=2 align=center height=50><input type=submit value=Login style='height:50; border-radius:15px; font-weight:bold; background-color:orange;' onMouseover="this.style.color='red'" onMouseout="this.style.color='black'"></td></tr>
		<tr><td align=right><font color=white style='font-size:12pt;'><b>PW: </b></font></td><td><input type=password size=10 name=upass></td></tr>
</form>
</td></tr>

<tr><td align=center colspan=3><a href=<?php echo $base; ?>join.php><font color=white style='font-size:12pt;'onMouseover="this.style.color='red'" onMouseout="this.style.color='white'"><b>회원등록</a>
<font color=white style='font-size:12pt;'> | </font>
<a href=<?php echo $base; ?>member/findidpw.php><font color=white style='font-size:12pt;'onMouseover="this.style.color='red'" onMouseout="this.style.color='white'">비번분실</a></b></font></td></tr>
</table>
</table>

<?php } else { ?>

<table style="border: thin solid; border-radius:10px;" width=170 cellspacing=0 cellpadding=0 align=center bgcolor='000000'>
<?php if ($UserID == "admin") { ?>
	<tr height=85><td align=center><font color=white style='font-size:14pt;'><b>운영자님<br>반갑습니다</b></font></td></tr>
<?php } else { ?>
	<tr height=85><td align=center><font color=white style='font-size:14pt;'><b><?php echo $UserName; ?>님<br>반갑습니다</b></font></td></tr>
<?php } ?>


<tr><td align=center>
	<table><tr><td style="border: thin solid;  border-radius:10px;" width=65 align=center bgcolor=orange><a href=<?php echo $base; ?>mypage/mypage.php><font color=black style='font-size:12pt;' onMouseover="this.style.color='red'" onMouseout="this.style.color='black'"><b>My<br>Page</b></font></a></td>
	<td width=5></td>
	<td style="border: thin solid; border-radius:10px;" width=65 align=center  bgcolor=orange><a href=<?php echo $base; ?>member/logout.php><font color=black style='font-size:12pt;' onMouseover="this.style.color='red'" onMouseout="this.style.color='black'"><b>LOG<br>OUT</b></font></a></td></tr></table>
</td></tr>
<tr><td>

<?php
if ($UserID == "admin") { ?>
	<table width=153 height=50 align=center>
	<tr><td style="border: thin solid; border-radius:10px;" bgcolor='#7794F4' align=center><a href=<?php echo $base; ?>admin/admin.php><font color=black style='font-size:15pt;' onMouseover="this.style.color='red'" onMouseout="this.style.color='black'"><b>관리메뉴</b></font></a></td>
<?php } else { ?>
	<table width=153 height=50 align=center>
	<tr><td style="border: thin solid; border-radius:10px;" bgcolor=orange align=center><a href=<?php echo $base; ?>cart/showbag.php><font color=black style='font-size:15pt;' onMouseover="this.style.color='red'" onMouseout="this.style.color='black'"><b>쇼핑카트</b></font></a></td>
<?php } ?> 
</table>
</td></tr>
</table>

<?php } ?>
<table>
<tr><td align=center><img src="<?php echo $base; ?>time.png" width=90%></td></tr>
<tr><td align=center><img src="<?php echo $base; ?>count.png" width=90%></td></tr>
</table>
