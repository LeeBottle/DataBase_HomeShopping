<?
$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
	
$result = mysql_query("select * from member where uid='$uid'", $con);
$total = mysql_num_rows($result);

if (!$total){
	echo("<script>
		window.alert('아이디가 존재하지 않습니다')
		history.go(-1)
		</script> ");
	 exit;
} else {
	$pass = mysql_result($result, 0, "upass");
	$uname = mysql_result($result, 0, "uname");
	$approved = mysql_result($result, 0, "approved");

	if ($approved == 0) {
		echo("<script>
				window.alert('관리자의 회원 승인이 완료되지 않았습니다')
				history.go(-1)
				</script> ");
		exit;
	} 
		
	if ($pass != $upass) {
		echo("<script>
			window.alert('비밀번호가 맞지 않습니다')
			history.go(-1)
			</script> ");
		exit;
	} else {
		SetCookie("UserID", "$uid", 0);
		SetCookie("UserName", "$uname", 0);
		 
		// $session = md5(uniqid(rand()));
		// SetCookie("Session", $session, 0);
				
		// mysql_query("delete from shoppingbag where id='$uid'", $con);
			 
		echo ("<meta http-equiv='Refresh' content='0; url=index.html'>"); 
	}
}
mysql_close($con);

?>
