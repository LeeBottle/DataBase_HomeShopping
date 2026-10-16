<script language='Javascript'>
function a() {
   var id = document.idcheck.newid.value;
   if (id == '') {
        window.alert('아이디를 입력해 주세요!')
   } else {
if (id.length < 5) 
             window.alert('아이디를 5글자 이상 입력해 주세요!')
          else 
             document.idcheck.submit();
   }
}

function b() {
    opener.comma.uid.value = document.idcheck.id.value;
    this.close();
}
</script>

<form method=post action=id_check.php name=idcheck>
<table border=1 align=center width=400>
<tr><td height=130 align=center>

<?

if   (isset($newid)) $id = $newid;

$con = mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall", $con);
	
$result = mysql_query("select * from member where uid='$id'",$con);
$total = mysql_num_rows($result);
	
if ($total == 0) {
echo ("<font size=2 color=red><b>$id</b></font><font size=2> 은(는) 사용 가능한   아이디입니다.<br>사용하시겠습니까?<br><br>[<a href='javascript:b()'> <input type=hidden name=id value='$id'>YES</a>]<br><br>* <b>아이디</b> <input type=text name=newid   size=20>&nbsp;&nbsp;<a href='javascript:a()'>ID중복검사</a>");
} else {
echo "<font size=2 color=red><b>$id</b></font><font size=2> 은(는) 이미 사용중인 아이디입니다.<br>다른 아이디를 입력해 주세요.<br><br><br>* <b>아이디 </b> <input type=text   name=newid size=20>&nbsp;&nbsp;<a href='javascript:a()'>ID중복검사</a>";
}

mysql_close($con);

?>

</td></tr>
</table>
</form>
