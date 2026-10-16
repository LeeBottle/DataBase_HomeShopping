<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<?php 
if (empty($UserID)) {
    echo ("<script>
        alert('로그인 사용자만 이용하실 수 있습니다.');
        location.href = '../product/p-list.php';
    </script>");
    exit;
}

$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db', "root", "apmsetup");
mysql_select_db("shopmall",   $con);
$result = mysql_query("select * from member where uid='$UserID'", $con);
	
$uid = mysql_result($result, 0,   "UID");
$uname = mysql_result($result, 0,   "UNAME");
$email = mysql_result($result, 0,   "EMAIL");
$zip = mysql_result($result, 0,   "ZIPCODE");
$addr1 = mysql_result($result, 0,   "ADDR1");
$addr2 = mysql_result($result, 0,   "ADDR2");
$mphone = mysql_result($result, 0,   "MPHONE");
$point = mysql_result($result, 0,   "POINt");

?>
<br>
<table  width=100% cellspacing=0 >
<tr><td width=18% height=20 align=center bgcolor=black style="border: thin solid; border-radius:10px;"><font color=white size=5><b>회원정보<b></font></td>
	<td align=right><font size=4>[<a href=../index.html style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><b>Back</b></a>]</td></tr>
<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
</table>
<br>
<table border=1 cellspacing=0 width=690>
<tr><td width=100><font size=2>이름</td>
<td width=120><font size=2><?php  echo $uname; ?></td>
<td width=80><font size=2>휴대전화</td>
<td width=140><font size=2><?php  echo $mphone; ?></td>
<td width=80><font size=2>이메일</td>
<td width=170><font size=2><?php  echo $email; ?></td></tr>
<tr><td><font size=2>주소</td>
<td colspan=5><font   size=2><?php  echo $zip . " " . $addr1 . " " . $addr2;   ?></td></tr>
<tr><td>현재 포인트</td><td colspan=5><b><?php  echo $point; ?></b>포인트</td></tr>
</table>
<table align=right><tr>
<td><a href=imodify.php style="text-decoration:none;"><button type="button" style='background-color:orange; border-radius:8px; padding:6px 12px; border:1px solid #e08b00; cursor:pointer;'><font color=black><b>회원정보수정</b></font></button></a></td>
<td width=5></td>
<td><button type="button" style='background-color:#cc3333; border-radius:8px; padding:6px 12px; border:1px solid #991111; cursor:pointer;' onclick="if(confirm('정말 탈퇴하시겠습니까? 탈퇴 시 모든 정보는 삭제됩니다.')){ location.href='../member/withdraw.php?action=do'; }"><font color=white><b>회원탈퇴</b></font></button></td>
</tr></table>
<br><br>

<?php 
$result = mysql_query("select * from receivers where id='$UserID' order by buydate desc", $con);
$total = mysql_num_rows($result);

echo ("
	<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>구매내역<b></font></td>
	<td align=right></td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
	<br>

	<table border=1 cellspacing=0 width=690>
	<tr><td align=center><font size=2>구매번호</td>
	<td align=center><font size=2>구매일자</td>
	<td align=center><font size=2>주문내역</td>
	<td align=center><font size=2>금액</td>
	<td align=center><font size=2>주문상태</td></tr>");	

if ($total > 0) {	
	$counter = 0;
	while($counter < $total) :
		$session = mysql_result($result, $counter, "session");
		$buydate = mysql_result($result, $counter, "buydate");
		$ordernum = mysql_result($result, $counter, "ordernum");
		$status = mysql_result($result, $counter, "status");
		$oldstatus = $status;
	 
		switch ($status) {
		  case 1:
				$status = "주문신청";
				break;
		  case 2:
				$status = "주문접수";
				break;
		  case 3: 
				$status = "배송준비중";
				break;
		  case 4:
				$status = "배송중";
				break;
		  case 5:
				$status = "배송완료";
				break;
		  case 6:
				$status = "구매완료";
				break;
		}
	 
		$subresult = mysql_query("select * from orderlist where session='$session'",   $con);
        $subtotal =  mysql_num_rows($subresult);

        $subcounter=0;
        $totalprice=0;

        while ($subcounter <   $subtotal) :
             $pcode = mysql_result($subresult, $subcounter, "pcode");
             $quantity = mysql_result($subresult, $subcounter, "quantity");
      
             $tmpresult = mysql_query("select * from product where code='$pcode'", $con);
             $pname = mysql_result($tmpresult, 0, "name");
			 $price = mysql_result($tmpresult, 0, "price2");
       
             $subtotalprice = $quantity * $price;
             $totalprice = $totalprice + $subtotalprice;
             $subcounter++;
        endwhile;
	
		$items = $subtotal - 1;
	
        echo ("<tr><td align=center><font size=2>
			<a href=# onclick=\"window.open('detailview.php?ordernum=$ordernum', '_new',   'width=940, height=250, scrollbars=yes');\">$ordernum</a></td><td   align=center><font size=2>$buydate</td>
			<td><font size=2>$pname 외 $items 종</td><td align=right><font   size=2>$totalprice 원</td>
			<td align=center><font size=2>$status");
      
		if ($oldstatus < 4) echo ("<br><button style='background-color:orange; border-radius:8px;'><a href=ordercancel.php?ordernum=$ordernum style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'>주문취소</a>");

		echo ("</td></tr>");

		$counter++;
	endwhile;

} else {

	echo ("<tr><td align=center colspan=5><font size=2><b>주문 내역이 존재하지 않습니다</b></td></tr>");

}

echo ("</table>");

mysql_close($con);

?>
	<table width=690 border=0>
	<tr><td>* <font color=red   size=2>주문 물품이 배송 이전 단계이면 온라인으로 주문   취소가 가능합니다.</td></tr>
	<tr><td>* <font size=2>배송중이거나 구매 완료된 제품에 대한 반품 및 환불 요청은     당사 고객센터(전화: 070-4065-8670)로 문의바랍니다.</td></tr>
	</table>

</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
