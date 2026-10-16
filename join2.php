<?php include ("top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php include ("left.php"); ?></td>
<td width=720 align=center valign=top>

<!-- 카카오(다음) 도로명/지번 실시간 우편번호 서비스 -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script language='Javascript'>
function id_check() {
    var id = document.comma.uid.value;
    if (id.length < 5) {
        window.alert('ID는 5글자 이상 입력해주세요');
    } else {
        window.open('member/id_check.php?id=' + id, 'IDCHECK', 'width=450, height=180, scrollbars=yes');
    }
}

function go_zip() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            var addr = (data.userSelectedType === 'R') ? data.roadAddress : data.jibunAddress;
            document.comma.zip.value = data.zonecode;
            document.comma.addr1.value = addr;
            document.comma.addr2.value = '';
            document.comma.addr2.focus();
        }
    }).open();
}
</script>

<form action=member/register.php method=post name=comma>

<table width=670 border=0 cellpadding=0 cellspacing=5  align=center>
<tr><td height=40 align=center><b>[회원 가입 폼]</b></td></tr>
</table>

<table border=1 width=670 align=center>
<tr><td>

     <table width=670 border=0 radius=10px align=center>
 <tr>
    <td width=5% align=right>*</td>
	<td width=15%   height=30><font size=2>회원 ID</td>
	<td width=80%><input type=text size=10 name=uid><font size=2>[<a   href='javascript:id_check()'>ID중복검사</a>]</font></td>
 </tr>
 <tr>
	<td   align=right>*</td>
	<td height=30><font size=2>비밀번호</font></td>
	<td><input type=password   maxlength=15 style="height:20;" size=20 name=upass1></td>
 </tr>
 <tr>
	<td align=right>*</td>
	<td height=30><font size=2>비밀번호확인</font></td>
	<td><input type=password   maxlength=15 style="height:20;" size=20 name=upass2></td>
 </tr>
 <tr>
	<td align=right>*</td>
	<td height=30><font size=2>이 름</font></td>
	<td><input type=text size=10 name=uname></td>
 </tr>
 <tr>
	<td align=right>*</td>
	<td height=30><font size=2>휴대전화</font></td>
	<td><input type=text size=20 name=mphone></td>
 </tr>
 <tr>
	<td align=right>*</td>
	<td height=30><font size=2>이메일</td>
	<td><input type=text size=30 name=email></td>
 </tr>
 <tr>
	<td align=right>*</td>
	<td height=30><font size=2>집주소</td>
	<td><input type=text size=7   name=zip readonly=readonly><font size=2>[<a   href='javascript:go_zip()'>우편번호검색</a>]</font><br><input type=text size=50 name=addr1 readonly=readonly><br><input   type=text size=35 name=addr2></td>
</tr>
</table>

  </td></tr>
</table>
  
<table width=670 border=0 cellpadding=0 cellspacing=5  align=center>
<tr><td height=40 align=center><input type=submit value="회원가입신청"></td></tr>
</table>

</form>

</td></tr>
</table>
<?php include ("bottom.php"); ?>
