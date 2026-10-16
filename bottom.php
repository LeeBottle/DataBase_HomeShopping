<?php
$base = (file_exists("bottom.php")) ? "./" : "../";
?>
<table border=0 width=900 cellpadding=0 cellspacing=0>
<tr height=25 bgcolor='#FFDF00' style="outline: thin solid">
	<td width=170 align=center valign=center><font color=orange><b>070-1234-1234</b></font></td>
	<td width=200>&nbsp;</td>
	<td align=right valign=center><a href=<?php echo $base; ?>board/show.php?board=customer><font color=orange style='font-size:13pt;' onMouseover="this.style.color='#E43333'" onMouseout="this.style.color='orange'"><b>고객게시판</b></font></a></td></td>
	<td width=50>&nbsp;</td>
</tr>
<tr>
	<td width=700 align=center valign=center colspan='3'><font style='font-size:8pt;'>Copyright &copy;2021 MARBLE Online Butcher Shop, All Rights Reserved</font>
	</td>
</tr>
</table>
