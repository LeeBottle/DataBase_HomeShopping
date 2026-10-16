<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<?php 
echo ("<style type='text/css'>
	#t1 { border: 2px solid white; border-radius: 1em; background-color:#615965;}
	table,th,td{ color:white; font-weight:bold; }
			</style>");
			
echo ("
	<table id=t1 align=center><tr><td>
		<form method=post action=cpass2.php?board=$board&id=$id&mode=$mode&wdate=$wdate&wname=$wname&wmemo=$wmemo>
		<table border=0 width=400 align=center>
		<tr><td align=center>암호를 입력하세요</td></tr>
		<tr><td align=center>암호: <input type=password size=15 name='pass'>
		<input type=submit value=입력></td></tr>
		</form>
		</table>
	 </td></tr>
	 </table>
");
?>
</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
