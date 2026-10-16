<?php
$base = (file_exists("top.php")) ? "./" : "../";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>MARBLE House</title>
<style>
    	<!--
        	A:link { text-decoration:none;}
        	A:visited { text-decoration:none;}
        	A:active { text-decoration:none;}
    	-->
		
		
</style>
</head>
<body>
<table width=900 border=1 cellspacing=0 cellpadding=0>
<tr height=200> 
  <td width=900 align=left background="<?php echo $base; ?>topboard.png"  onClick="location.href='<?php echo $base; ?>product/p-list.php'" style="cursor:pointer;"><font style="font-size:35pt; color:white; font-weight:bold">　　　　MARBLE House</td>
</tr>
<tr> 
  <td bgcolor='#FFDF00'>
<table width=900 border=0 cellspacing=0 cellpadding=0>
	<tr height=30>
         <td width=100>&nbsp;</td>
         <td width=100 align=center><a href=<?php echo $base; ?>product/p-list.php?class=1><font color=orange style='font-size:15pt;' onMouseover="this.style.color='#E43333'" onMouseout="this.style.color='orange'"><b>Beef</b></font></a></td>
         <td width=20 align=center><font color=orange>|</font></td>
         <td width=100 align=center><a href=<?php echo $base; ?>product/p-list.php?class=2><font color=orange style='font-size:15pt;' onMouseover="this.style.color='#E43333'"onMouseout="this.style.color='orange'"><b>Pork</b></font></a></td>
         <td width=20 align=center><font color=orange>|</font></td>
         <td width=100 align=center><a href=<?php echo $base; ?>product/p-list.php?class=3><font color=orange style='font-size:15pt;' onMouseover="this.style.color='#E43333'"onMouseout="this.style.color='orange'"><b>Chicken</b></font></a></td>
         <td width=20 align=center><font color=orange>|</font></td>
         <td width=100 align=center><a href=<?php echo $base; ?>product/p-list.php?class=4><font color=orange style='font-size:15pt;' onMouseover="this.style.color='#E43333'" onMouseout="this.style.color='orange'"><b>Others</b></font></a></td>
         <td width=20 align=center><font color=orange>|</font></td>
		 <td width=100 align=center><a href=<?php echo $base; ?>product/p-list.php?class=5><font color=orange style='font-size:15pt;' onMouseover="this.style.color='#E43333'" onMouseout="this.style.color='orange'"><b>Processed</b></font></a></td>
         <td width=20 align=center><font color=orange>|</font></td>		
	    <td width=100>&nbsp;</td>
          </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
