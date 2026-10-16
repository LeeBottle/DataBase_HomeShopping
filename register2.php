<?

if (!$upass1) {
	echo ("<script>
		window.alert('비밀번호를 입력해 주세요');
		history.go(-1);
		</script>");
	exit;
}

if ($upass1 != $upass2) {
	echo ("<script>
		window.alert('비밀번호와 비밀번호 확인이 일치하지 않습니다');
		history.go(-1);
		</script>");
	exit;
}

if (!$uname) {
	echo ("<script>
		window.alert('이름을 입력해 주세요');
		history.go(-1);
		</script>");
	exit;
}	

if (!$mphone) {
	echo ("<script>
		window.alert('휴대폰 번호를 입력해 주세요');
		history.go(-1);
		</script>");
	exit;
}	

if (!$email) {
	echo ("<script>
		window.alert('이메일 주소를 입력해주세요');
		history.go(-1);
		 </script>");
	exit;
}	

$con = mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall",   $con);
	
$result = mysql_query("update member set upass='$upass1', uname='$uname', mphone='$mphone', email='$email', zipcode='$zip', addr1='$addr1', addr2='$addr2' where uid='$UserID'", $con);
	
if ($result) {
	echo ("<script>
		window.alert('회원 정보 수정이 완료되었습니다');
		history.go(1);
		 </script>
     ");
} else {
    echo ("<script>
		window.alert('회원 정보 수정에 실패했습니다. 다시 한번 시도해 주세요');
		history.go(-1);
		 </script>
	");	   
}
	
mysql_close($con);
	
echo ("<meta http-equiv='Refresh'  content='0; url=logout.php'>");
	
?>
