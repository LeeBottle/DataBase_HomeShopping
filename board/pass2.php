<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>
<?php 
$con=mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);
$result=mysql_query("select passwd from board where id=$id",$con);
$passwd=mysql_result($result,0,"passwd");

$is_valid = ($pass == $passwd) || (function_exists('password_verify') && password_verify($pass, $passwd));

if (!$is_valid) {            // 암호가 일치하지 않는 경우
	echo   ("<script>
		window.alert('입력 암호가 일치하지 않습니다.');
		history.go(-1);
		</script>");
	exit;		
} else {                  // 암호가 일치하는 경우
    switch ($mode) {
        case 0:          // 수정 프로그램 호출
            echo("<meta   http-equiv='Refresh' content='0; url=modify.php?board=$board&id=$id'>");
            break;
        case 1:          // 삭제 프로그램 호출
            echo("<meta   http-equiv='Refresh' content='0; url=delete.php?board=$board&id=$id'>");
            break;
    }   	   
}  

mysql_close($con);

?>
</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
